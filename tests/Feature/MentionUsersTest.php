<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MentionUsersTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function mentioned_users_in_a_reply_are_notified()
    {
        $john = create('App\Models\User', ['name' => 'JohnDoe']);

        $this->signIn($john);

         $jane = create('App\Models\User', ['name' => 'JaneDoe']);

        $thread = create('App\Models\Thread');
        $reply = make('App\Models\Reply', ['body' => '@JaneDoe look at this with @JohnDoe.']);


        $this->post($thread->path(). '/replies', $reply->toArray());

        $this->assertCount(1, $jane->notifications);
    }

}
