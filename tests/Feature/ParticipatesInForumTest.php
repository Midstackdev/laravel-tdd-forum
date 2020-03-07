<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipatesInForumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_an_authenticated_user_can_participate_in_forum_threads()
    {
        // $user = factory('App\Models\User')->create();

        $this->be($user = factory('App\Models\User')->create());

        $thread = factory('App\Models\Thread')->create();

        $reply = factory('App\Models\Reply')->make();
        $this->post($thread->path(). '/replies', $reply->toArray());

        $this->get($thread->path())->assertSee($reply->body);
    }

    /** @test */
    public function unauthenticated_users_can_not_participate_in_forum_threads()
    {
        
        $this->withoutExceptionHandling()->expectException('Illuminate\Auth\AuthenticationException');

        // $thread = factory('App\Models\Thread')->create();

        // $reply = factory('App\Models\Reply')->make();
        // $this->post($thread->path(). '/replies', $reply->toArray());
        $this->post('/threads/some-channel/1/replies', [])
                ->assertRedirect('/login');
    }

    /** @test */
    public function q_reply_requires_a_body()
    {
        
        $this->signIn();

        $thread = create('App\Models\Thread');

        $reply = make('App\Models\Reply', ['body' => null ]);
        $this->post($thread->path(). '/replies', $reply->toArray())
                ->assertSessionHasErrors('body');
    }
}
