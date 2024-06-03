<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchPostsRequest;
use App\Http\Resources\PostApiResource;
use App\Models\Post;

class PublicPostController extends Controller
{
    /**
     * Public Post Display
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
        if($searchPostsRequest->routeIs('admin.post.index')){
            $model->whereUserId(auth()->id());
        }
        return PostApiResource::collection($model->paginate());

    }

    /**
     * Public Post Display
     */
    public function show(Post $post)
    {
        $post->load('tags', 'user', 'comment');
        return new PostApiResource($post);
        //
    }


}
