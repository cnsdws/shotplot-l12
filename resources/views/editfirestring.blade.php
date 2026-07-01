@extends('_firestringmaster')

@section('title')
<title>Edit Firestring</title>
@stop

@section('editfirestring')



<form action="{{ url('/editfirestring/'.$firestring->id) }}" method="post" role="form">
    @csrf
    <input type="hidden" name="id" value="{{ $firestring->id }}">

    <div class="row">
        <div class="col-md-3"> <h3>Firestring Details</h3>
           <div class="form-group"><label>String #</label><input class="form-control" type="text" name="fire_string_number" value="{{ $firestring->fire_string_number }}"></div>
            <div class="form-group"><label>Distance</label><input class="form-control" type="text" name="distance" value="{{ $firestring->distance }}"></div>

            @include('firestrings._ammo_select')
            <div class="form-group"><label>Elevation</label><input class="form-control" type="text" name="elevation" value="{{ $firestring->elevation }}"></div>
            <div class="form-group"><label>Windage</label><input class="form-control" type="text" name="windage" value="{{ $firestring->windage }}"></div>
            <div class="form-group"><label>Target #</label><input class="form-control" type="text" name="target" value="{{ $firestring->target }}"></div>
            <div class="form-group"><label>Relay #</label><input class="form-control" type="text" name="relay" value="{{ $firestring->relay }}"></div>
            <div class="form-group"><label>Light Direction</label><input class="form-control" type="text" name="lightdirection" value="{{ $firestring->lightdirection }}"></div>
            
            <div class="form-group"><label>Wind Direction</label><input type="hidden" name="winddirection" id="winddirection" value="{{old('winddirection', optional($firestring ??null)->winddirection) }}">
                <div class="btn-group" id="windDirectionButtons">
                    <button type="button" class="btn btn-default" data-dir="9 O'clock">9</button>
                    <button type="button" class="btn btn-default" data-dir="10 O'clock">10</button>
                    <button type="button" class="btn btn-default" data-dir="11 O'clock">11</button>
                    <button type="button" class="btn btn-default" data-dir="12 O'clock">12</button>
                    <button type="button" class="btn btn-default" data-dir="1 O'clock">1</button>
                    <button type="button" class="btn btn-default" data-dir="2 O'clock">2</button>
                    <button type="button" class="btn btn-default" data-dir="3 O'clock">3</button>
                </div>
            </div>
            <div class="form-group"><label>Wind Speed</label><input type="hidden" name="windspeed" id="windspeed" value="{{ old('windspeed', optional($firestring ?? null)->windspeed) }}">
                <div class="btn-group" id="windSpeedButtons">
                    <button type="button" class="btn btn-default" data-speed="0">0</button>
                    <button type="button" class="btn btn-default" data-speed="5">5</button>
                    <button type="button" class="btn btn-default" data-speed="10">10</button>
                    <button type="button" class="btn btn-default" data-speed="15">15</button>
                    <button type="button" class="btn btn-default" data-speed="20">20</button>
                    <button type="button" class="btn btn-default" data-speed="25">25</button>
                </div>
            <div class="form-group"><label>Range Notes</label><textarea class="form-control" name="range_notes" rows="3">{{ $firestring->range_notes }}</textarea></div>
            </div>
</div>
        <div class="col-md-3">
            <h3>Shots</h3>

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
            <h3>Plot Shots</h3>
            <p class="text-muted">Select a shot number, then click the target to place it.</p>

            <div class="form-group">
                <label for="activeShot">Shot to Edit</label>
                <select id="activeShot" class="form-control" style="max-width:180px;">
                    @for ($i = 1; $i <= $firestring->shot_count; $i++)
                        <option value="{{ $i }}">Shot {{ $i }}</option>
                    @endfor
                </select>
            </div>

            <canvas id="targetCanvas" width="550" height="550" style="border:1px solid #ccc; max-width:100%; cursor:crosshair;"></canvas>

            <hr>

            <div class="panel panel-default">
                <div class="panel-heading"><strong>Group Analysis</strong></div>
                <div class="panel-body">
                    <p><strong>Shots Plotted:</strong> <span id="shotsPlotted">0</span></p>
                    <p><strong>Group Center:</strong> <span id="groupCenter">N/A</span></p>
                    <p><strong>Extreme Spread:</strong> <span id="extremeSpread">N/A</span></p>
                    <p><strong>Mean Radius:</strong> <span id="meanRadius">N/A</span></p>
                    <p><strong>Suggested Correction:</strong> <span id="suggestedCorrection">N/A</span></p>
                </div>
            </div>
            <button type="button" id="clearActiveShot" class="btn btn-warning">Clear Active Shot</button>
            <button type="button" id="clearAllShots" class="btn btn-danger">Clear All Shots</button>
            <input type="submit" value="Save" class="btn btn-primary">
            <a href="/indexfirestring/{{ $firestring->match_id }}" class="btn btn-link">Cancel</a>
        </div>
    </div>
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
    const sightClickMOA = @json(optional(optional($firestring->match)->rifle)->sight_click_moa ?? 0.25);

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
        return (
         target.blackRings.includes(ring.score) ||
         target.blackRings.includes(scoreNum)
        ) && distanceFromCenter <= ShotPlotRingRadiusPx(target, ring, maxRadius);
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

    function analyzeGroup() {
        const plottedShots = [];

        for (let i = 1; i <= shotCount; i++) {
            const shot = shots[i];

            if (shot.x !== null && shot.y !== null && !Number.isNaN(shot.x) && !Number.isNaN(shot.y)) {
                plottedShots.push(shot);
            }
        }

        document.getElementById('shotsPlotted').textContent = plottedShots.length;

        if (plottedShots.length < 2) {
            document.getElementById('groupCenter').textContent = 'N/A';
            document.getElementById('extremeSpread').textContent = 'N/A';
            document.getElementById('meanRadius').textContent = 'N/A';
            document.getElementById('suggestedCorrection').textContent = 'N/A';
            return;
        }

        let avgX = 0;
        let avgY = 0;

        plottedShots.forEach(function (shot) {
            avgX += shot.x;
            avgY += shot.y;
        });

        avgX /= plottedShots.length;
        avgY /= plottedShots.length;

        const outerDiameterInches = target.rings[0].diameterInches;
        const inchesPerPixel = outerDiameterInches / (maxRadius * 2);
        const inchesPerMOA = target.distanceYards * 1.047 / 100;

        const dxPixels = avgX - center;
        const dyPixels = center - avgY;

        const dxMOA = (dxPixels * inchesPerPixel) / inchesPerMOA;
        const dyMOA = (dyPixels * inchesPerPixel) / inchesPerMOA;

        const horizontalDirection = dxMOA >= 0 ? 'Right' : 'Left';
        const verticalDirection = dyMOA >= 0 ? 'High' : 'Low';

        document.getElementById('groupCenter').textContent =
            Math.abs(dxMOA).toFixed(2) + ' MOA ' + horizontalDirection +
            ', ' +
            Math.abs(dyMOA).toFixed(2) + ' MOA ' + verticalDirection;

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

        const extremeSpreadMOA = (maxSpread * inchesPerPixel) / inchesPerMOA;

        document.getElementById('extremeSpread').textContent =
            extremeSpreadMOA.toFixed(2) + ' MOA';

        let totalRadius = 0;

        plottedShots.forEach(function (shot) {
            const radiusPixels = Math.hypot(
                shot.x - avgX,
                shot.y - avgY
            );

            totalRadius += radiusPixels;
        });

        const meanRadiusPixels = totalRadius / plottedShots.length;

        const meanRadiusMOA =
            (meanRadiusPixels * inchesPerPixel) / inchesPerMOA;

        document.getElementById('meanRadius').textContent =
            meanRadiusMOA.toFixed(2) + ' MOA';

        const horizontalClicks =
            Math.round(Math.abs(dxMOA) / sightClickMOA);

        const verticalClicks =
            Math.round(Math.abs(dyMOA) / sightClickMOA);

        const horizontalCorrection =
            dxMOA > 0
                ? horizontalClicks + ' Clicks Left'
                : horizontalClicks + ' Clicks Right';

        const verticalCorrection =
            dyMOA > 0
                ? verticalClicks + ' Clicks Down'
                : verticalClicks + ' Clicks Up';

        document.getElementById('suggestedCorrection').textContent =
            horizontalCorrection + ', ' + verticalCorrection;
    }

    function redraw() {
        drawTarget();
        drawShots();
        updateInputs();
        analyzeGroup();
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

    document.querySelectorAll('#windSpeedButtons button').forEach(function (button) {

        button.addEventListener('click', function () {

            document.getElementById('windspeed').value =
                this.dataset.speed;

            document.querySelectorAll('#windSpeedButtons button')
                .forEach(b => b.classList.remove('btn-primary'));

            document.querySelectorAll('#windSpeedButtons button')
                .forEach(b => b.classList.add('btn-default'));

            this.classList.remove('btn-default');
            this.classList.add('btn-primary');

        });

    });

    document.querySelectorAll('#windDirectionButtons button').forEach(function (button) {

        button.addEventListener('click', function () {

            document.querySelector('[name="winddirection"]').value =
                this.dataset.dir;

            document.querySelectorAll('#windDirectionButtons button')
                .forEach(b => b.classList.remove('btn-primary'));

            document.querySelectorAll('#windDirectionButtons button')
                .forEach(b => b.classList.add('btn-default'));

            this.classList.remove('btn-default');
            this.classList.add('btn-primary');

        });

    });

    redraw();
    })();
</script>

@stop
