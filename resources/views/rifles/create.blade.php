@extends('_master')

@section('title')
<title>Create Rifle</title>
@stop

@section('Index')

<h3>Create Rifle</h3>

<form method="POST" action="/rifles">
    @csrf

    <div class="form-group">
        <label>Name</label>
        <input class="form-control" name="name">
    </div>

    <div class="form-group">
        <label>Caliber</label>
        <input class="form-control" name="caliber">
    </div>

    <div class="form-group">
        <label>Sight Type</label>
        <input class="form-control" name="sight_type">
    </div>

    <div class="form-group">
        <label>Serial Number</label>
        <input class="form-control" name="serial_number">
    </div>

    <div class="form-group">
        <label>Click Value (MOA)</label>
        <input class="form-control"
               name="sight_click_moa"
               value="0.25">
    </div>

    <div class="form-group">
        <label>Notes</label>
        <textarea class="form-control"
                  name="notes"
                  rows="5"></textarea>
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
