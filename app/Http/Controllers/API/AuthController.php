<?php

namespace App\Http\Controllers\API;

use App\Exceptions\APIException;
use App\Http\Controllers\Controller;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (!auth()->attempt($request->only(['email', 'password']))) :
            throw new APIException('Invalid credential');
        endif;

        $additionalAttribute = [
            'token' => $request->user()->createToken(md5(microtime()))->accessToken,
        ];

        return [
            'payload' => fractal($request->user(), new UserTransformer($additionalAttribute)),
        ];
    }

    public function logout()
    {
        if (Auth::check()) :
            $token = Auth::user()->token();

            if ($token->revoke()) :
                return [
                    'payload' => 'Logout Successfully'
                ];
            endif;
        endif;

        return [
            'payload' => 'Logout Failed'
        ];
    }
}
