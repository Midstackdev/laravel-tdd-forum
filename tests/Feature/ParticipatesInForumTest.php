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
    public function a_reply_requires_a_body()
    {
        
        $this->signIn();

        $thread = create('App\Models\Thread');

        $reply = make('App\Models\Reply', ['body' => null ]);
        $this->post($thread->path(). '/replies', $reply->toArray())
                ->assertSessionHasErrors('body');
    }

    /** @test */
    public function unauthorized_users_cannot_delete_replies()
    {
        $reply = create('App\Models\Reply');

        $this->delete("/replies/{$reply->id}")
            ->assertRedirect('/login');

        $this->signIn()
            ->delete("/replies/{$reply->id}")
            ->assertStatus(403);
    }


    /** @test */
    public function authorized_users_can_delete_replies()
    {
        $this->signIn();

        $reply = create('App\Models\Reply', ['user_id' => auth()->id()]);

        $this->delete("/replies/{$reply->id}")->assertStatus(302);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    /** @test */
    public function unauthorized_users_cannot_update_replies()
    {
        $reply = create('App\Models\Reply');

        $this->patch("/replies/{$reply->id}")
            ->assertRedirect('/login');

        $this->signIn()
            ->patch("/replies/{$reply->id}")
            ->assertStatus(403);
    }
    /** @test */
    public function authorized_users_can_update_replies()
    {
        $this->signIn();

        $reply = create('App\Models\Reply', ['user_id' => auth()->id()]);

        $updatedReply = 'You changed sucker.';
        $this->patch("/replies/{$reply->id}", ['body' => $updatedReply]);

        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $updatedReply]);
    }
}
