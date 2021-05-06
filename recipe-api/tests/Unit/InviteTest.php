<?php

namespace Tests\Unit;

use App\Models\Invitation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class InviteTest extends TestCase
{

    use RefreshDatabase;


    public function test_dinner_invite_created(){
        $this->withoutExceptionHandLing();
       $response = $this->json('POST', '/invitation', []);
       $this->assertDatabaseCount('invitations', 1);
       $response->assertStatus(201);
    }
}
