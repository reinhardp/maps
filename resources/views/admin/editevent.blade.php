@extends('layouts.app')
@section('content')
	@include('common.errors')
<script>
	function selectcountry(data) {
		alert(data);
	}
	
</script>
	<div class="panel-body">
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
					<input type="text" list="country" name="scountry" id="scountry" value="{{ $eventcountry }}" />
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
				</div>
			</div>	
		</form>
	</div>

@endsection