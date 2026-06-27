@extends('_master')

@section('title')
<title>Rifle</title>
@stop

@section('Index')



<h3>{{ $rifle->name }}</h3>

<p>
    <a href="/rifles/{{ $rifle->id }}/edit" class="btn btn-primary">Edit Rifle</a>
    <a href="/rifles/{{ $rifle->id }}/history" class="btn btn-info">History</a>
    <a href="/rifles" class="btn btn-default">Back to Rifles</a>
</p>

<h4>Rifle Info</h4>

<table class="table table-bordered">
    <tr><th>Name</th><td>{{ $rifle->name }}</td></tr>
    <tr><th>Caliber</th><td>{{ $rifle->caliber }}</td></tr>
    <tr><th>Sight Type</th><td>{{ $rifle->sight_type }}</td></tr>
    <tr><th>Click Value</th><td>{{ $rifle->sight_click_moa }} MOA</td></tr>
    <tr><th>Notes</th><td>{{ $rifle->notes }}</td></tr>
</table>

<h4>Zero Book</h4>

@if ($zeros->isEmpty())
    <p class="text-muted">No zeroes recorded.</p>
@else
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Distance</th>
                <th>Elevation</th>
                <th>Windage</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($zeros as $zero)
                <tr>
                    <td>{{ $zero->distance }}</td>
                    <td>{{ $zero->elevation }}</td>
                    <td>
                        @if ($zero->windage > 0)
                            {{ $zero->windage }}R
                        @elseif ($zero->windage < 0)
                            {{ abs($zero->windage) }}L
                        @else
                            0
                        @endif
                    </td>
                    <td>{{ $zero->notes }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

<h4>Default Ammo</h4>

<form method="POST" action="/rifles/{{ $rifle->id }}/default-ammo">
    @csrf

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Distance</th>
                <th>Default Ammo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ([
                '200 Yard Slow Fire',
                '200 Yard Rapid Fire',
                '300 Yard Rapid Fire',
                '600 Yard Slow Fire',
            ] as $distance)
                <tr>
                    <td>{{ $distance }}</td>
                    <td>
                        <select name="default_ammo[{{ $distance }}]" class="form-control">
                            <option value="">-- None selected --</option>

                            <optgroup label="ShotPlot Library">
                                @foreach($ballisticProfiles->where('is_system', true) as $profile)
                                    <option value="{{ $profile->id }}"
                                        {{ optional($defaultAmmos->get($distance))->ballistic_profile_id == $profile->id ? 'selected' : '' }}>
                                        {{ $profile->name }}
                                    </option>
                                @endforeach
                            </optgroup>

                            <optgroup label="My Ammo">
                                @foreach($ballisticProfiles->where('is_system', false) as $profile)
                                    <option value="{{ $profile->id }}"
                                        {{ optional($defaultAmmos->get($distance))->ballistic_profile_id == $profile->id ? 'selected' : '' }}>
                                        {{ $profile->name }}
                                    </option>
                                @endforeach
                            </optgroup>
                        </select>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <button class="btn btn-primary">Save Default Ammo</button>
</form>

@stop
