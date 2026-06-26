@extends('_master')

@section('title')
<title>New Ballistic Profile</title>
@stop

@section('Index')

<a href="/ballistics" class="btn btn-link">
    Back to Ballistics Library
</a>

<h3>New Ballistic Profile</h3>

<form method="POST" action="/ballistics">
    @csrf

    @include('ballistics._form')

    <br>

    <button class="btn btn-primary">
        Save Ballistic Profile
    </button>

</form>

@stop
