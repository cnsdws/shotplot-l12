<?php

return [

    'standing' => [
        'id' => 'standing',
        'name' => 'Standing',
        'allowsSlingSupport' => false,
        'allowsMagazineSupport' => false,
        'description' => 'Erect on both feet with no other portion of the body touching the ground or support.',
    ],

    'sitting' => [
        'id' => 'sitting',
        'name' => 'Sitting',
        'allowsSlingSupport' => true,
        'allowsMagazineSupport' => false,
        'description' => 'Weight supported on the buttocks and feet or ankles.',
    ],

    'kneeling' => [
        'id' => 'kneeling',
        'name' => 'Kneeling',
        'allowsSlingSupport' => true,
        'allowsMagazineSupport' => false,
        'description' => 'One knee touching the ground, with the buttocks clear of the ground.',
    ],

    'prone' => [
        'id' => 'prone',
        'name' => 'Prone',
        'allowsSlingSupport' => true,
        'allowsMagazineSupport' => false,
        'description' => 'Body extended on the ground, head toward the target.',
    ],

];
