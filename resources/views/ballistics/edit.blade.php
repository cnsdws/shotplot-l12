@extends('_master')

@section('title')
<title>Edit Ballistic Profile</title>
@stop

@section('Index')

<a href="/ballistics" class="btn btn-link">
    Back to Ballistics Library
</a>

<h3>Edit Ballistic Profile</h3>

<form method="POST"
      action="/ballistics/{{ $ballisticProfile->id }}">
    @csrf

    @include('ballistics._form')

    <br>

    <button class="btn btn-primary">
        Update Ballistic Profile
    </button>

</form>

@stop
