@extends('_firestringmaster')

@section('title')
<title>Display Firestring</title>
@stop

@section('editfirestring')
<br>
<li><a href="/indexfirestring/{{ $firestring->match_id }}" class="navbar-brand">Back to Firestrings</a></li>

<br><br>

<h3>Display a String of Fire</h3>

<div class="row">
    <div class="col-md-4">
        <table class="table table-striped">
            <tbody>
                <h4>Firestring #{{ $firestring->fire_string_number }}</h4>
                <tr><td>Distance</td><td>{{ $firestring->distance }}</td></tr>
                <tr><td>Target Number</td><td>{{ $firestring->target }}</td></tr>
                <tr><td>Relay</td><td>{{ $firestring->relay }}</td></tr>
                <tr><td>Light Direction</td><td>{{ $firestring->lightdirection }}</td></tr>
                <tr><td>Wind Direction</td><td>{{ $firestring->winddirection }}</td></tr>
                <tr><td>Wind Speed</td><td>{{ $firestring->windspeed }}</td></tr>
                <tr><td>Elevation</td><td>{{ $firestring->elevation }}</td></tr>
                <tr><td>Windage</td><td>{{ $firestring->windage }}</td></tr>
            </tbody>
        </table>
    </div>

    <div class="col-md-2">
        <table class="table table-striped">
            <tbody>
                <h4>Shot and Score</h4>
                @for ($i = 1; $i <= $firestring->shot_count; $i++)
                    <tr>
                        <td>Shot {{ $i }}</td>
                        <td>{{ $firestring->{'shot'.$i.'value'} }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>

    <div class="col-md-6">
        <h4>Shot Plot</h4>
        <canvas id="targetCanvas" width="550" height="550" style="border:1px solid #ccc; max-width:100%;"></canvas>
        
        <hr>
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>Group Analysis</strong>
            </div>

            <div class="panel-body">
                <p><strong>Shots Plotted:</strong> <span id="shotsPlotted">0</span></p>
                <p><strong>Group Center:</strong> <span id="groupCenter">N/A</span></p>
                <p><strong>Extreme Spread:</strong> <span id="extremeSpread">N/A</span></p>
            </div>
        </div>
    </div>
    
</div>

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
            ctx.beginPath();
            const ringRadius = ShotPlotRingRadiusPx(target, ring, maxRadius);
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
            ) && distanceFromCenter <= ShotPlotRingRadiusPx(target, ring, maxRadius)
        });
    }
    
    function analyzeGroup() {

        const plottedShots = shots.filter(function (shot) {
            return shot.x !== null &&
                   shot.y !== null &&
                   shot.x !== '' &&
                   shot.y !== '';
        });

        document.getElementById('shotsPlotted').textContent =
            plottedShots.length;

        if (plottedShots.length < 2) {
            return;
        }

        let avgX = 0;
        let avgY = 0;

        plottedShots.forEach(function (shot) {
            avgX += Number(shot.x);
            avgY += Number(shot.y);
        });

        avgX /= plottedShots.length;
        avgY /= plottedShots.length;

        const dx = Math.round(avgX - center);
        const dy = Math.round(center - avgY);

        document.getElementById('groupCenter').textContent =
            dx + ' px horizontal, ' + dy + ' px vertical';

        let maxSpread = 0;

        for (let i = 0; i < plottedShots.length; i++) {
            for (let j = i + 1; j < plottedShots.length; j++) {

                const spread = Math.hypot(
                    plottedShots[i].x - plottedShots[j].x,
                    plottedShots[i].y - plottedShots[j].y
                );

                if (spread > maxSpread) {
                    maxSpread = spread;
                }
            }
        }

        document.getElementById('extremeSpread').textContent =
            maxSpread.toFixed(1) + ' px';
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
    analyzeGroup();
})();
</script>
@stop
