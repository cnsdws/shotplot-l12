<?php

namespace App\Domains\MatchFactory\Tests;

use Tests\TestCase;
use App\Domains\MatchFactory\Contracts\MatchFactoryServiceInterface;

class MatchFactoryServiceTest extends TestCase
{
    public function test_service_resolves_from_container(): void
    {
        $service = app(MatchFactoryServiceInterface::class);

        $this->assertInstanceOf(
            MatchFactoryServiceInterface::class,
            $service
        );
    }
}
