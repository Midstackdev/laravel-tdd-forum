<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FavouritesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_guest_can_not_favourite_a_anything()
    {
        $this->post('replies/1/favourites')
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_favourite_a_reply()
    {
        $this->signIn();

        $reply = create('App\Models\Reply');

        $this->post('replies/' .$reply->id . '/favourites');


        $this->assertCount(1, $reply->favourites);
    }

    /** @test */
    public function an_authenticated_user_can_favourite_a_reply_once()
    {
        $this->signIn();

        $reply = create('App\Models\Reply');

        $this->post('replies/' .$reply->id . '/favourites');
        $this->post('replies/' .$reply->id . '/favourites');

                // dd(\App\Models\Favourite::all()->toArray());


        $this->assertCount(1, $reply->favourites);
    }
}
