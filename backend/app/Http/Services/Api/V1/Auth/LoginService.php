<?php

namespace App\Http\Services\Api\V1\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginService
{
    public function login(Request $request)
    {
        $loginField = request()->input('login');

        $credentials = null;

        $loginType = filter_var($loginField, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $user = User::where('email', '=', $loginField)->orWhere('phone', '=', $loginField)->first();

        if ($user == null)
        {
            throw new HttpException((int)Response::HTTP_BAD_REQUEST, "Email does not exists on record");

        }else{

            
            if (Hash::check($request->password, $user->password))
            {
                request()->merge([$loginType => $loginField]);

                $credentials = request([$loginType, 'password']);

                if (!$token = JWTAuth::attempt($credentials))
                {

                    throw new HttpException((int) Response::HTTP_UNAUTHORIZED, "Unauthorized");

                }else{

                    if ($request->device_token)
                    {
                        User::where('email', $request->email)->update(['device_token' => $request->device_token]);
                    }

                    activity('Login')
                        ->performedOn($user)
                        ->causedBy(Auth::user())
                        ->withProperties(['attributes' => $request->all()])
                        ->log('Login Successful');

                    return $this->respondWithToken($token);
                }
            }else{

                throw new HttpException((int)Response::HTTP_BAD_REQUEST, "Password is incorrect");
            }
           
           
        }
    }

    public function logout(Request $request)
    {
        $token = $request->header('Authorization');

        // Ensure token starts with 'Bearer '
        if (strpos($token, 'Bearer ') === 0) {
            $token = str_replace('Bearer ', '', $token);
        }

        try {
            // Invalidate the token
            JWTAuth::invalidate($token);

            // Log the logout activity
            activity('logout')
                ->causedBy(Auth::user())
                ->log('Logout Successful');

            return response()->json(['message' => 'Logout successful'], 200);

        } catch (JWTException $e) {
            // Return a proper error response
            return response()->json([
                'message' => 'Failed to logout. Token may already be invalidated.',
                'error' => $e->getMessage()
            ], 400);
        }
    }

     /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $data = [
            'user' => Auth::user(),
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60
        ];

        return $data;
    }

     /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}