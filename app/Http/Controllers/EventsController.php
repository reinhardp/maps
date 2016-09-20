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
use DateTime;
use Session;
class EventsController extends Controller
{
	
	protected function _logout() {
		Auth::user()->Logout();
		\Session::flush();			
		return view('auth.login');
	}
  	public function __construct() {
		$this->middleware('auth');
	}
	public function index() {
		if(Auth::user()->adminaccess == 0) {
			return $this->_logout();
		}
		$events = Events::orderBy('id', 'asc')
		//->get();
		->paginate(10);
		$categories = [
					['name' => 'Cat 1', 'value' => 'cat1' ],
					['name' => 'Cat 2', 'value' => 'cat2'],
					];
		$countries = Country::orderBy('name', 'asc')->get();
		return view('admin.events',[
			'events' => $events,
			'countries' => $countries,
			'categories' => $categories,
		]);
	}
	public function create(Request $request) {
		
		if(Auth::user()->adminaccess == 0) {
			return $this->_logout();
		}
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
		$event->lat = $request->lat;
		$event->long = $request->long;
		$event->website = $request->website;
		$event->save();

		$events = Events::orderBy('id', 'asc')
		->paginate(10);
		return redirect()->action('EventsController@index');
	}

	public function addevent() {
		if(Auth::user()->adminaccess == 0) {
			return $this->_logout();
		}
		$countries = Country::orderBy('name', 'asc')->get();
		$categories = [
					['name' => 'Cat 1', 'value' => 'cat1' ],
					['name' => 'Cat 2', 'value' => 'cat2'],
					];
		return view('admin.addevent',[
			'countries' => $countries,
			'categories' => $categories,
		]);
		
	}
	public function hideevent($id) {
		if(Auth::user()->adminaccess == 0) {
			return $this->_logout();
		}
		$event = Events::where('id',$id)->first();
		if($event->state == 'inactive') {
			$event->state = 'active';
		} else {
			$event->state = 'inactive';
		}
			
		
		$event->save();
		$events = Events::orderBy('id', 'asc')
		->paginate(10);
		return redirect()->action('EventsController@index');
		
	}
	public function deleteevent($id) {
		if(Auth::user()->adminaccess == 0) {
			return $this->_logout();
		}
		$event = Events::where('id',$id)->first();
		$event->delete();
		$events = Events::orderBy('id', 'asc')
		->paginate(10);
		return redirect()->action('EventsController@index');
	}
	public function editevent($id) {
		if(Auth::user()->adminaccess == 0) {
			return $this->_logout();
		}
		$event = Events::where('id',$id)->first();
		$country = Country::where('iso3', $event->country)->first();
		$countries = Country::orderBy('name', 'asc')->get();
		$categories = array(
					array('name' => 'cat 1', 'value' =>'cat1' ),
					array('name' => 'cat 2', 'value' =>'cat2')
					);
		
		return view('admin.editevent',[
			'event' => $event,
			'countries' => $countries,
			'eventcountry' => $country->name,
			'categories' => $categories,
		]);
	}
	public function saveevent(Request $request, $id) {
		if(Auth::user()->adminaccess == 0) {
			return $this->_logout();
		}
		$event = Events::where('id',$id)->first();
		$country = Country::where('name', $request->scountry)->first();
		
		$event->country = $country->iso3;
		$event->title = $request->title;
		$event->description = $request->description;
		$event->address = $request->address;
		$event->category = $request->category;
		$event->zip = $request->zip;
		$event->start = $request->start;
		$event->end = $request->end;
		$event->lat = $request->lat;
		$event->long = $request->long;
		
		$event->website = $request->website;
		$event->save();

		$events = Events::orderBy('id', 'asc')
		->paginate(10);
		return redirect()->action('EventsController@index');

		
	}

	public function loadevents() {
		$dt = new DateTime('now');
		$date = $dt->format("Y-m-d");
		$events = Events::orderBy('start', 'asc')
		//->where('start', '>', $date)
		->where([
			['state', '=', 'active'],
			['start', '>', $date],
		])
		->take(10)
		->get();
		if(Auth::user()) {
			Session::put('user', Auth::user()->id);
		}

		$countries = Country::orderBy('name', 'asc')->get();
		$categories = array(
					array('name' => 'cat 1', 'value' =>'cat1' ),
					array('name' => 'cat 2', 'value' =>'cat2')
					);
		return json_encode(array(
				'events' => $events,
				'countries' => $countries,
				'categories' => $categories,
		));
	}
	
	public function map() {
		$events = Events::orderBy('id', 'asc')
		->where('state','active')
		->paginate(10);
		//->get();
		$categories = array(
					array('name' => 'cat 1', 'value' =>'cat1' ),
					array('name' => 'cat 2', 'value' =>'cat2')
					);
		 return view('user.gmap',[
			 'events' => $events,
			 'categories' => $categories,
		 ]);
		
	}
}
