@extends('_master')

@section('Create')

<h1>Create Match</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ url('/create') }}" method="post" role="form">
    @csrf

    <div class="form-group">
        <label for="place">Place</label>
        <input type="text" name="place" id="place" class="form-control" value="{{ old('place') }}">
    </div>

    <div class="form-group">
        <label for="date">Date</label>
        <input type="text"
               name="date"
               id="date"
               class="form-control"
               value="{{ old('date', date('Y-m-d')) }}"
               placeholder="YYYY-MM-DD">
    </div>

    <div class="form-group">
        <label for="rifle_id">Rifle</label>
        <select name="rifle_id" id="rifle_id" class="form-control">
            <option value="">-- Select Rifle --</option>
            @foreach ($rifles as $rifle)
                <option value="{{ $rifle->id }}" {{ old('rifle_id') == $rifle->id ? 'selected' : '' }}>
                    {{ $rifle->name }} @if($rifle->caliber) - {{ $rifle->caliber }} @endif
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="rangename">Range Name</label>
        <input type="text" name="rangename" id="rangename" class="form-control" value="{{ old('rangename') }}">
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
    <a href="{{ url('/') }}" class="btn btn-link">Cancel</a>
</form>

@stop
