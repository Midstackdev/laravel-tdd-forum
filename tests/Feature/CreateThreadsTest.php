<?php

namespace Tests\Feature;

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
}
