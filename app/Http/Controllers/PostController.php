<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchPostsRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostApiResource;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Post Display
     */
    public function index(SearchPostsRequest $searchPostsRequest)
    {
        $model = Post::query();
        if($searchPostsRequest->has('tags')){
            $model->withAllTags($searchPostsRequest->get('tags'));
        }
        if($searchPostsRequest->has('search') && \Str::length($searchPostsRequest->get('search')) > 0){
            $model->where('title', 'like', '%' . $searchPostsRequest->get('search') .'%')
                ->orWhere('content', 'like', '%' . $searchPostsRequest->get('search') .'%');
        }
        $model->with('tags', 'user');
        $model->withCount('comment');
        $model->whereUserId(auth()->id());
        return PostApiResource::collection($model->paginate());

    }

    /**
     * Post Store
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $model = Post::create($data);
        return new PostApiResource($model);
    }

    /**
     * Post Display
     */
    public function show(Post $post)
    {
        $post->load('tags', 'user', 'comment');
        return new PostApiResource($post);
        //
    }

   /**
     * Post Update
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        Gate::authorize('update',  $post);
        $data = $request->only('title', 'content');
        $post->update($data);
        $post->syncTags($request->get('tags'));
        //
    }

    /**
     * Post Remove
     */
    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);
        $post->delete();

        return response()->noContent();
        //
    }
}
