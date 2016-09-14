@extends('layouts.app')
@section('content')
@include('common.errors')
<script>
	var arr = Array();
	function edit(id) {
		if(arr.length>0) {
			for(i = 0;i < arr.length;i++){
				var inl = 'inline_' + arr[i];
				obj = document.getElementById(inl);
				obj.style.display = 'none';
			}
		}
		arr.push(id);
		var obj = 'inline_' + id;
		$('#' + obj).show();
	}
	function hide(id) {
		var inl = 'inline_' + id;
		obj = document.getElementById(inl);
		obj.style.display = 'none';
	}
	function cancel(id) {
		var inl = 'inline_' + id;
		obj = document.getElementById(inl);
		obj.style.display = 'none';
	}
	function deleteevent(id)
	{
		var r = confirm('Are you sure?');
		if(r == true) {
			url = "{{ url('/admin/deleteevent/') }}"; 
			url = url + '/' + id;
			var x = 1;
			$.ajax({
				url: url,
				type: 'get',
				success: function( data, textStatus, jQxhr ){
					window.open("{{ url('/admin/events') }}","_self");
					var x = 1;
				},
				error: function( jqXhr, textStatus, errorThrown ){
					console.log( errorThrown );
				}
			});

		}
	}
</script>
<div class="container">


<div class="table-responsive">
<table class="table table-sm">
	<thead>
	</thead>
	<tbody>
	@foreach ($events as $event)
	<tr class="table-text active">
		<td class="table-text">{{'Event ' . $event->id . ' /' . $event->country  . ' ' . date_format(date_create($event->start), 'd.m') . ' - ' . date_format(date_create($event->end), 'd.m.Y') }} </td>
		<td class="table-text"> </td>
		<td class="table-text"> </td>
		<td class="table-text"> </td>
		<td class="table-text"><button type="submit" class="btn btn-default" id="edit" onclick="edit({{ $event->id }});">edit</button></td>
		<td class="table-text">
			@if($event->state == 'active')
				<a id="delete" class="btn btn-default" href="{{ url('/admin/hideevent/' . $event->id ) }}">hide</a>
			@else
				<a id="delete" class="btn btn-default" href="{{ url('/admin/hideevent/' . $event->id ) }}">unhide</a>
			@endif
		</td>
		<td class="table-text"><a id="delete" class="btn btn-default" href="#" onclick="deleteevent({{ $event->id  }});" >delete</a></td>
	</tr>
	<tr id="{{'inline_' . $event->id}}" class="{{'inline_' . $event->id}}" style="display: none;" class="active">
		<td colspan="7" class="active">
			<form action="{{ url('admin/saveevent/' .$event->id ) }}" method="POST" class="form-horizontal" >
				{!! csrf_field() !!}
				
				<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
					<label for="title" class="col-sm-3 control-label">title</label> 
					<div class="col-sm-6">
						<input type="text" name="title" id="title" class="form-control" placeholder="title" value="{{ $event->title }}">
					</div>
				</div>
				<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
					<label for="description" class="col-sm-3 control-label">description</label> 
					<div class="col-sm-6">
						<textarea  rows="5" cols="50" name="description" id="description" class="form-control" placeholder="description" >{{ $event->description }} </textarea>
					</div>
				</div>
				<div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
					<label for="address" class="col-sm-3 control-label">address</label>
					<div class="col-sm-6">
						<input type="text" name="address" id="address" class="form-control" placeholder="address" value="{{ $event->address }}">
					</div>
				</div>
				<div class="form-group{{ $errors->has('zip') ? ' has-error' : '' }}">
					<label for="zip" class="col-sm-3 control-label">zip code</label>
					<div class="col-sm-6">
						<input type="text" name="zip" id="zip" class="form-control" placeholder="zip" value="{{ $event->zip }}">
					</div>
				</div>
				<div class="form-group{{ $errors->has('start') ? ' has-error' : '' }}">
					<label for="start" class="col-sm-3 control-label">start date</label>
					<div class="col-sm-6">
						<input type="date" name="start" id="start" class="form-control" value="{{ $event->start }}">
					</div>
				</div>
				<div class="form-group{{ $errors->has('end') ? ' has-error' : '' }}">
					<label for="end" class="col-sm-3 control-label">end date</label>
					<div class="col-sm-6">
						<input type="date" name="end" id="end" class="form-control" value="{{ $event->end }}">
					</div>
				</div>
				<div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
					<label for="category" class="col-sm-3 control-label">category</label>
					<div class="col-sm-6">
						<select name="category" id="category" class="category">
							<option value="cat1">cat 1</option>
							<option value="cat2">cat 2</option>
						</select>
					</div>
				</div>
				<div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
					<label for="country" class="col-sm-3 control-label">country</label>
					<div class="col-sm-6">
						<input type="text" list="country" name="scountry" id="scountry" value="{{ App\Country::where('iso3', $event->country)->first()->name }}" />
						<datalist name="country" id="country" class="country" >
							<option value=""></option>
							@foreach($countries as $country)
								<option value="{{ $country->name }}">{{ $country->name }}</option>
							@endforeach
						</datalist>
					</div>
				</div>
				<div class="form-group{{ $errors->has('website') ? ' has-error' : '' }}">
					<label for="website" class="col-sm-3 control-label">website</label>
					<div class="col-sm-6">
						<input type="text" name="website" id="website" class="form-control" placeholder="website" value="{{ $event->website }}">
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-6">
						<button type="submit" class="btn btn-default">
						save
						</button>
						<a href="#" class="btn btn-default" onclick="cancel({{ $event->id }})">
						cancel
						</a>
					</div>
				</div>	
			</form>
			
		</td>
	</tr>
	@endforeach
	</tbody>
</table>
</div>
<div class="btn btn-default btn-block" >
	<a  class="btn btn-default" href="{{ url('/admin/addevent') }}" >Add new event</a>
</div>
{{ $events->links() }}
</div>
@endsection