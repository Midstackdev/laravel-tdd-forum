<?php

namespace Tests\Feature;

use App\Models\Activity;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guest_may_not_create_a_new_forum_thread()
    {
        $this->withoutExceptionHandling()->expectException('Illuminate\Auth\AuthenticationException');

        $this->get('/threads/create')
            ->assertRedirect('/login');

        $this->post('/threads')
            ->assertRedirect('/login');
    }

     /** @test */
    // public function guest_can_not_see_create_a_new_forum_thread_page()
    // {
    //     $this->withoutExceptionHandling()->expectException('Illuminate\Auth\AuthenticationException');
    //     $this->get('/threads/create')
    //         ->assertRedirect('/login');
    // }
   
   /** @test */
    public function an_authenticated_user_can_create_a_new_forum_thread()
    {
        $this->signIn();

        $thread = make('App\Models\Thread');

        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location')) 
              ->assertSee($thread->title)
              ->assertSee($thread->body);
    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_a_valid_channel()
    {
        factory('App\Models\Channel', 2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    /** @test */
    public function unauthorized_user_cannot_delete_a_thread()
    {
        $thread = create('App\Models\Thread');  
        
        $this->delete($thread->path())->assertRedirect('/login');

        $this->signIn();
        $this->delete($thread->path())->assertStatus(403);
    }

    /** @test */
    public function thread_can_only_be_deleted_by_those_with_permissions()
    {
        $thread = create('App\Models\Thread');  
        
        $response = $this->delete($thread->path());

        $response->assertRedirect('/login'); 
    }

    /** @test */
    public function authorized_users_can_delete_threads()
    {
        $this->signIn();

        $thread = create('App\Models\Thread', ['user_id' => auth()->id()]);
        $reply = create('App\Models\Reply', ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertEquals(0, Activity::count());
    }

    public function publishThread($overrides = [])
    {
        $this->signIn();

        $thread = make('App\Models\Thread', $overrides);

        return $this->post('/threads', $thread->toArray());
    }
}
