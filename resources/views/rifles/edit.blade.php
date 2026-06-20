@extends('_master')

@section('title')
<title>Edit Rifle</title>
@stop

@section('Index')

<h3>Edit Rifle</h3>

<form method="POST" action="/rifles/{{ $rifle->id }}">
    @csrf

    <div class="form-group">
        <label>Name</label>
        <input class="form-control"
               name="name"
               value="{{ $rifle->name }}">
    </div>

    <div class="form-group">
        <label>Caliber</label>
        <input class="form-control"
               name="caliber"
               value="{{ $rifle->caliber }}">
    </div>

    <div class="form-group">
        <label>Sight Type</label>
        <input class="form-control"
               name="sight_type"
               value="{{ $rifle->sight_type }}">
    </div>

    <div class="form-group">
        <label>Serial Number</label>
        <input class="form-control"
               name="serial_number"
               value="{{ $rifle->serial_number }}">
    </div>

    <div class="form-group">
        <label>Click Value (MOA)</label>
        <input class="form-control"
               name="sight_click_moa"
               value="{{ $rifle->sight_click_moa }}">
    </div>

    <div class="form-group">
        <label>Notes</label>
        <textarea class="form-control"
                  name="notes"
                  rows="5">{{ $rifle->notes }}</textarea>
    </div>

    <br>

    <button class="btn btn-primary">
        Save
    </button>

    <a href="/rifles" class="btn btn-default">
        Cancel
    </a>

</form>

@stop
