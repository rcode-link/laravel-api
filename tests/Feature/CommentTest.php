<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CommentTest extends TestCase
{

    use RefreshDatabase, WithFaker;
    private function insertRequiredData():array{
        $users = User::factory(3)->create();
        return [
            $users,
            Post::factory(5)->create(['user_id' => $users[0]->id])
                            ->merge(Post::factory(5)->create(['user_id' => $users[1]->id])),
        ];
    }
    public function test_unutorized_user_cant_comment():void {
        $this->insertRequiredData();

         $request = $this->postJson(route('comments.store'), [
            'content' => $this->faker->sentence
        ]);
        $request->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_user_can_comment():void {

        [$users, $posts] = $this->insertRequiredData();

        $request = $this->actingAs($users[1])->postJson(route('comments.store'), [
            'content' => $this->faker->sentence,
            'post_id' => $posts[0]->id
        ]);
        $request->assertStatus(Response::HTTP_CREATED);
    }

    public function test_user_cant_delete_another_users_comment():void {

        [$users, $posts] = $this->insertRequiredData();

        $comment = Comment::create([
            'user_id' => $users[0]->id,
            'content' => $this->faker->sentence,
            'post_id' => $posts[0]->id
        ]);

        $request = $this->actingAs($users[1])->deleteJson(route('comments.update',$comment->id));
        $request->assertStatus(Response::HTTP_FORBIDDEN);
    }
    public function test_user_cant_delete_comment():void {

        [$users, $posts] = $this->insertRequiredData();

        $comment = Comment::create([
            'user_id' => $users[0]->id,
            'content' => $this->faker->sentence,
            'post_id' => $posts[0]->id
        ]);

        $request = $this->actingAs($users[0])->deleteJson(route('comments.update',$comment->id));

        $request->assertStatus(Response::HTTP_NO_CONTENT);
    }
    public function test_user_cant_update_another_users_comment():void {

        [$users, $posts] = $this->insertRequiredData();

        $comment = Comment::create([
            'user_id' => $users[0]->id,
            'content' => $this->faker->sentence,
            'post_id' => $posts[0]->id
        ]);

        $request = $this->actingAs($users[1])->putJson(route('comments.update',$comment->id), [
            'content' => 'updated comment'
        ]);

        $request->assertStatus(Response::HTTP_FORBIDDEN);
    }
    public function test_user_cant_update_comment():void {

        [$users, $posts] = $this->insertRequiredData();

        $comment = Comment::create([
            'user_id' => $users[0]->id,
            'content' => $this->faker->sentence,
            'post_id' => $posts[0]->id
        ]);

        $request = $this->actingAs($users[0])->putJson(route('comments.update',$comment->id), [
            'content' => 'updated comment'
        ]);

        $request->assertStatus(Response::HTTP_OK);
    }
 }
