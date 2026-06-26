@extends('_master')

@section('title')
<title>Edit Ammo Profile</title>
@stop

@section('Index')

<a href="/ballistics" class="btn btn-link">
    Back to Ammo Library
</a>

<h3>Edit Ammo Profile</h3>

<form method="POST"
      action="/ballistics/{{ $ballisticProfile->id }}">
    @csrf

    @include('ballistics._form')

    <br>

    <button class="btn btn-primary">
        Update Ammo Profile
    </button>

</form>

@stop
