@extends('_firestringmaster')

@section('createfirestring')

<h1>Create Firestring</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ url('/createfirestring') }}" method="post" role="form">
    @csrf

    <input type="hidden" name="match_id" value="{{ $match_id }}">

    <div class="form-group">
        <label for="fire_string_number">Fire String Number</label>
        <input type="text" name="fire_string_number" id="fire_string_number" class="form-control" value="{{ old('fire_string_number') }}">
    </div>

    <div class="form-group">
        <label for="distance">Distance</label>
        <select name="distance" id="distance" class="form-control">
            <option>200 Yard Slow Fire</option>
            <option>200 Yard Rapid Fire</option>
            <option>300 Yard Rapid Fire</option>
            <option>600 Yard Slow Fire</option>
        </select>
    </div>

    <div class="form-group"><label>Target Number</label><input type="text" name="target" class="form-control"></div>
    <div class="form-group"><label>Relay Number</label><input type="text" name="relay" class="form-control"></div>

    <div class="form-group">
        <label>Light Direction</label>
        <select name="lightdirection" class="form-control">
            <option>Overhead</option><option>1 O'clock</option><option>2 O'clock</option><option>3 O'clock</option>
            <option>4 O'clock</option><option>5 O'clock</option><option>6 O'clock</option><option>7 O'clock</option>
            <option>8 O'clock</option><option>9 O'clock</option><option>10 O'clock</option><option>11 O'clock</option>
            <option>12 O'clock</option>
        </select>
    </div>

    <div class="form-group">
        <label>Wind Direction</label>
        <select name="winddirection" class="form-control">
            <option>1 O'clock</option><option>2 O'clock</option><option>3 O'clock</option>
            <option>4 O'clock</option><option>5 O'clock</option><option>6 O'clock</option><option>7 O'clock</option>
            <option>8 O'clock</option><option>9 O'clock</option><option>10 O'clock</option><option>11 O'clock</option>
            <option>12 O'clock</option>
        </select>
    </div>

    <div class="form-group"><label>Wind Speed (MPH)</label><input type="text" name="windspeed" class="form-control"></div>
    <div class="form-group"><label>Rifle Elevation</label><input type="text" name="elevation" class="form-control"></div>
    <div class="form-group"><label>Rifle Windage</label><input type="text" name="windage" class="form-control"></div>

    <h3>Shots</h3>

    @for ($i = 1; $i <= 10; $i++)
        <div class="form-group">
            <label>Shot {{ $i }}</label>
            <input type="text" name="shot{{ $i }}value" maxlength="3" size="2" class="form-control" style="max-width:120px;">
        </div>
    @endfor

    <button type="submit" class="btn btn-primary">Create</button>
    <a href="{{ url('/indexfirestring/'.$match_id) }}" class="btn btn-link">Cancel</a>
</form>

@stop
