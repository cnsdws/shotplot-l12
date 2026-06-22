@extends('_firestringmaster')

@section('title')
<title>Add Adjustment</title>
@stop

@section('editfirestring')

<h3>Add Adjustment - Firestring {{ $firestring->fire_string_number }}</h3>

<form method="POST" action="/firestrings/{{ $firestring->id }}/adjustments">
    @csrf

    <div class="form-group">
        <label>Shot Number</label>
        <input type="number" name="shot_number" class="form-control" min="1" max="{{ $firestring->shot_count }}">
    </div>

    <div class="form-group">
        <label>Elevation Setting</label>
        <input type="number" name="elevation_setting" class="form-control" value="{{ $firestring->elevation }}">
    </div>

    <div class="form-group">
        <label>Windage Setting</label>
        <input type="number" name="windage_setting" class="form-control" value="{{ $firestring->windage }}">
        <p class="text-muted">Use negative for left, positive for right. Example: -2 = 2L, 3 = 3R.</p>
    </div>

    <div class="form-group">
        <label>Notes</label>
        <textarea name="notes" class="form-control" rows="4"></textarea>
    </div>

    <button class="btn btn-primary">Save</button>
    <a href="/firestrings/{{ $firestring->id }}/adjustments" class="btn btn-default">Cancel</a>
</form>

@stop
