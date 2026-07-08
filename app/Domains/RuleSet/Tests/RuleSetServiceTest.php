<?php

namespace App\Domains\RuleSet\Tests;

use Tests\TestCase;
use App\Domains\RuleSet\Contracts\RuleSetServiceInterface;

class RuleSetServiceTest extends TestCase
{
    public function test_service_resolves_from_container(): void
    {
        $service = app(RuleSetServiceInterface::class);

        $this->assertInstanceOf(
            RuleSetServiceInterface::class,
            $service
        );
    }
}
