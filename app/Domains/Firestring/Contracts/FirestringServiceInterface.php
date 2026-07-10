<?php

namespace App\Domains\Firestring\Contracts;

use App\Models\Firestring;

interface FirestringServiceInterface
{
    public function update(
        Firestring $firestring,
        array $input
    ): Firestring;
}
