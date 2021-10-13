<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(LoginRequest $request)
    {
        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        if ($fieldType === 'email')
            $this->validate($request, ['username' => 'email']);

        if (Auth::attempt([
            $fieldType => $request->username,
            'password' => $request->password,
        ], $request->remember)) {
            return redirect($this->redirectPath());
        } else {
            if ($fieldType === 'name')
                $fieldType = 'user' . $fieldType;

            return redirect()
                ->route('login')
                ->withErrors(['username' => Str::ucfirst($fieldType) . ' and password are wrong']);
        }
    }

    protected function redirectTo()
    {
        if (Auth::user()->roles->isEmpty())
            return route('home.index');

        return route('admin.dashboard');
    }
}
