<?php namespace App\Http\Controllers\Auth;

use Hash;
use Config;
use Session;
use Validator;
use Auth;
use Mail;
use Input;
use DB;
use Redirect;
use Socialite;

use App\Person;
use App\User;

use App\Http\Requests;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Request as _Request;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	protected $loginPath = '/auth/login';
	protected $redirectAfterLogout = '/auth/login';
	protected $redirectPath = '/';

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest', ['except' => ['getLogout', 'ajaxLogout', 'ajaxChangePassword']]);
		
		ini_set('memory_limit', '-1');
	}

	/**
	 * Logout user.
	 *
	 * @return Response
	 */
    public function getLogout(){
		Session::flush();
		Auth::logout();

		return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : $this->$loginPath);
	}

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
	 * Handle GOOGGLE login.
	 *
	 * @return Response
	 */
    public function handleGoogleCallback()
    {
        try 
        {
        	// Get user data from GOOGLE

            $g_user = Socialite::driver('google')->user();


            $first_name = isset($g_user->user['name']['givenName']) && $g_user->user['name']['givenName'] ? $g_user->user['name']['givenName'] : '';
            $last_name = isset($g_user->user['name']['familyName']) && $g_user->user['name']['familyName'] ? $g_user->user['name']['familyName'] : '';
            $gender = isset($g_user->user['gender']) && $g_user->user['gender'] ? $g_user->user['gender'] : '';

            $email = isset($g_user->email) && $g_user->email ? $g_user->email : '';
            $avatar = isset($g_user->avatar) && $g_user->avatar ? $g_user->avatar : '';

            $person = null;

            if ($email && $email != '') // If email is not blank, check if a person is using it
            	$person = Person::select('people.*')->leftJoin('users', 'users.id', '=', 'people.id')->where('email', $email)->orWhere('username', $email)->first();
            
            if (!$person) { // If no person is using the email yet, save person data
            	$person = new Person;

            	$person->first_name = $first_name;
            	$person->first_name = $last_name;
            	$person->image = $avatar;
				$person->email = $email;

            	if ($gender && $gender != '') // Need to check if gender information is available
            		$person->gender = $gender;

            	$person->save();
            }
            else { // If a person is already using the email, change person data in the database
            	$person->image = (!$person->image || $person->image == '') ? $avatar : $person->image;
            	$person->email = (!$person->email || $person->email == '') ? $email : $person->email;
            	$person->gender = (!$person->gender || $person->gender == '') ? $gender : $person->gender;
            	$person->save();	
            }

            $user = $person->user()->first();

            if (!$user) { // If person has no user account, create its user account
            	$user = new User;

		        $user->id = $person->id;
		        $user->username = $email;
		        $user->password = Hash::make('GooglE_pa$$');
		        $user->signup_via = 'google';

		        $user->save();
            }

            return redirect('auth/login')->with(array('username' => $user->username));
            
        } 
        catch (Exception $e) 
        {
            return redirect('auth/google');
        }
    }

	/*****************/
	/**** AJAX *******/
	/*****************/


	/**
	 * Logout user.
	 *
	 * @return Response
	 */
	public function ajaxLogout(){
		// Clear/flush session
		Session::flush();
		Auth::logout();

		return array('status' => 'OK');
	}

	/**
	 * Change user password.
	 * @param Request
	 * @return Response
	 */
	public function ajaxChangePassword(Request $request) {
		// Get uesr session
		$user = Session::get('user');

		if (!$user)
			return array('status' => 'ERROR', 'error' => 'Something went wrong. Please contact administrator.');  

		// Set the new password and save
		$password = Hash::make($request->password);
		$user->password = $password;
		$user->save();

		return array('status' => 'OK');
	}
}
