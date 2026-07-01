<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index()
    {
        $items = DB::table('items')
            ->leftJoin('orders', 'items.id', '=', 'orders.item_id')
            ->select('items.*', 'orders.id as order_id')
            ->get();
            
        return view('index', compact('items'));
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

        return view('show', compact('item'));
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
}