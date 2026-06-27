@extends('_master')

@section('title')
<title>Rifle History</title>
@stop

@section('Index')

<h3>{{ $rifle->name }} - Rifle History</h3>

<p>
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



<h4>Recent Matches and Firestrings</h4>

@if ($matches->isEmpty())
    <p class="text-muted">No matches recorded for this rifle.</p>
@else
    @foreach ($matches as $match)
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>{{ $match->date }}</strong> - {{ $match->place }}
                @if ($match->rangename)
                    / {{ $match->rangename }}
                @endif
            </div>

            <div class="panel-body">
                @if ($match->firestrings->isEmpty())
                    <p class="text-muted">No firestrings recorded.</p>
                @else
                    <table class="table table-condensed table-striped">
                        <thead>
                            <tr>
                                <th>String</th>
                                <th>Distance</th>
                                <th>Score</th>
                                <th>Wind</th>
                                <th>Temp</th>
                                <th>Sky</th>
                                <th>Report</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($match->firestrings as $firestring)
                                <tr>
                                    <td>{{ $firestring->fire_string_number }}</td>
                                    <td>{{ $firestring->distance }}</td>
                                    <td><strong>{{ $firestring->formattedScore() }}</strong></td>
                                    <td>{{ $firestring->windspeed }} MPH at {{ $firestring->winddirection }}</td>
                                    <td>
                                        @if ($firestring->temperature)
                                            {{ $firestring->temperature }}°F
                                        @endif
                                    </td>
                                    <td>{{ $firestring->sky_condition }}</td>
                                    <td>
                                        <a href="/displayfirestring/{{ $firestring->id }}" class="btn btn-xs btn-default">
                                            View
                                        </a>
                                        <a href="/displayfirestring/{{ $firestring->id }}/print" class="btn btn-xs btn-primary">
                                            Print
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    @endforeach
@endif

@stop
