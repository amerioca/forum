<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->thread = factory('App\Thread')->create();
    }

     /** 
    @test
    **/
    public function a_user_can_view_all_threads()
    {
        $response = $this->get('/threads')
            ->assertSee($this->thread->title);

    }
    /**
     * @test
     */
    public function a_user_can_read_a_single_threads()
    {
        $response = $this->get('/threads/' . $this->thread->id)
            ->assertSee($this->thread->title);
    }

    /**
     * @test
     */
    public function a_user_can_read_replies_that_are_associated_with_a_thread()
    {

        $reply = factory('App\Reply')
            ->create(['thread_id' => $this->thread->id]);
// var_dump($reply->body);
// echo ('/threads/' . $this->thread->id);
       $this->get('/threads/' . $this->thread->id)
            ->assertSee($reply->body);
            //->assertSee($this->thread->title);
    }

   
}
