@extends('_firestringmaster')

@section('title')
<title>Edit Firestring</title>
@stop

@section('editfirestring')

<br><br>
<h3>Edit a String of Fire</h3>

<form action="{{ url('/editfirestring/'.$firestring->id) }}" method="post" role="form">
    @csrf
    <input type="hidden" name="id" value="{{ $firestring->id }}">

    <div class="row">
        <div class="col-md-3">
            <h4>String Info</h4>

            <div class="form-group"><label>Firestring Number</label><input class="form-control" type="text" name="fire_string_number" value="{{ $firestring->fire_string_number }}"></div>
            <div class="form-group"><label>Distance</label><input class="form-control" type="text" name="distance" value="{{ $firestring->distance }}"></div>
            <div class="form-group"><label>Target Number</label><input class="form-control" type="text" name="target" value="{{ $firestring->target }}"></div>
            <div class="form-group"><label>Relay</label><input class="form-control" type="text" name="relay" value="{{ $firestring->relay }}"></div>
            <div class="form-group"><label>Light Direction</label><input class="form-control" type="text" name="lightdirection" value="{{ $firestring->lightdirection }}"></div>
            <div class="form-group"><label>Wind Direction</label><input class="form-control" type="text" name="winddirection" value="{{ $firestring->winddirection }}"></div>
            <div class="form-group"><label>Wind Speed</label><input class="form-control" type="text" name="windspeed" value="{{ $firestring->windspeed }}"></div>
            <div class="form-group"><label>Elevation</label><input class="form-control" type="text" name="elevation" value="{{ $firestring->elevation }}"></div>
            <div class="form-group"><label>Windage</label><input class="form-control" type="text" name="windage" value="{{ $firestring->windage }}"></div>
        </div>

        <div class="col-md-3">
            <h4>Shots</h4>

            @for ($i = 1; $i <= $firestring->shot_count; $i++)
                <div class="form-group">
                    <label>Shot {{ $i }}</label>
                    <input class="form-control shot-score" type="text" name="shot{{ $i }}value" value="{{ $firestring->{'shot'.$i.'value'} }}">
                    <input type="hidden" id="shot{{ $i }}x" name="shot{{ $i }}x" value="{{ $firestring->{'shot'.$i.'x'} }}">
                    <input type="hidden" id="shot{{ $i }}y" name="shot{{ $i }}y" value="{{ $firestring->{'shot'.$i.'y'} }}">
                    <small id="shot{{ $i }}coords" class="text-muted"></small>
                </div>
            @endfor
        </div>

        <div class="col-md-6">
            <h4>Plot Shots</h4>
            <p class="text-muted">Select a shot number, then click the target to place it.</p>

            <div class="form-group">
                <label for="activeShot">Active Shot</label>
                <select id="activeShot" class="form-control" style="max-width:180px;">
                    @for ($i = 1; $i <= $firestring->shot_count; $i++)
                        <option value="{{ $i }}">Shot {{ $i }}</option>
                    @endfor
                </select>
            </div>

            <canvas id="targetCanvas" width="550" height="550" style="border:1px solid #ccc; max-width:100%; cursor:crosshair;"></canvas>

            <br><br>
            <button type="button" id="clearActiveShot" class="btn btn-warning">Clear Active Shot</button>
            <button type="button" id="clearAllShots" class="btn btn-danger">Clear All Shots</button>
        </div>
    </div>

    <br>
    <input type="submit" value="Save" class="btn btn-primary">
    <a href="/indexfirestring/{{ $firestring->match_id }}" class="btn btn-default">Cancel</a>
</form>

<script src="{{ asset('js/shotplot-targets.js') }}"></script>
<script>
(function () {
    const canvas = document.getElementById('targetCanvas');
    const ctx = canvas.getContext('2d');
    const activeShotSelect = document.getElementById('activeShot');

    const center = 275;
    const maxRadius = 250;
    const shotCount = {{ $firestring->shot_count }};

    const targetType = ShotPlotTargetForDistance(@json($firestring->distance));
    const target = ShotPlotTargets[targetType] || ShotPlotTargets["SR"];

    const shots = {};

    for (let i = 1; i <= shotCount; i++) {
        const xInput = document.getElementById(`shot${i}x`);
        const yInput = document.getElementById(`shot${i}y`);

        shots[i] = {
            x: xInput.value === '' ? null : Number(xInput.value),
            y: yInput.value === '' ? null : Number(yInput.value)
        };
    }

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
            return target.blackRings.includes(scoreNum) && distanceFromCenter <= ShotPlotRingRadiusPx(target, ring, maxRadius);
        });
    }

    function scoreShot(x, y) {
        const distanceFromCenter = Math.hypot(x - center, y - center);

        const sortedRings = [...target.rings].sort(function (a, b) {
            return a.diameterInches - b.diameterInches;
        });

        for (const ring of sortedRings) {
            if (distanceFromCenter <= ShotPlotRingRadiusPx(target, ring, maxRadius)) {
                return ring.score;
            }
        }

        return 'M';
    }

    function drawShots() {
        Object.keys(shots).forEach(function (key) {
            const shot = shots[key];

            if (shot.x === null || shot.y === null || Number.isNaN(shot.x) || Number.isNaN(shot.y)) {
                return;
            }

            const isInBlack = isPointInBlack(shot.x, shot.y);

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

    function updateInputs() {
        for (let i = 1; i <= shotCount; i++) {
            const xInput = document.getElementById(`shot${i}x`);
            const yInput = document.getElementById(`shot${i}y`);
            const coords = document.getElementById(`shot${i}coords`);

            if (shots[i].x === null || shots[i].y === null) {
                xInput.value = '';
                yInput.value = '';
                coords.textContent = '';
            } else {
                xInput.value = Math.round(shots[i].x);
                yInput.value = Math.round(shots[i].y);
                coords.textContent = `x: ${xInput.value}, y: ${yInput.value}`;
            }
        }
    }

    function redraw() {
        drawTarget();
        drawShots();
        updateInputs();
    }

    canvas.addEventListener('click', function (event) {
        const rect = canvas.getBoundingClientRect();
        const scaleX = canvas.width / rect.width;
        const scaleY = canvas.height / rect.height;

        const x = (event.clientX - rect.left) * scaleX;
        const y = (event.clientY - rect.top) * scaleY;

        const activeShot = Number(activeShotSelect.value);

        shots[activeShot] = { x, y };

        const scoreInput = document.querySelector(`[name="shot${activeShot}value"]`);
        if (scoreInput) {
            scoreInput.value = scoreShot(x, y);
        }

        if (activeShot < shotCount) {
            activeShotSelect.value = activeShot + 1;
        }

        redraw();
    });

    document.getElementById('clearActiveShot').addEventListener('click', function () {
        const activeShot = Number(activeShotSelect.value);
        shots[activeShot] = { x: null, y: null };
        redraw();
    });

    document.getElementById('clearAllShots').addEventListener('click', function () {
        for (let i = 1; i <= shotCount; i++) {
            shots[i] = { x: null, y: null };
        }
        redraw();
    });

    redraw();
})();
</script>

@stop
