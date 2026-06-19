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
                @for ($i = 1; $i <= 10; $i++)
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
        <p class="text-muted">HTML5 target plotter replacing the original Flash target.</p>
    </div>
</div>

<script>
(function () {
    const canvas = document.getElementById('targetCanvas');
    const ctx = canvas.getContext('2d');

    const center = 275;
    const maxRadius = 250;

    const shots = [
        @for ($i = 1; $i <= 10; $i++)
            {
                n: {{ $i }},
                score: @json($firestring->{'shot'.$i.'value'}),
                x: @json($firestring->{'shot'.$i.'x'}),
                y: @json($firestring->{'shot'.$i.'y'})
            }{{ $i < 10 ? ',' : '' }}
        @endfor
    ];

    function drawTarget() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        ctx.fillStyle = '#f9f9f9';
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        for (let i = 10; i >= 1; i--) {
            const r = maxRadius * i / 10;

            ctx.beginPath();
            ctx.arc(center, center, r, 0, Math.PI * 2);
            ctx.fillStyle = i <= 4 ? '#222' : '#fff';
            ctx.fill();
            ctx.strokeStyle = '#333';
            ctx.lineWidth = 1;
            ctx.stroke();
        }

        ctx.beginPath();
        ctx.moveTo(center - maxRadius, center);
        ctx.lineTo(center + maxRadius, center);
        ctx.moveTo(center, center - maxRadius);
        ctx.lineTo(center, center + maxRadius);
        ctx.strokeStyle = '#999';
        ctx.stroke();

        ctx.fillStyle = '#000';
        ctx.font = '13px Arial';
        ctx.fillText('200 Yard Target', 12, 22);
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

            const isInBlack = Math.hypot(shot.x - center, shot.y - center) <= (maxRadius * 4 / 10);

            ctx.beginPath();
            ctx.arc(shot.x, shot.y, 9, 0, Math.PI * 2);
            ctx.fillStyle = isInBlack ? '#ffffff' : '#d9534f';
            ctx.fill();
            ctx.strokeStyle = '#000000';
            ctx.lineWidth = 2;
            ctx.stroke();

            ctx.fillStyle = isInBlack ? '#000000' : '#ffffff';
            ctx.font = 'bold 13px Arial';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText(key, shot.x, shot.y);
        });
    }

    drawTarget();
    drawShots();
})();
</script>
@stop
