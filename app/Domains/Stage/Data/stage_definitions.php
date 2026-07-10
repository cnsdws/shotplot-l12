cat > app/Domains/Stage/Data/stage_definitions.php <<'PHP'
<?php

return [

    'nra-hp-200-slow-standing' => [
        'id' => 'nra-hp-200-slow-standing',
        'name' => '200 Yard Slow Fire',
        'positionId' => 'standing',
        'targetId' => 'SR',
        'fireType' => 'slow',
        'distance' => 200,
        'distanceUnit' => 'yards',
        'shotCount' => 10,
    ],

    'nra-hp-200-rapid-sitting' => [
        'id' => 'nra-hp-200-rapid-sitting',
        'name' => '200 Yard Rapid Fire',
        'positionId' => 'sitting',
        'targetId' => 'SR',
        'fireType' => 'rapid',
        'distance' => 200,
        'distanceUnit' => 'yards',
        'shotCount' => 10,
    ],

    'nra-hp-300-rapid-prone' => [
        'id' => 'nra-hp-300-rapid-prone',
        'name' => '300 Yard Rapid Fire',
        'positionId' => 'prone',
        'targetId' => 'SR-3',
        'fireType' => 'rapid',
        'distance' => 300,
        'distanceUnit' => 'yards',
        'shotCount' => 10,
    ],

    'nra-hp-600-slow-prone' => [
        'id' => 'nra-hp-600-slow-prone',
        'name' => '600 Yard Slow Fire',
        'positionId' => 'prone',
        'targetId' => 'MR-1',
        'fireType' => 'slow',
        'distance' => 600,
        'distanceUnit' => 'yards',
        'shotCount' => 20,
    ],

];
