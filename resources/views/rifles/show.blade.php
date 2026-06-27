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

<h4>Stage Configuration</h4>

<form method="POST" action="/rifles/{{ $rifle->id }}/configuration">
    @csrf

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Stage</th>
                <th>Elevation</th>
                <th>Windage</th>
                <th>Default Ammo</th>
                <th>Notes</th>
            </tr>
        </thead>

        <tbody>
            @foreach ([
                '200 Yard Slow Fire' => '200 SF',
                '200 Yard Rapid Fire' => '200 RF',
                '300 Yard Rapid Fire' => '300 RF',
                '600 Yard Slow Fire' => '600 SF',
            ] as $distance => $label)

                @php
                    $zero = $zeros->firstWhere('distance', $distance);
                    $defaultAmmo = $defaultAmmos->get($distance);
                @endphp

                <tr>
                    <td>{{ $label }}</td>

                    <td>
                        <input type="text"
                               name="zeros[{{ $distance }}][elevation]"
                               class="form-control"
                               value="{{ optional($zero)->elevation }}">
                    </td>

                    <td>
                        <input type="text"
                               name="zeros[{{ $distance }}][windage]"
                               class="form-control"
                               value="{{ optional($zero)->windage }}">
                    </td>

                    <td>
                        <select name="default_ammo[{{ $distance }}]" class="form-control">
                            <option value="">-- None selected --</option>

                            <optgroup label="ShotPlot Library">
                                @foreach($ballisticProfiles->where('is_system', true) as $profile)
                                    <option value="{{ $profile->id }}"
                                        {{ optional($defaultAmmo)->ballistic_profile_id == $profile->id ? 'selected' : '' }}>
                                        {{ $profile->name }}
                                    </option>
                                @endforeach
                            </optgroup>

                            <optgroup label="My Ammo">
                                @foreach($ballisticProfiles->where('is_system', false) as $profile)
                                    <option value="{{ $profile->id }}"
                                        {{ optional($defaultAmmo)->ballistic_profile_id == $profile->id ? 'selected' : '' }}>
                                        {{ $profile->name }}
                                    </option>
                                @endforeach
                            </optgroup>
                        </select>
                    </td>

                    <td>
                        <input type="text"
                               name="zeros[{{ $distance }}][notes]"
                               class="form-control"
                               value="{{ optional($zero)->notes }}">
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <button class="btn btn-primary">Save Configuration</button>
</form>

@stop
