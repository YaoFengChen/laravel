<?php

namespace Tests\Feature;

use App\Model\Members;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        Members::factory()->count(30)->create();

        $this->assertDatabaseCount('members', 30);

        $response = $this->get('/');
        $response->assertStatus(404);
    }

    public function testCount()
    {
        $this->assertDatabaseCount('members', 0);
    }
}
