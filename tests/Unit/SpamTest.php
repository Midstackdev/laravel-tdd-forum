<?php

namespace Tests\Unit;

use App\Services\Spam\Spam;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SpamTest extends TestCase
{

    /** @test */
    public function it_checks_for_invalid_keywords()
    {
        $spam = new Spam();

        $this->assertFalse($spam->detect('Innoccent reply here'));

        $this->expectException(\Exception::class);

        $spam->detect('yahoo customer support');
    }

    /** @test */
    public function it_checks_for_any_key_being_held_down()
    {
        $spam = new Spam();

        $this->expectException(\Exception::class);

        $spam->detect('Helo world aaaaaaa');
    }

}
