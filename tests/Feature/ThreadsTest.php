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
    // public function a_user_can_read_replies_associated_with_a_thread()
    // {
    //     $reply = factory('App\Models\Reply')->create(['thread_id' => $this->thread->id]);

    //     $this->get($this->thread->path())
    //         ->assertSee($reply->body);
    // }

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

    /** @test */
    public function a_user_can_filter_threads_by_username()
    {
        $this->signIn(create('App\Models\User', ['name' => 'JohnDoe']));

        $threadByJohn = create('App\Models\Thread', ['user_id' => auth()->id()]);
        $threadNotByJohn = create('App\Models\Thread');

        $this->get('threads?by=JohnDoe')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_popularity()
    {

        $threadWithTwoReplies = create('App\Models\Thread');
        create('App\Models\Reply', ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create('App\Models\Thread');
        create('App\Models\Reply', ['thread_id' => $threadWithThreeReplies->id], 3);

        $threadWithNoReply = $this->thread;

        $response = $this->getJson('threads?popular=1')->json();

        $this->assertEquals([3, 2, 0], array_column($response['data'], 'replies_count'));
    }

    /** @test */
    public function a_user_can_filter_threads_by_unanswered()
    {
        $thread = create('App\Models\Thread');
        create('App\Models\Reply', ['thread_id' => $thread->id]);

        $response = $this->getJson('threads?unanswered=1')->json();

        $this->assertCount(1, $response['data']);
    }

    /** @test */
    public function a_user_can_request_all_replies_for_a_given_thread()
    {
        $thread = create('App\Models\Thread');
        create('App\Models\Reply', ['thread_id' => $thread->id], 2); 

        $response = $this->getJson($thread->path() . '/replies')->json();

        $this->assertCount(2, $response['data']);  
        $this->assertEquals(2, $response['total']);  
    }

    /** @test */
    // public function a_thread_records_each_visit()
    // {
    //     $thread = make('App\Models\Thread', ['id' => 1]);
    //     $thread->visits()->reset();
    //     $this->assertSame(0, $thread->visits()->count()); 

    //     $thread->visits()->record();
    //     $this->assertEquals(1, $thread->visits()->count()); 

    //     $thread->visits()->record();
    //     $this->assertEquals(2, $thread->visits()->count());   
    // }

    /** @test */
    public function we_record_a_new_visit_each_time_the_thread_is_read()
    {
        $thread = create('App\Models\Thread');
        $this->assertSame(0, $thread->visits);

        $this->call('GET', $thread->path()); 
        // dd($thread);
        $this->assertEquals(1, $thread->fresh()->visits);
    }


}
