<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    // 🌟 修正：引数に Request $request を追加し、検索キーワードを取得できるようにしました
    public function index(Request $request)
    {
        $keyword = $request->input('search');

        // クエリの基本形を作成
        $query = DB::table('items')
            ->leftJoin('orders', 'items.id', '=', 'orders.item_id')
            ->select('items.*', 'orders.id as order_id');

        // 🌟 追記：もし検索キーワードが入力されていたら、商品名で絞り込み（LIKE検索）
        if (!empty($keyword)) {
            $query->where('items.name', 'LIKE', '%' . $keyword . '%');
        }

        $items = $query->get();
            
        // 🌟 修正：検索キーワードもビューに引き継ぐ（検索窓に文字を残すため）
        return view('index', compact('items', 'keyword'));
    }

    public function show($id)
    {
        $item = DB::table('items')
            ->leftJoin('orders', 'items.id', '=', 'orders.item_id')
            ->select('items.*', 'orders.id as order_id')
            ->where('items.id', $id)
            ->first();

        if (!$item) {
            abort(404);
        }

        $categories = DB::table('item_category')
            ->join('categories', 'item_category.category_id', '=', 'categories.id')
            ->where('item_category.item_id', $id)
            ->select('categories.name')
            ->get();

        $comments = DB::table('comments')
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->where('comments.item_id', $id)
            ->select('comments.*', 'users.name as user_name')
            ->orderBy('comments.created_at', 'asc')
            ->get();

        $likeCount = DB::table('likes')->where('item_id', $id)->count();

        $isLiked = false;
        if (Auth::check()) {
            $isLiked = DB::table('likes')
                ->where('user_id', Auth::id())
                ->where('item_id', $id)
                ->exists();
        }

        return view('show', compact('item', 'categories', 'comments', 'likeCount', 'isLiked'));
    }

    public function purchase($id)
    {
        $item = DB::table('items')
            ->leftJoin('orders', 'items.id', '=', 'orders.item_id')
            ->select('items.*', 'orders.id as order_id')
            ->where('items.id', $id)
            ->first();

        if (!$item) {
            abort(404);
        }

        return view('purchase', compact('item'));
    }

    public function buy(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $request->validate([
            'payment_method' => 'required',
            'postal_code'    => 'required',
            'address'        => 'required',
        ]);

        DB::table('orders')->insert([
            'item_id'         => $id,
            'user_id'         => Auth::id(),
            'payment_method'  => $request->input('payment_method'),
            'postal_code'     => $request->input('postal_code'),
            'address'         => $request->input('address'),
            'building'        => $request->input('building'),
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        session()->forget(['new_postal_code', 'new_address', 'new_building']);

        return redirect('/')->with('success', '商品を購入しました！');
    }

    public function editAddress($id)
    {
        return view('address', compact('id'));
    }

    public function updateAddress(Request $request, $id)
    {
        $request->validate([
            'postal_code' => 'required',
            'address'     => 'required',
        ]);

        session([
            'new_postal_code' => $request->input('postal_code'),
            'new_address'     => $request->input('address'),
            'new_building'    => $request->input('building'),
        ]);

        return redirect('/purchase/' . $id);
    }

    public function create()
    {
        return view('sell');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image'       => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'category'    => 'required|array',
            'condition'   => 'required',
            'name'        => 'required|max:255',
            'description' => 'required',
            'price'       => 'required|integer|min:300|max:9999999',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('item_images', 'public');
            $imagePath = '/storage/' . $path;
        }

        $itemId = DB::table('items')->insertGetId([
            'user_id'     => Auth::id() ?? 1,
            'name'        => $request->input('name'),
            'price'       => $request->input('price'),
            'brand'       => $request->input('brand'), 
            'description' => $request->input('description'),
            'img_url'     => $imagePath,
            'condition'   => $request->input('condition'),
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        $selectedCategories = $request->input('category');

        foreach ($selectedCategories as $categoryName) {
            $category = DB::table('categories')->where('name', $categoryName)->first();

            if ($category) {
                DB::table('item_category')->insert([
                    'item_id'     => $itemId,
                    'category_id' => $category->id,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }

        return redirect('/')->with('success', '商品を出品しました！');
    }

    public function mypage(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $userId = Auth::id();
        $user = Auth::user();

        $sellItems = DB::table('items')
            ->leftJoin('orders', 'items.id', '=', 'orders.item_id')
            ->select('items.*', 'orders.id as order_id')
            ->where('items.user_id', $userId)
            ->get();

        $buyItems = DB::table('orders')
            ->join('items', 'orders.item_id', '=', 'items.id')
            ->select('items.*', 'orders.id as order_id')
            ->where('orders.user_id', $userId)
            ->get();

        $tab = $request->query('page', 'sell');

        return view('mypage', compact('user', 'sellItems', 'buyItems', 'tab'));
    }

    public function storeComment(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $request->validate([
            'comment' => 'required|max:1000',
        ]);

        DB::table('comments')->insert([
            'user_id'    => Auth::id(),
            'item_id'    => $id,
            'comment'    => $request->input('comment'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/item/' . $id)->with('success', 'コメントを投稿しました！');
    }

    public function toggleLike($id)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $userId = Auth::id();

        $like = DB::table('likes')
            ->where('user_id', $userId)
            ->where('item_id', $id);

        if ($like->exists()) {
            $like->delete();
        } else {
            DB::table('likes')->insert([
                'user_id'    => $userId,
                'item_id'    => $id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect('/item/' . $id);
    }
}