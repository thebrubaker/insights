<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// 6030303570529, 6030303569729, 6030303569129	

use App\Facebook\FacebookRequest;

Route::get('/', function () {
    return view('welcome');
});

Route::get('insights/{id}', 'AdInsightsController@show');
Route::get('weekly/{id}', 'AdInsightsController@weekly');

Route::get('test', function() {
	$facebook = new FacebookRequest;
	$response = $facebook->get()->campaign('6027536110929')->insights(['date_preset' => 'last_7_days']);
	echo $response;
});

Route::get('token', function() {

	$facebook = new \Facebook\Facebook([
		'app_id' => env('FACEBOOK_APP_ID'),
		'app_secret' => env('FACEBOOK_APP_SECRET'),
		'default_graph_version' => 'v2.4'
	]);

	session_start();

	$helper = $facebook->getRedirectLoginHelper();

	$permissions = ['ads_read'];

	$loginUrl = $helper->getLoginUrl('http://insights.app/test', $permissions);

	echo '<a href="' . $loginUrl . '">Get a new Facebook access token</a>';
});
