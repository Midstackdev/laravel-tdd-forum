<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_notification_is_prpared_when_a_subscribed_thread_recieves_a_new_reply_that_is_not_by_current_user()
    {
        $this->signIn();

        $thread = create('App\Models\Thread')->subscribe();

        $this->post($thread->path() . '/subscriptions');

        $this->assertCount(0, auth()->user()->notifications);

        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Some reply here'
        ]);

        $this->assertCount(0, auth()->user()->fresh()->notifications); 

        $thread->addReply([
            'user_id' => create('App\Models\User')->id,
            'body' => 'Some reply here'
        ]);

        $this->assertCount(1, auth()->user()->fresh()->notifications);   
    }

    /** @test */
    public function a_user_can_fetch_their_unread_notifications()
    {
        $this->signIn();

        $thread = create('App\Models\Thread')->subscribe();  
        
        $thread->addReply([
            'user_id' => create('App\Models\User')->id,
            'body' => 'Some reply here'
        ]);
        $user = auth()->user(); 

        $response = $this->getJson("/profiles/{$user->name}/notifications")->json();

        $this->assertCount(1, $response); 
    }

    /** @test */
    public function a_user_can_mark_a_notification_as_read()
    {
        $this->signIn();

        $thread = create('App\Models\Thread')->subscribe();  
        
        $thread->addReply([
            'user_id' => create('App\Models\User')->id,
            'body' => 'Some reply here'
        ]);
        $user = auth()->user();

        $this->assertCount(1, $user->fresh()->unreadNotifications); 

        $notificationId = $user->unreadNotifications->first()->id;

        $this->delete("/profiles/{$user->name}/notifications/{$notificationId}");
        // dd(auth()->user()->fresh()->unreadNotifications);

        $this->assertCount(0, auth()->user()->fresh()->unreadNotifications); 
    }

}
