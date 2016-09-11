<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests;
use App\Country;
use App\Events;
use Auth;
use Log;
use Input;
class EventsController extends Controller
{
  	public function __construct() {
		$this->middleware('auth');
	}
	public function index() {
		$events = Events::orderBy('id', 'asc')
		->paginate(10);
		return view('admin.events',[
			'events' => $events,
		]);
	}
	public function create(Request $request) {
		
		// foreach( $request->request as $key => $value) {
			// Log::info($key . "=>" . $value);
				
		// }
		$user = Auth::user();
		$country = Country::where('name', $request->scountry)->first();
		
		$event = new Events;
		$event->country = $country->iso3;
		$event->title = $request->title;
		$event->description = $request->description;
		$event->address = $request->address;
		$event->category = $request->category;
		$event->zip = $request->zip;
		$event->start = $request->start;
		$event->end = $request->end;
		$event->website = $request->website;
		$event->save();

		$events = Events::orderBy('id', 'asc')
		->paginate(10);
		//return redirect()->action('EventsController@index');
		 return view('admin.events',[
			 'events' => $events,
		 ]);
	}

	public function addevent() {
		$countries = Country::orderBy('name', 'asc')->get();

		return view('admin.addevent',[
			'countries' => $countries,
		]);
		
	}
  //
}
