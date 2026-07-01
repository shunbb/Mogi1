<?php

use Laravel\Fortify\Features;

return [
    'guard' => 'web',
    'middleware' => ['web'],
    'auth_middleware' => 'auth',
    'passwords' => 'users',
    'username' => 'email',
    'email' => 'email',
    'views' => true,
    'home' => '/',
    'prefix' => '',
    'domain' => null,
    'lowercase_usernames' => true,
    'limiters' => [
        'login' => 'login',
        'two-factor' => 'two-factor',
    ],
    'features' => [
        Features::registration(),
        Features::resetPasswords(),
        // Features::emailVerification(),
        Features::updateProfileInformation(),
        Features::updatePasswords(),
        Features::twoFactorAuthentication([
            'confirm' => true,
            'confirmPassword' => true,
            // 'window' => 0,
        ]),
    ],
];