@extends('templates.app')
@section('title')Groups @endsection
@section('content')
<div class="container">
	
    
	<form method="POST" action="/groups/create" class="box">
        @if ($errors->has('slug'))
            <div class="notification is-danger">
                {!! $errors->first('slug') !!}
                <button class="delete"></button>
            </div>
        @endif
		{{csrf_field()}}
		<label class="label">SUBJECT CODE</label>
		<p class="control">
		  <input class="input" placeholder="Enter subject code" name="subject" type="text" value="{{ old('subject') }}">
		  @if($errors->has('subject'))
		  	<span class="help is-danger">{!! $errors->first('subject') !!}</span>
		  @endif
		</p>

        <label class="label">SECTION</label>
        <p class="control">
          <input class="input" placeholder="Enter subject section" name="section" type="text" value="{{ old('section') }}">
          @if($errors->has('subject'))
            <span class="help is-danger">{!! $errors->first('section') !!}</span>
          @endif
        </p>

		<label class="label">ROOM</label>
		<p class="control">
		  <input class="input" placeholder="Enter room name" name="room" type="text" value="{{ old('room') }}">
		  @if($errors->has('room'))
		  	<span class="help is-danger">{!! $errors->first('room') !!}</span>
		  @endif
		</p>
		
		<label class="label">SCHEDULE</label>
		<p class="control">			
			<label class="checkbox is">
			    <input type="checkbox" name="schedule[]" value="1">
			    Monday
			</label>
			
			<label class="checkbox is">
			    <input type="checkbox" name="schedule[]" value="2">
			    Tuesday
			</label>
			
			<label class="checkbox is">
			    <input type="checkbox" name="schedule[]" value="3">
			    Wednesday
			</label>
			
			<label class="checkbox is">
			    <input type="checkbox" name="schedule[]" value="4">
			    Thursday
			</label>
		
			<label class="checkbox is">
			    <input type="checkbox" name="schedule[]" value="5">
			    Friday
			</label>

			<label class="checkbox is">
			    <input type="checkbox" name="schedule[]" value="6">
			    Saturday
			</label>

			@if($errors->has('schedule'))
				<span class="help is-danger">{!! $errors->first('schedule') !!}</span>
			@endif
		</p>
		
		<label class="label">START</label>
		<p class="control">
		  <span class="select">
		    <select name="start">
		      	<option value="7:00">7:00 AM</option>
		      	<option value="7:30">7:30 AM</option>
		       
		      	<option value="8:00">8:00 AM</option>
		      	<option value="8:30">8:30 AM</option>
		       
		      	<option value="9:00">9:00 AM</option>
		      	<option value="9:30">9:30 AM</option>
		       
		      	<option value="10:00">10:00 AM</option>
		      	<option value="10:30">10:30 AM</option>
		       
		      	<option value="11:00">11:00 AM</option>
		      	<option value="11:30">11:30 AM</option>
		       
		      	<option value="12:00">12:00 PM</option>
		      	<option value="12:30">12:30 PM</option>
		       
		      	<option value="13:00">1:00 PM</option>
		      	<option value="13:30">1:30 PM</option>
		       
		      	<option value="14:00">2:00 PM</option>
		      	<option value="14:30">2:30 PM</option>
		       
		      	<option value="15:00">3:00 PM</option>
		      	<option value="15:30">3:30 PM</option>
		       
		      	<option value="16:00">4:00 PM</option>
		      	<option value="16:30">4:30 PM</option>
		       
		      	<option value="17:00">5:00 PM</option>
		      	<option value="17:30">5:30 PM</option>
		       
		      	<option value="18:00">6:00 PM</option>
		      	<option value="18:30">6:30 PM</option>
		       
		      	<option value="19:00">7:00 PM</option>
		      	<option value="19:30">7:30 PM</option>
		       
		      	<option value="20:00">8:00 PM</option>
		    </select>
		  </span>
		</p>

		<label class="label">END</label>
		<p class="control">
		  <span class="select">
		    <select name="end">
		      	<option value="8:00">8:00 AM</option>
		      	<option value="8:30">8:30 AM</option>
		       
		      	<option value="9:00">9:00 AM</option>
		      	<option value="9:30">9:30 AM</option>
		       
		      	<option value="10:00">10:00 AM</option>
		      	<option value="10:30">10:30 AM</option>
		       
		      	<option value="11:00">11:00 AM</option>
		      	<option value="11:30">11:30 AM</option>
		       
		      	<option value="12:00">12:00 PM</option>
		      	<option value="12:30">12:30 PM</option>
		       
		      	<option value="13:00">1:00 PM</option>
		      	<option value="13:30">1:30 PM</option>
		       
		      	<option value="14:00">2:00 PM</option>
		      	<option value="14:30">2:30 PM</option>
		       
		      	<option value="15:00">3:00 PM</option>
		      	<option value="15:30">3:30 PM</option>
		       
		      	<option value="16:00">4:00 PM</option>
		      	<option value="16:30">4:30 PM</option>
		       
		      	<option value="17:00">5:00 PM</option>
		      	<option value="17:30">5:30 PM</option>
		       
		      	<option value="18:00">6:00 PM</option>
		      	<option value="18:30">6:30 PM</option>
		       
		      	<option value="19:00">7:00 PM</option>
		      	<option value="19:30">7:30 PM</option>
		       
		      	<option value="20:00">8:00 PM</option>
		    </select>
		  </span>

		</p>
	
			<p class="control">
				<button class="button is-primary is-fullwidth">Submit</button>
			</p>
	</form>
	</div>

</div>
    
@endsection


