<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{


    use RegistersUsers;

    /**
     * @var string
     */
    protected $redirectTo = '/login'; 

    /**

     * @return void
     */
    public function __construct()
    {

    }

    /**

     * @param  array  
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
                'regex:/^[A-Za-z0-9._%+-]+@gmail\.com$/'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[!@#$%^&*(),.?":{}|<>]/'
            ],
        ], [
            'email.regex' => 'Email phải đúng định dạng @gmail.com.',
            'email.unique' => 'Email này đã được đăng ký.',
            'password.regex' => 'Mật khẩu phải có ít nhất một ký tự đặc biệt.',
        ]);
    }

    /**
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    protected function registered($request, $user)
    {
        $this->guard()->logout();
        return redirect()->route('register')->with('success', 'Đăng kí thành công, bạn sẽ được chuyển về trang đăng nhập');
    }
}
