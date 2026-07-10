<?php

namespace App\Domains\Shot\Contracts;

use App\Domains\Shot\DTOs\ShotCollection;
use App\Models\Firestring;

interface LegacyShotMapperInterface
{
    public function fromFirestring(
        Firestring $firestring
    ): ShotCollection;
}
