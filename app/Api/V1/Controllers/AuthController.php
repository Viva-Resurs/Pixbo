<?php

namespace App\Api\V1\Controllers;

use JWTAuth;
use Validator;
use Config;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Tymon\JWTAuth\Exceptions\JWTException;
use Dingo\Api\Exception\ValidationHttpException;
use Dingo\Api\Exception\TokenInvalidException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AuthController extends Controller
{
    use Helpers;

    public function login(Request $request)
    {
        $credentials = $request->only(['name', 'password']);

        $validator = Validator::make($credentials, [
            'name' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails())
            throw new ValidationHttpException($validator->errors()->all());

        try {
            if (!$token = JWTAuth::attempt($credentials))
                return $this->response->errorUnauthorized();
        }
        catch (JWTException $e) {
            return $this->response->error('could_not_create_token', 500);
        }

        return response()->json(compact('token'));
    }

    public function recovery(Request $request)
    {
        $validator = Validator::make($request->only('email'), [
            'email' => 'required'
        ]);

        if($validator->fails())
            throw new ValidationHttpException($validator->errors()->all());

        $user = User::where('email', $request->only('email'))->first();

        $response = Password::sendResetLink($request->only('email'), function (Message $message) use ($user) {
            $token = Password::createToken( $user );
            $message->from( 'pixbo@viva.se' );
            $message->subject('Password Reset @ Pixbo');
            $message->setBody( view('auth.emails.password',['token'=>$token,'user'=>$user]) );
        });

        switch ($response) {
            case Password::RESET_LINK_SENT:
                return $this->response->noContent();
            case Password::INVALID_USER:
                return $this->response->errorNotFound();
        }
    }

    public function reset(Request $request)
    {
        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $validator = Validator::make($credentials, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        if($validator->fails())
            throw new ValidationHttpException($validator->errors()->all());

        $response = Password::reset($credentials, function ($user, $password) {
            $user->password = $password;
            $user->save();
        });

        switch ($response) {
            case Password::PASSWORD_RESET:
                //if(Config::get('boilerplate.reset_token_release')) {
                //    return $this->login($request);
                //}
                return $this->response->noContent();

            default:
                return $this->response->error('could_not_reset_password', 500);
        }
    }

    public function token(){

        $token = JWTAuth::getToken();

        if (!$token)
            throw new BadRequestHttpException('Token not provided');

        try {
            $token = JWTAuth::refresh($token);
        }
        catch(TokenInvalidException $e){
            throw new AccessDeniedHttpException('The token is invalid');
        }

        return $this->response->withArray(['token'=>$token]);
    }

}
