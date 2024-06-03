<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class PublicPostTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     */
    public function test_unutorized_user_can_see_all_posts(): void
    {
        $users = User::factory(2)->create();
        Post::factory(5)->create(['user_id' =>$users[0]]);
        Post::factory(5)->create(['user_id' =>$users[1]]);

        $response = $this->get(route('posts.index'));
        $response->assertJsonCount(10, ['data']);
        $response->assertStatus(200);
    }

    public function test_unutorized_user_can_see_specific_post():void {
        $user = User::factory()->create();
        $post_ids =   Post::factory(5)->create(['user_id' =>$user]);

        $response = $this->get(route('posts.show', $post_ids[0]->id));
        $response->assertStatus(200);
    }


}
