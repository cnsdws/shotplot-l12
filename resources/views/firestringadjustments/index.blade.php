@extends('_firestringmaster')

@section('title')
<title>Adjustment Log</title>
@stop

@section('editfirestring')

<h3>
    Adjustment Log - Firestring {{ $firestring->fire_string_number }}
</h3>

<p>
    <a href="/firestrings/{{ $firestring->id }}/adjustments/create"
       class="btn btn-primary">
        Add Adjustment
    </a>

    <a href="/displayfirestring/{{ $firestring->id }}"
       class="btn btn-default">
        Back to Firestring
    </a>
</p>

@if ($adjustments->isEmpty())

    <div class="alert alert-info">
        No sight adjustments recorded.
    </div>

@else

<table class="table table-striped">
    <thead>
        <tr>
            <th>Shot</th>
            <th>Elevation</th>
            <th>Windage</th>
            <th>Notes</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($adjustments as $adjustment)
        <tr>
            <td>{{ $adjustment->shot_number }}</td>
            <td>{{ $adjustment->elevation_setting }}</td>

            <td>
                @if($adjustment->windage_setting > 0)
                    {{ $adjustment->windage_setting }}R
                @elseif($adjustment->windage_setting < 0)
                    {{ abs($adjustment->windage_setting) }}L
                @else
                    0
                @endif
            </td>

            <td>{{ $adjustment->notes }}</td>

            <td>
                <a href="/firestring-adjustments/{{ $adjustment->id }}/edit"
                   class="btn btn-default">
                    Edit
                </a>
                <form method="POST" action="/firestring-adjustments/{{ $adjustment->id }}/delete" style="display:inline;">
                    @csrf
                    <button class="btn btn-danger" onclick="return confirm('Delete this adjustment?')">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endif

@stop
