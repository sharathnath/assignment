<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Admin;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Validator;
use App\Models\Constant;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Create a new token.
     *
     * @param  \App\User   $user
     * @return string
     */
    protected function jwt(Admin $admin)
    {
        $payload = [
            'userId' => $admin->id,
            'userRole' => Constant::USER_TYPE_ADMIN
        ];

        // As you can see we are passing `JWT_SECRET` as the second parameter that will
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'));
    }

    public function login_action(Request $request)
    {
        $rules = array('email' => 'required', 'password' => 'required');
        $input = array(
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        );

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return ApiResponse::unprocessableEntity(1, $validator->errors()->first());
        }

        $admin = Admin::query()
            ->where('username', $input['email'])
            ->where('password', md5($input['password']))
            ->first();

        if (empty($admin)) {
            return ApiResponse::unprocessableEntity(2, "Invalid Username or password");
        }

        $data = array(
            'token' => $this->jwt($admin),
            'userData' => array('name' => $admin->name, 'email' => $admin->username, 'userId' => $admin->id),
            'timestamp' => date('Y-m-d H:i:s'),
        );

        return ApiResponse::ok(1, $data, "Authentication Successful");
    }
}
