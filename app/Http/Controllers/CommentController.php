<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    /**
     * TBD Comment Display
     */
    public function index()
    {
        //
    }

    /**
     *Comment Store
     */
    public function store(StoreCommentRequest $request)
    {
        $comment = Comment::create($request->validated());
        return new CommentResource($comment);
        //
    }

    /**
     * TBD Comment Display


     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     *Comment Update
     */
    public function update(UpdateCommentRequest $request,$commentId)
    {
        $comment = Comment::whereId($commentId)->firstOrFail();
        Gate::authorize('update', $comment);
        $comment->update($request->validated());
        return new CommentResource($comment);
        //
    }

    /**
     * Comment Remove
     */
    public function destroy($commentId)
    {
        $comment = Comment::whereId($commentId)->firstOrFail();
        Gate::authorize('delete', $comment);
        $comment->delete();
        return response()->noContent();
        //
    }
}
