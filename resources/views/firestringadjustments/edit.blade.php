@extends('_firestringmaster')

@section('title')
<title>Edit Adjustment</title>
@stop

@section('editfirestring')

<h3>Edit Adjustment</h3>

<form method="POST" action="/firestring-adjustments/{{ $adjustment->id }}">
    @csrf

    <div class="form-group">
        <label>Shot Number</label>
        <input type="number" name="shot_number" class="form-control"
               min="1" max="{{ $adjustment->firestring->shot_count }}"
               value="{{ $adjustment->shot_number }}">
    </div>

    <div class="form-group">
        <label>Elevation Setting</label>
        <input type="number" name="elevation_setting" class="form-control"
               value="{{ $adjustment->elevation_setting }}">
    </div>

    <div class="form-group">
        <label>Windage Setting</label>
        <input type="number" name="windage_setting" class="form-control"
               value="{{ $adjustment->windage_setting }}">
        <p class="text-muted">Negative = Left, positive = Right.</p>
    </div>

    <div class="form-group">
        <label>Notes</label>
        <textarea name="notes" class="form-control" rows="4">{{ $adjustment->notes }}</textarea>
    </div>

    <button class="btn btn-primary">Save</button>
    <a href="/firestrings/{{ $adjustment->firestring_id }}/adjustments" class="btn btn-default">Cancel</a>
</form>

@stop
