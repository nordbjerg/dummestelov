<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('home');
});

Route::get('about', function()
{
	return View::make('about');
});

Route::get('login', function()
{
	$facebook = new Facebook(Config::get('facebook'));
	$params = array(
		'redirect_uri' => url('login/fb/callback'),
		'scope' => 'email'
	);

	return Redirect::to($facebook->getLoginUrl($params));
});

Route::get('login/fb/callback', function() {
    $code = Input::get('code');
    if (strlen($code) == 0)
    	return Redirect::intended('/')->with('message', 'Der opstod en fejl i kommunikationen med Facebook');
 
    $facebook = new Facebook(Config::get('facebook'));
    $fb_id = $facebook->getUser();
 
    if ($fb_id == 0)
    	return Redirect::intended('/')->with('message', 'Der opstod en fejl');

    $me = $facebook->api('/me');
 
    $user = User::where('fb_id', '=', $fb_id)->first();
    if (is_null($user)) {
        $user = new User;
        $user->name = $me['first_name'].' '.$me['last_name'];
        $user->email = $me['email'];
        $user->fb_id = $fb_id;
        $user->save();
    }

    Auth::login($user);

    return Redirect::intended('/')->with('message', 'Logget ind med Facebook');
});

Route::get('logout', function()
{
	Auth::logout();

	return Redirect::intended('/');
});