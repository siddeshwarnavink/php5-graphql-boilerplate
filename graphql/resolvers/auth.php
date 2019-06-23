<?php

use Siddeshrocks\Models\User;

use \Firebase\JWT\JWT;
use Respect\Validation\Validator as v;
use Illuminate\Database\Capsule\Manager as DB;

return [
    'login' => function($root, $args) {
        $user = User::where('email', $args['email'])->first();

        if($user) {
            if(password_verify($args['password'], $user->password)) {
                $key = require('./shared/JWTKey.php');

                $jwt = JWT::encode([
                    'user' => $user
                ], $key);

                return [
                    'userId' => $user->id,
                    'token' => $jwt
                ];
            } else {
                throw new Exception('Invalid password!');
            }
        } else {
            throw new Exception('User dosen`t exists!');
        }
    },

    'addUser' => function($root, $args) {
        // AuthRequired($root, true);

        $newUser = new User;
        $newUser->username = $args['username'];
        $newUser->email = $args['email'];
        $newUser->password = password_hash($args['password'], PASSWORD_BCRYPT);

        $newUser->save();
        
        return User::where('id', DB::getPdo()->lastInsertId())->first();
    },

    'validToken' => function($root, $args) {
        $key = require('./shared/JWTKey.php');
        $decoded = JWT::decode($args['token'], $key, array('HS256'));

        if($decoded) {
            $user = User::where('id', $decoded->user->id)->first();
            $jwt = JWT::encode([
                'user' => $user
            ], $key);

            return [
                'newToken' => $jwt,
                'user' => $user
            ];
        }
        
        return false;
    }
];