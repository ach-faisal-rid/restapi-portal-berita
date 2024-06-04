<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostDetailResource extends JsonResource
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
            'image' => $this->image,
            'news_content' => $this->news_content,
            'author' => $this->author,
            'writer' => $this->whenLoaded('writer'),
            'created_at' => date_format($this->created_at, 'Y/m/s H:i:s'),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
        ];
    }
}
