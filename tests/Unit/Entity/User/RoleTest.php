<?php


namespace Test\Unit\Entity\User;


use App\Entity\User;
use App\Shared;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use DatabaseTransactions;

    public function testChange(): void
    {
        $user = factory(User::class)->create(['role' => Shared::ROLE_USER]);
        self::assertFalse($user->isAdmin());
        $user->changeRole(Shared::ROLE_ADMIN);
        self::assertTrue(Shared::ROLE_ADMIN);
    }

    public function testAlready(): void
    {
        $user = factory(User::class)->create(['role' => Shared::ROLE_ADMIN]);
        $this->expectExceptionMessage('Role is already assigned.');
        $user->changeRole(Shared::ROLE_ADMIN);
    }
}
