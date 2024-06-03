<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string $slug
 * @property int $user_id
 * @property \Illuminate\Database\Eloquent\Collection<int, \Spatie\Tags\Tag> $tags
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comment
 * @property-read int|null $comment_count

 */

class PostApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->when($request->routeIs('*.show'), $this->content, \Str::substr($this->content, 0, 150)),
            'tags' => TagResource::collection($this->tags),
            'user' => new UserResource($this->user),
            'comment_count' => $this->when($request->routeIs('*.index'),$this->comment_count),
            'comments' => $this->when($request->routeIs('*.show'), CommentResource::collection($this->comment)),
        ];
    }
}
