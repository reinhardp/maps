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
Route::auth();
Route::post('auth/login', 'Auth\AuthController@postLogin');

Route::get('/', function () {
	// if(Auth::user()) {
		
		// if(Auth::user()->adminaccess == 1) {
			// $user = 'Admin';
			// $events = array();
			// return view('admin.events',[
				// 'events' => $events,
				// 'user' => $user,
			// ]);
		// } elseif(Auth::user()->adminaccess == 0) { 
			// $events = array();
			// $user = 'hallo';
			// return view('user.events',[
				// 'events' => $events,
				// 'user' => $user,
			// ]);
		
		// }
	//}
    return view('welcome');
});

	Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
		Route::get('/events', 'EventsController@index');
		Route::get('/addevent', 'EventsController@addevent');
		Route::post('/createevent', 'EventsController@create');
		Route::get('/editevent/{event}', 'EventsController@editevent');
		Route::get('/hideevent/{event}', 'EventsController@hideevent');
		Route::get('/deleteevent/{event}', 'EventsController@deleteevent');
		Route::post('/saveevent/{event?}', 'EventsController@saveevent');
		
	 });

	Route::group(['prefix' => 'user', 'middleware' => 'auth'], function() {	 
		Route::get('/map', 'EventsController@map');
		Route::get('/loadevents','EventsController@loadevents');

	 });

Route::get('/home', 'HomeController@index');

