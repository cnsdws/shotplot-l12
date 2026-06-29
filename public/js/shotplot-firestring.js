<script>
(function () {
    const canvas = document.getElementById('targetCanvas');
    const ctx = canvas.getContext('2d');
    const center = 275;
    const maxRadius = 250;
    const zeroBook = @json($zeros);

    const distanceSelect = document.getElementById('distance');
    const elevationInput = document.querySelector('[name="elevation"]');
    const windageInput = document.querySelector('[name="windage"]');
    const activeShotSelect = document.getElementById('activeShot');
    const ammoSelect = document.getElementById('ballistic_profile_id');
    const useDefaultAmmo = document.getElementById('useDefaultAmmo');
    const defaultAmmoMap = @json($defaultAmmoMap);

    let shotCount = getShotCount();
    let target = getTarget();
    const shots = {};

    function applyDefaultAmmoForDistance() {
        if (!useDefaultAmmo || !useDefaultAmmo.checked) {
            return;
        }

        if (!ammoSelect) {
            return;
        }

        ammoSelect.value = defaultAmmoMap[distanceSelect.value] || '';
    }

    for (let i = 1; i <= 20; i++) {
        shots[i] = { x: null, y: null };
    }

    function getShotCount() {
        return distanceSelect.value === '600 Yard Slow Fire' ? 20 : 10;
    }

    function getTarget() {
        const targetType = ShotPlotTargetForDistance(distanceSelect.value);
        return ShotPlotTargets[targetType] || ShotPlotTargets["SR"];
    }

    function rebuildActiveShotOptions() {
        activeShotSelect.innerHTML = '';

        for (let i = 1; i <= shotCount; i++) {
            const option = document.createElement('option');
            option.value = i;
            option.textContent = 'Shot ' + i;
            activeShotSelect.appendChild(option);
        }

        document.querySelectorAll('.shot-row').forEach(function (row) {
            const shotNumber = Number(row.dataset.shot);
            row.style.display = shotNumber <= shotCount ? '' : 'none';
        });
    }

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
        for (let i = 1; i <= shotCount; i++) {
            const shot = shots[i];

            if (shot.x === null || shot.y === null) {
                continue;
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
            ctx.fillText(i, shot.x, shot.y);
        }
    }

    function updateInputs() {
        for (let i = 1; i <= 20; i++) {
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
            if (shots[i].x !== null && shots[i].y !== null) {
                plottedShots.push(shots[i]);
            }
        }

        document.getElementById('shotsPlotted').textContent = plottedShots.length;

        if (plottedShots.length < 2) {
            document.getElementById('groupCenter').textContent = 'N/A';
            document.getElementById('extremeSpread').textContent = 'N/A';
            document.getElementById('meanRadius').textContent = 'N/A';
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
    }

    function applyZeroForDistance() {
        const zero = zeroBook[distanceSelect.value];

        if (!zero) {
            elevationInput.value = '';
            windageInput.value = '';
            return;
        }

        if (elevationInput) {
            elevationInput.value = zero.elevation ?? '';
        }

        if (windageInput) {
            windageInput.value = zero.windage ?? '';
        }
    }

    function applyStageConfiguration() {
        applyZeroForDistance();
        applyDefaultAmmoForDistance();
    }

    function redraw() {
        target = getTarget();
        shotCount = getShotCount();
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

        const scoreInput = document.getElementById(`shot${activeShot}value`);
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

        const scoreInput = document.getElementById(`shot${activeShot}value`);
        if (scoreInput) {
            scoreInput.value = '';
        }

        redraw();
    });

    document.getElementById('clearAllShots').addEventListener('click', function () {
        for (let i = 1; i <= 20; i++) {
            shots[i] = { x: null, y: null };

            const scoreInput = document.getElementById(`shot${i}value`);
            if (scoreInput) {
                scoreInput.value = '';
            }
        }

        redraw();
    });

    distanceSelect.addEventListener('change', function () {
        shotCount = getShotCount();
        rebuildActiveShotOptions();
        applyStageConfiguration();
        redraw();
    });

    rebuildActiveShotOptions();
    applyStageConfiguration();
    redraw();
    })();
</script>

