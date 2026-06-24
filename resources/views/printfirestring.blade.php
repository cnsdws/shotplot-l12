<!DOCTYPE html>
<html>
<head>
    <title>Firestring Report</title>

    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <style>
        @media print {
            .no-print {
                display: none;
            }
        }

        body {
            margin: 20px;
        }

        h1, h2, h3 {
            margin-top: 0;
        }
    </style>
</head>
<body>

<div class="no-print">
    <button onclick="window.print()" class="btn btn-primary">
        Print
    </button>

    <a href="/displayfirestring/{{ $firestring->id }}"
       class="btn btn-default">
        Back
    </a>

    <hr>
</div>

<h2>Firestring Report</h2>

<table class="table table-bordered">
    <tr>
        <th>Firestring</th>
        <td>{{ $firestring->fire_string_number }}</td>
    </tr>

    <tr>
        <th>Distance</th>
        <td>{{ $firestring->distance }}</td>
    </tr>

    <tr>
        <th>Target</th>
        <td>{{ $firestring->target }}</td>
    </tr>

    <tr>
        <th>Elevation</th>
        <td>{{ $firestring->elevation }}</td>
    </tr>

    <tr>
        <th>Windage</th>
        <td>{{ $firestring->windage }}</td>
    </tr>
</table>

<h3>Shots</h3>

@php
    $adjustmentsByShot = $firestring->adjustments->keyBy('shot_number');
@endphp

<h3>Shots</h3>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Shot</th>
            <th>Score</th>
            <th>Adjustment</th>
        </tr>
    </thead>

    <tbody>
        @for ($i = 1; $i <= $firestring->shot_count; $i++)
            @php
                $adjustment = $adjustmentsByShot->get($i);
            @endphp

            <tr>
                <td>{{ $i }}</td>
                <td>{{ $firestring->{'shot'.$i.'value'} }}</td>
                <td>
                    @if ($adjustment)
                        Elev {{ $adjustment->elevation_setting }},
                        Wind
                        @if ($adjustment->windage_setting > 0)
                            {{ $adjustment->windage_setting }}R
                        @elseif ($adjustment->windage_setting < 0)
                            {{ abs($adjustment->windage_setting) }}L
                        @else
                            0
                        @endif

                        @if ($adjustment->notes)
                            — {{ $adjustment->notes }}
                        @endif
                    @endif
                </td>
            </tr>
        @endfor
    </tbody>
</table>

</body>
</html>
