<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @test
     */
    public function a_user_can_read_a_single_threads()
    {
        $response = $this->get('/threads');

        $response->assertStatus(200);
    }

    /** 
    @test
    **/
    public function a_user_can_view_all_threads()
    {

    }
}
