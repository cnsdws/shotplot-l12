@extends('_master')

@section('title')
<title>Edit Zero</title>
@stop

@section('Index')

<h3>Edit Zero - {{ $zero->rifle->name }}</h3>

<form method="POST" action="/rifle-zeros/{{ $zero->id }}">
    @csrf

    <div class="form-group">
        <label>Distance</label>
        <select name="distance" class="form-control">
            @foreach (['200 Yard Slow Fire', '200 Yard Rapid Fire', '300 Yard Rapid Fire', '600 Yard Slow Fire'] as $distance)
                <option value="{{ $distance }}" {{ $zero->distance == $distance ? 'selected' : '' }}>
                    {{ $distance }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Elevation</label>
        <input type="number" name="elevation" class="form-control" value="{{ $zero->elevation }}">
    </div>

    <div class="form-group">
        <label>Windage</label>
        <input type="number" name="windage" class="form-control" value="{{ $zero->windage }}">
        <p class="text-muted">Use negative for left, positive for right.</p>
    </div>

    <div class="form-group">
        <label>Notes</label>
        <textarea name="notes" class="form-control" rows="4">{{ $zero->notes }}</textarea>
    </div>

    <button class="btn btn-primary">Save</button>
    <a href="/rifles/{{ $zero->rifle_id }}/zeros" class="btn btn-default">Cancel</a>
</form>

@stop
