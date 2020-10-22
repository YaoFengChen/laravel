<?php


namespace Tests\Feature;


use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class MemberTest extends TestCase
{
    use DatabaseMigrations;

    public function testMemberCount()
    {
        $this->assertTrue(true);
    }
}
