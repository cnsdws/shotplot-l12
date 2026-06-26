@extends('_master')

@section('title')
<title>New Ammo Profile</title>
@stop

@section('Index')

<a href="/ballistics" class="btn btn-link">
    Back to Ammo Library
</a>

<h3>New Ammo Profile</h3>

<form method="POST" action="/ballistics">
    @csrf

    @include('ballistics._form')

    <br>

    <button class="btn btn-primary">
        Save Ammo Profile
    </button>

</form>

@stop
