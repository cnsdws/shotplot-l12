<?php

namespace App\Domains\FirestringTemplate\Contracts;

use App\Domains\CoursePlanner\DTOs\StagePlan;
use App\Domains\FirestringTemplate\DTOs\FirestringTemplate;

interface FirestringTemplateServiceInterface
{
    public function build(StagePlan $stagePlan): FirestringTemplate;
}
