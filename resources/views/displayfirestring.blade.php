@extends('_firestringmaster')

@section('title')
<h3>{{ $firestring->distance }}</h3>
@stop

@section('editfirestring')
<br>
<p>
    <a href="/indexfirestring/{{ $firestring->match_id }}" class="btn btn-link">
        Back to Firestrings
    </a>

    <a href="/firestrings/{{ $firestring->id }}/adjustments" class="btn btn-info">
        Adjustment Log
    </a>

    <a href="/displayfirestring/{{ $firestring->id }}/print" class="btn btn-success">
        Print Report
    </a>
</p>
<br>

<h3>{{ $firestring->distance }}</h3>

<div class="row">
    <div class="col-md-4">
        <table class="table table-striped">
            <tbody>
                <h4>String #{{ $firestring->fire_string_number }}</h4>
                <tr><td>Distance</td><td>{{ $firestring->distance }}</td></tr>
                <tr><td>Score</td><td><strong>{{ $firestring->formattedScore() }}</strong></td></tr>
                <tr><td>Ammo</td><td>@if ($firestring->ballisticProfile){{$firestring->ballisticProfile->name }}@else<span class="text-muted">None selected</span>@endif</td></tr>
                <tr><td>Target #</td><td>{{ $firestring->target }}</td></tr>
                <tr><td>Relay #</td><td>{{ $firestring->relay }}</td></tr>
                <tr><td>Light Direction</td><td>{{ $firestring->lightdirection }}</td></tr>
                <tr><td>Wind Direction</td><td>{{ $firestring->winddirection }}</td></tr>
                <tr><td>Wind Speed</td><td>{{ $firestring->windspeed }} mph</td></tr>
                <tr><td>Notes</td><td>{{ $firestring->range_notes }}</td></tr>
                <tr><td>Elevation</td><td>{{ $firestring->elevation }}</td></tr>
                <tr><td>Windage</td><td>{{ $firestring->windage }}</td></tr>
            </tbody>
        </table>

        <hr>

        <div class="panel panel-default">
            <div class="panel-heading">
            <a data-toggle="collapse" href="#adjustmentLogPanel">
                <strong>Adjustment Log</strong>
            </a>
            </div>

            <div id="adjustmentLogPanel" class="panel-collapse collapse in">
                <div class="panel-body">
                    @if ($firestring->adjustments->isEmpty())
                        <p class="text-muted">No sight adjustments recorded.</p>
                    @else
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th>Shot</th>
                                    <th>Elevation</th>
                                    <th>Windage</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($firestring->adjustments as $adjustment)
                                    <tr>
                                        <td>{{ $adjustment->shot_number }}</td>
                                        <td>{{ $adjustment->elevation_setting }}</td>
                                        <td>
                                            @if ($adjustment->windage_setting > 0)
                                                {{ $adjustment->windage_setting }}R
                                            @elseif ($adjustment->windage_setting < 0)
                                                {{ abs($adjustment->windage_setting) }}L
                                            @else
                                                0
                                            @endif
                                        </td>
                                        <td>{{ $adjustment->notes }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    <a href="/firestrings/{{ $firestring->id }}/adjustments" class="btn btn-info">
                        Manage Adjustments
                    </a>
                </div>
            </div>
        </div>
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
        <div class="clearfix" style="margin-bottom:15px;">
            @if($previousFirestring)
                <a href="/displayfirestring/{{ $previousFirestring->id }}"
                   class="btn btn-default pull-left">
                    &laquo; String #{{ $previousFirestring->fire_string_number }}
                </a>
            @endif

            @if($nextFirestring)
                <a href="/displayfirestring/{{ $nextFirestring->id }}"
                   class="btn btn-default pull-right">
                    String #{{ $nextFirestring->fire_string_number }} &raquo;
                </a>
            @endif
        </div>
        <canvas id="targetCanvas" width="550" height="550" style="border:1px solid #ccc; max-width:100%;"></canvas>
        
        <hr>
        <div class="panel panel-default">
            <div class="panel-heading">
                <a data-toggle="collapse" href="#groupAnalysisPanel">
                    <strong>Group Analysis</strong>
                </a>
            </div>

            <div id="groupAnalysisPanel" class="panel-collapse collapse in">
                <div class="panel-body">
                    <p><strong>Shots Plotted:</strong> <span id="shotsPlotted">0</span></p>
                    <p><strong>Group Center:</strong> <span id="groupCenter">N/A</span></p>
                    <p><strong>Extreme Spread:</strong> <span id="extremeSpread">N/A</span></p>
                    <p><strong>Mean Radius:</strong> <span id="meanRadius">N/A</span></p>
                    <p><strong>Suggested Correction:</strong> <span id="suggestedCorrection">N/A</span></p>
                </div>
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
    const sightClickMOA = @json(optional(optional($firestring->match)->rifle)->sight_click_moa ?? 0.25);

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
            ) && distanceFromCenter <= ShotPlotRingRadiusPx(target, ring, maxRadius);
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
            document.getElementById('groupCenter').textContent = 'N/A';
            document.getElementById('extremeSpread').textContent = 'N/A';
            document.getElementById('meanRadius').textContent = 'N/A';
            document.getElementById('suggestedCorrection').textContent = 'N/A';
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
