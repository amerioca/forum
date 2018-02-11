<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInForumTest extends TestCase
{
	use DatabaseMigrations;

	/* @test */
	public function an_unauthorized_user_may_participate_in_forum_threads()
	{
		$this->expectException('Illuminate\Auth\AuthenticateException');
    	$this->post('/threads/test-thread/1/replies', []);
	}

    /**
     * @test
     */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
    	$this->be(factory('App\User')->create());
    	$thread = factory('App\Thread')->create();
    	$reply = factory('App\Reply')->make();
    	//var_dump($reply->toArray());
    	$this->post($thread->path().'/replies', $reply->toArray());

    	$this->get($thread->path())
        	->assertSee($reply->body);
    }

    /* @test */
    public function a_reply_requires_a_body()
    {
        $this->withExceptionHandling()->signIn();

        $thread = factory('App\Thread')->create();
        $reply = factory('App\Reply', ['body' => null])->make();

        $this->post($thread->path().'/replies', $reply->toArray())
            ->assertSessionsHasErrors('body');

    }
}
