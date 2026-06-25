<!DOCTYPE html>
<html>
<head>
    <title>Firestring Report</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/shotplot.css') }}">

    <style>
        @page {
            margin: 0.35in;
        }

        @media print {
            .no-print {
                display: none;
            }

            table,
            tr {
                page-break-inside: avoid;
            }
        }

        body {
            margin: 10px;
            font-size: 12px;
        }

        h1, h2, h3 {
            margin-top: 0;
            margin-bottom: 8px;
        }

        .table td,
        .table th {
            padding: 3px;
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

<div class="row print-report-row">
    <div class="col-xs-6 print-report-col">
    <table class="table table-bordered table-condensed report-table">
            <tr><th>Rifle</th><td>{{ optional($firestring->match->rifle)->name }}</td></tr>
            <tr><th>Date</th><td>{{ optional($firestring->match)->date }}</td></tr>
            <tr><th>Firestring</th><td>{{ $firestring->fire_string_number }}</td></tr>
            <tr><th>Distance</th><td>{{ $firestring->distance }}</td></tr>
            <tr><th>Target</th><td>{{ $firestring->target }}</td></tr>
            <tr><th>Elevation</th><td>{{ $firestring->elevation }}</td></tr>
            <tr><th>Windage</th><td>{{ $firestring->windage }}</td></tr>
            <tr><th>Wind Direction</th><td>{{ $firestring->winddirection }}</td></tr>
            <tr><th>Wind Speed</th><td>{{ $firestring->windspeed }}</td></tr>
            <tr><th>Light Direction</th><td>{{ $firestring->lightdirection }}</td></tr>
            <tr><th>Temperature</th><td>
                    @if($firestring->temperature)
                        {{ $firestring->temperature }}°F
                    @endif
                </td>
            </tr>
            <tr><th>Sky</th><td>{{ $firestring->sky_condition }}</td></tr>
            <tr><th>Notes</th><td>{{ $firestring->range_notes }}</td></tr>
            <tr><th>Score</th><td><strong>{{ $firestring->formattedScore() }}</strong></td></tr>
        </table>
    </div>

    <div class="col-xs-6 text-center print-report-col">
        <canvas id="targetCanvas"
                width="550"
                height="550"
                style="border:1px solid #ccc; max-width:100%;">
        </canvas>
    </div>
</div>

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

                <td>
                    {{ $firestring->{'shot'.$i.'value'} }}
                </td>

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

<script src="{{ asset('js/shotplot-targets.js') }}"></script>

<script>
(function () {
    const canvas = document.getElementById('targetCanvas');
    const ctx = canvas.getContext('2d');

    const center = 275;
    const maxRadius = 250;

    const targetType = ShotPlotTargetForDistance(@json($firestring->distance));
    const target = ShotPlotTargets[targetType] || ShotPlotTargets["SR"];

    const shots = [
        @for ($i = 1; $i <= $firestring->shot_count; $i++)
            {
                n: {{ $i }},
                score: @json($firestring->{'shot'.$i.'value'}),
                x: @json($firestring->{'shot'.$i.'x'}),
                y: @json($firestring->{'shot'.$i.'y'})
            }@if ($i < $firestring->shot_count),@endif
        @endfor
    ];

    function drawTarget() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        ctx.fillStyle = '#f9f9f9';
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        target.rings.forEach(function (ring) {
            const ringRadius = ShotPlotRingRadiusPx(target, ring, maxRadius);

            ctx.beginPath();
            ctx.arc(center, center, ringRadius, 0, Math.PI * 2);

            const scoreNum = Number(ring.score);
            const isBlackRing =
                target.blackRings.includes(ring.score) ||
                target.blackRings.includes(scoreNum);

            ctx.fillStyle = isBlackRing ? '#222' : '#fff';
            ctx.fill();

            ctx.strokeStyle = '#333';
            ctx.lineWidth = 1;
            ctx.stroke();

            ctx.fillStyle = isBlackRing ? '#fff' : '#333';
            ctx.font = '11px Arial';
            ctx.textAlign = 'left';
            ctx.textBaseline = 'alphabetic';
            ctx.fillText(ring.score, center + 5, center - ringRadius + 14);
        });

        ctx.beginPath();
        ctx.moveTo(center - maxRadius, center);
        ctx.lineTo(center + maxRadius, center);
        ctx.moveTo(center, center - maxRadius);
        ctx.lineTo(center, center + maxRadius);
        ctx.strokeStyle = '#999';
        ctx.stroke();

        ctx.fillStyle = '#000';
        ctx.font = '13px Arial';
        ctx.textAlign = 'left';
        ctx.textBaseline = 'alphabetic';
        ctx.fillText(target.label, 12, 22);
    }

    function isPointInBlack(x, y) {
        const distanceFromCenter = Math.hypot(x - center, y - center);

        return target.rings.some(function (ring) {
            const scoreNum = Number(ring.score);
            return (
                target.blackRings.includes(ring.score) ||
                target.blackRings.includes(scoreNum)
            ) && distanceFromCenter <= ShotPlotRingRadiusPx(target, ring, maxRadius);
        });
    }

    function drawShots() {
        shots.forEach(function (shot) {
            if (shot.x === null || shot.y === null || shot.x === '' || shot.y === '') {
                return;
            }

            const x = Number(shot.x);
            const y = Number(shot.y);

            if (Number.isNaN(x) || Number.isNaN(y)) {
                return;
            }

            const isInBlack = isPointInBlack(x, y);

            ctx.beginPath();
            ctx.arc(x, y, 9, 0, Math.PI * 2);
            ctx.fillStyle = isInBlack ? '#ffffff' : '#d9534f';
            ctx.fill();

            ctx.strokeStyle = '#000000';
            ctx.lineWidth = 2;
            ctx.stroke();

            ctx.fillStyle = isInBlack ? '#000000' : '#ffffff';
            ctx.font = 'bold 13px Arial';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText(shot.n, x, y);
        });
    }

    drawTarget();
    drawShots();
})();
</script>
</body>
</html>
