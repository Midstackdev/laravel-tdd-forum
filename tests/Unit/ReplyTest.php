<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReplyTest extends TestCase
{
	use DatabaseMigrations;
    /** @test */
    public function it_has_an_owner()
    {
        $reply = factory('App\Models\Reply')->create();

        $this->assertInstanceOf('App\Models\User', $reply->owner);
    }

    /** @test */
    public function a_reply_knows_it_was_just_published()
    {
        $reply = factory('App\Models\Reply')->create();

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->subMonth();

        $this->assertFalse($reply->wasJustPublished());
    }

    /** @test */
    public function it_can_detected_all_mentioned_users_in_the_body()
    {
        $reply = create('App\Models\Reply', [
            'body' => '@JaneDoe wants to talk to @JohnDoe'
        ]);

        $this->assertEquals(['JaneDoe', 'JohnDoe'], $reply->mentionedUsers());
    }
}
