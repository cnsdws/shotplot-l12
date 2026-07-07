<?php

return [

    'ruleSet' => 'NRA High Power',

    'templates' => [

        'national_match_course' => [

            'name' => 'National Match Course',

            'description' => 'Standard NRA/CMP National Match Course',

            'stages' => [

                [
                    'sequence' => 1,
                    'name' => '200 Yard Slow Fire',
                    'position' => 'Standing',
                    'fireType' => 'Slow',
                    'distance' => 200,
                    'distanceUnit' => 'yards',
                    'shots' => 20,
                ],

                [
                    'sequence' => 2,
                    'name' => '200 Yard Rapid Fire',
                    'position' => 'Sitting',
                    'fireType' => 'Rapid',
                    'distance' => 200,
                    'distanceUnit' => 'yards',
                    'shots' => 10,
                ],

                [
                    'sequence' => 3,
                    'name' => '300 Yard Rapid Fire',
                    'position' => 'Prone',
                    'fireType' => 'Rapid',
                    'distance' => 300,
                    'distanceUnit' => 'yards',
                    'shots' => 10,
                ],

                [
                    'sequence' => 4,
                    'name' => '600 Yard Slow Fire',
                    'position' => 'Prone',
                    'fireType' => 'Slow',
                    'distance' => 600,
                    'distanceUnit' => 'yards',
                    'shots' => 20,
                ],

            ],

        ],

    ],

];
