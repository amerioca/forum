<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadsTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
	public function guests_may_not_create_threads(){
        $this->withoutExceptionHandling()
		  ->expectException('Illuminate\Auth\AuthenticationException');
		$thread = make('App\Thread');
        $this->post('/threads', $thread->toArray());
	}

    /** @test */
    public function guests_cannot_see_the_create_thread_page()
    {
        $this->withExceptionHandling()
            ->get('/threads/create')
            ->assertRedirect('/login');
    }
    /**
     * A basic test example.
     *
     * @test
     */
    public function an_authenticated_user_can_create_new_form_threads()
    {
        $this->signIn();
        $thread = make('App\Thread');
        $response = $this->post('/threads', $thread->toArray());
        //dd($this->path());
        $this->get($response->headers->get('Location'))
        	->assertSee($thread->title)
        	->assertSee($thread->body);
    }
    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->publishThread(
            [
                'title' => null 
            ])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(
            [
                'body' => null 
            ])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_a_valid_channel()
    {
        $this->publishThread(
            [
                'channel_id' => null 
            ])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(
            [
                'channel_id' => 999999 
            ])
            ->assertSessionHasErrors('channel_id');
    }
    
    function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();
        $thread = make('App\Thread', $overrides);

        return $this->post('/threads', $thread->toArray());
    }
}
