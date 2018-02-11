<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->thread = factory('App\Thread')->create();
    }
    
    /* @test **/
    public function a_user_can_browse_all_threads()
    {
        $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    /** @test **/
    public function a_user_can_read_a_single_thread()
    {
        $this->get('/threads/some-channel/' . $this->thread->id)
            ->assertSee($this->thread->title);
    }

    /** @test **/
    public function a_user_can_read_replies_that_are_associated_with_a_thread()
    {

        $reply = factory('App\Reply')
            ->create(['thread_id' => $this->thread->id]);
        $this->get('/threads/some-channel/' . $this->thread->id)
            ->assertSee($reply->body);
    }
    /** @test */
    public function a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create('App\Channel');
        //dd($channel);
        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');
        $link = "/threads/{$channel->slug}";
        //dd($link);
        //dd([ $threadInChannel, $threadNotInChannel ]);
        $this->get($link)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }
}
