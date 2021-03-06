<?php

declare(strict_types=1);

namespace Tipoff\EscapeRoom\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\EscapeRoom\Models\Room;
use Tipoff\EscapeRoom\Tests\TestCase;
use Tipoff\Support\Contracts\Models\UserInterface;

class RoomPolicyTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_any()
    {
        $user = self::createPermissionedUser('view rooms', true);
        $this->assertTrue($user->can('viewAny', Room::class));

        $user = self::createPermissionedUser('view rooms', false);
        $this->assertFalse($user->can('viewAny', Room::class));
    }

    /**
     * @test
     * @dataProvider data_provider_for_all_permissions_as_creator
     */
    public function all_permissions_as_creator(string $permission, UserInterface $user, bool $expected)
    {
        $room = Room::factory()->make([
            'creator_id' => $user,
        ]);

        $this->assertEquals($expected, $user->can($permission, $room));
    }

    public function data_provider_for_all_permissions_as_creator()
    {
        return [
            'view-true' => [ 'view', self::createPermissionedUser('view rooms', true), true ],
            'view-false' => [ 'view', self::createPermissionedUser('view rooms', false), false ],
            'create-true' => [ 'create', self::createPermissionedUser('create rooms', true), true ],
            'create-false' => [ 'create', self::createPermissionedUser('create rooms', false), false ],
            'update-true' => [ 'update', self::createPermissionedUser('update rooms', true), true ],
            'update-false' => [ 'update', self::createPermissionedUser('update rooms', false), false ],
            'delete-true' => [ 'delete', self::createPermissionedUser('delete rooms', true), false ],
            'delete-false' => [ 'delete', self::createPermissionedUser('delete rooms', false), false ],
        ];
    }

    /**
     * @test
     * @dataProvider data_provider_for_all_permissions_not_creator
     */
    public function all_permissions_not_creator(string $permission, UserInterface $user, bool $expected)
    {
        $room = Room::factory()->make();

        $this->assertEquals($expected, $user->can($permission, $room));
    }

    public function data_provider_for_all_permissions_not_creator()
    {
        // Permissions are identical for creator or others
        return $this->data_provider_for_all_permissions_as_creator();
    }
}
