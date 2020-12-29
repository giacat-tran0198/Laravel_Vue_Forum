<?php

namespace Tests\Unit;

use App\Exceptions\SpamException;
use App\Inspections\Spam;
use Tests\TestCase;

class SpamTest extends TestCase
{
    /** @test */
    public function it_checks_for_invalid_keywords()
    {
        $spam = new Spam();
        $this->assertFalse($spam->detect('Innocent reply here'));
        $this->expectException(SpamException::class);
        $spam->detect('yahoo customer support');
    }

    /** @test */
    public function it_checks_for_any_key_being_held_down()
    {
        $spam = new Spam();
        $this->expectException(SpamException::class);
        $spam->detect('Hello world aaaaaaaaa');
    }
}
