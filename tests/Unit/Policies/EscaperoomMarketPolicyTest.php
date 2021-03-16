<?php

declare(strict_types=1);

namespace Tipoff\EscapeRoom\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\EscapeRoom\Models\EscaperoomMarket;
use Tipoff\EscapeRoom\Tests\TestCase;
use Tipoff\Support\Contracts\Models\UserInterface;

class EscaperoomMarketPolicyTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_any()
    {
        $user = self::createPermissionedUser('view escape room markets', true);
        $this->assertTrue($user->can('viewAny', EscaperoomMarket::class));

        $user = self::createPermissionedUser('view escape room markets', false);
        $this->assertFalse($user->can('viewAny', EscaperoomMarket::class));
    }

    /**
     * @test
     * @dataProvider data_provider_for_all_permissions_as_creator
     * @param string $permission
     * @param UserInterface $user
     * @param bool $expected
     */
    public function all_permissions_as_creator(string $permission, UserInterface $user, bool $expected)
    {
        $room = EscaperoomMarket::factory()->make([
            'creator_id' => $user,
        ]);

        $this->assertEquals($expected, $user->can($permission, $room));
    }

    public function data_provider_for_all_permissions_as_creator()
    {
        return [
            'view-true' => ['view', self::createPermissionedUser('view escape room markets', true), true],
            'view-false' => ['view', self::createPermissionedUser('view escape room markets', false), false],
            'create-true' => ['create', self::createPermissionedUser('create escape room markets', true), true],
            'create-false' => ['create', self::createPermissionedUser('create escape room markets', false), false],
            'update-true' => ['update', self::createPermissionedUser('update escape room markets', true), true],
            'update-false' => ['update', self::createPermissionedUser('update escape room markets', false), false],
            'delete-true' => ['delete', self::createPermissionedUser('delete escape room markets', true), false],
            'delete-false' => ['delete', self::createPermissionedUser('delete escape room markets', false), false],
        ];
    }

    /**
     * @test
     * @dataProvider data_provider_for_all_permissions_not_creator
     * @param string $permission
     * @param UserInterface $user
     * @param bool $expected
     */
    public function all_permissions_not_creator(string $permission, UserInterface $user, bool $expected)
    {
        $room = EscaperoomMarket::factory()->make();

        $this->assertEquals($expected, $user->can($permission, $room));
    }

    public function data_provider_for_all_permissions_not_creator()
    {
        // Permissions are identical for creator or others
        return $this->data_provider_for_all_permissions_as_creator();
    }
}
