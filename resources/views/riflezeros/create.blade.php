@extends('_master')

@section('title')
<title>Add Zero</title>
@stop

@section('Index')

<h3>Add Zero - {{ $rifle->name }}</h3>

<form method="POST" action="/rifles/{{ $rifle->id }}/zeros">
    @csrf

    <div class="form-group">
        <label>Distance</label>
        <select name="distance" class="form-control">
            <option>200 Yard Slow Fire</option>
            <option>200 Yard Rapid Fire</option>
            <option>300 Yard Rapid Fire</option>
            <option>600 Yard Slow Fire</option>
        </select>
    </div>

    <div class="form-group">
        <label>Elevation</label>
        <input type="number" name="elevation" class="form-control">
    </div>

    <div class="form-group">
        <label>Windage</label>
        <input type="number" name="windage" class="form-control">
        <p class="text-muted">Use negative for left, positive for right.</p>
    </div>

    <div class="form-group">
        <label>Notes</label>
        <textarea name="notes" class="form-control" rows="4"></textarea>
    </div>

    <button class="btn btn-primary">Save</button>
    <a href="/rifles/{{ $rifle->id }}/zeros" class="btn btn-default">Cancel</a>
</form>

@stop
