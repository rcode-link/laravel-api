<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase, WithFaker;


    public function test_user_can_se_his_posts(): void
    {
        $this->seed();

        $user = User::query()->first();
        $anotherUser = User::factory()->create();
        Post::factory(5)->create(['user_id' =>$user]);
        Post::factory(5)->create(['user_id' =>$anotherUser]);
        $request = $this->actingAs($user)->getJson(route('admin.posts.index'));

        $request->assertJsonCount(5, ['data']);
   }
    public function test_user_can_create_post(): void
    {
        $this->seed();

        $user = User::query()->first();

        $response = $this->actingAs($user)->postJson(route('admin.posts.store'), [
            'title' => $this->faker->title,
            'content' => $this->faker->text($maxNbChars = 300),
            'tags' => ['tag 1', 'tag 2']
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure(['data' => ['id']]);
        $this->assertDatabaseCount(Post::class, 1);
    }
    public function test_user_cant_edit_another_users_post(): void
    {
        $this->seed();

        $user = User::query()->first();
        $anotherUser = User::factory()->create();
        Post::factory(5)->create(['user_id' =>$user]);
        $posts = Post::factory(5)->create(['user_id' =>$anotherUser]);

        $response = $this->actingAs($user)->putJson(route('admin.posts.update', $posts[0]), [
            'title' => 'new title'
        ]);
        $response->assertStatus(Response::HTTP_FORBIDDEN);

    }

    public function test_user_can_edit_his_post(): void
    {
        $this->seed();

        $user = User::query()->first();
        $posts =Post::factory(5)->create(['user_id' =>$user]);

        $this->actingAs($user)->putJson(route('admin.posts.update', $posts[0]), [
            'title' => 'new title'
        ]);
        $post = Post::whereSlug('new-title')->first();
        $this->assertNotNull($post);
    }
    public function test_user_cant_delete_another_users_post(): void
    {
        $this->seed();

        $user = User::query()->first();
        $anotherUser = User::factory()->create();
        Post::factory(5)->create(['user_id' =>$user]);
        $posts = Post::factory(5)->create(['user_id' =>$anotherUser]);

        $response = $this->actingAs($user)->deleteJson(route('admin.posts.destroy', $posts[0]));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

    }

    public function test_user_can_delete_his_post(): void
    {
        $this->seed();

        $user = User::query()->first();
        $posts =Post::factory(5)->create(['user_id' =>$user]);

        $this->actingAs($user)->deleteJson(route('admin.posts.destroy', $posts[0]->id));

        $this->assertDatabaseCount(Post::class, 4);
    }


}
