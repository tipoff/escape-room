<?php

declare(strict_types=1);

namespace Tipoff\EscapeRoom\Tests\Feature\Nova;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\EscapeRoom\Models\EscapeRoomMarket;
use Tipoff\EscapeRoom\Tests\TestCase;

class EscapeRoomMarketResourceTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function index()
    {
        EscapeRoomMarket::factory()->count(1)->create();

        $this->actingAs(self::createPermissionedUser('view escape room markets', true));

        $response = $this->getJson('nova-api/escape-room-markets')->assertOk();

        $this->assertCount(1, $response->json('resources'));
    }
}