@extends('layouts.app')
@section('content')
@include('common.errors')

<div class="panel-body">
	<a  class="btn btn-default" href="{{ url('/admin/addevent') }}" >Add Event</a>
	<div></div>
	@foreach ($events as $event)
		<div class="col-sm-2"></div>
		<div lass="col-sm-4">{{'Event ' . $event->id . ' /' . $event->country  . ' ' . date_format(date_create($event->start), 'd.m') . ' - ' . date_format(date_create($event->end), 'd.m.Y') }} 
		<a id="edit" class="btn btn-default" href="{{ url('/admin/editevent/' . $event->id ) }}" >edit</a> 
		<a id="hide" class="btn btn-default" href="{{ url('/admin/hideevent/' . $event->id ) }}">hide</a> 
		<a id="delete" class="btn btn-default" href="{{ url('/admin/deleteevent/' . $event->id ) }}">delete</a> 
		</div>
	@endforeach
</div>

@endsection