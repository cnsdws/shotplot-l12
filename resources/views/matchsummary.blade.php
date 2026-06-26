@extends('_master')

@section('title')
<title>Match Summary</title>
@stop

@section('Index')

<h3>Match Summary</h3>

<p>
    <a href="/" class="btn btn-default">Back to Matches</a>
</p>

<table class="table table-bordered">
    <tr><th>Date</th><td>{{ $match->date }}</td></tr>
    <tr><th>Place</th><td>{{ $match->place }}</td></tr>
    <tr><th>Range</th><td>{{ $match->rangename }}</td></tr>
    <tr><th>Rifle</th><td>{{ optional($match->rifle)->name }}</td></tr>
</table>

<h4>Firestrings</h4>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>String</th>
            <th>Distance</th>
            <th>Ammo</th>
            <th>Score</th>
            <th>Wind</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @php
            $matchTotal = 0;
            $matchX = 0;
        @endphp

        @foreach ($match->firestrings as $firestring)
            @php
                $matchTotal += $firestring->totalScore();
                $matchX += $firestring->xCount();
            @endphp

            <tr>
                <td>{{ $firestring->fire_string_number }}</td>
                <td>{{ $firestring->distance }}</td>
                <td>@if($firestring->ballisticProfile){{ $firestring->ballisticProfile->name }}@else — @endif </td>
                <td><strong>{{ $firestring->formattedScore() }}</strong></td>
                <td>{{ $firestring->windspeed }}mph from {{ $firestring->winddirection }}</td>
                <td>
                    <a href="/displayfirestring/{{ $firestring->id }}" class="btn btn-xs btn-default">View</a>
                    <a href="/displayfirestring/{{ $firestring->id }}/print" class="btn btn-xs btn-primary">Print</a>
                </td>
            </tr>
        @endforeach

        <tr>
            <th colspan="3">Match Total</th>
            <th>{{ $matchTotal }}-{{ $matchX }}X</th>
            <th colspan="3"></th>
        </tr>
    </tbody>
</table>

@stop
