<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;

    public function setUp(): void
    {
        parent::setUp();

        $this->thread = factory('App\Models\Thread')->create();
    }

    /** @test */
    public function a_user_can_browse_threads()
    {
        $response = $this->get('/threads');

        $response->assertStatus(200);
    }

    /** @test */
    public function a_user_can_browse_threads_title()
    {

        $response = $this->get('/threads');

        $response->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_see_a_specific_thread()
    {

        $response = $this->get($this->thread->path());

        $response->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_read_replies_associated_with_a_thread()
    {
        $reply = factory('App\Models\Reply')->create(['thread_id' => $this->thread->id]);

        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_thread_belongs_to_a_channel()
    {
        $thread = create('App\Models\Thread');

        $this->assertInstanceOf('App\Models\Channel', $thread->channel); 
    }

    /** @test */
    public function a_user_can_filter_threads_according_to_channel()
    {
        $channel = create('App\Models\Channel');
        $threadInChannel = create('App\Models\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Models\Thread');

        $this->get('/threads/' .$channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title); 
    }
}
