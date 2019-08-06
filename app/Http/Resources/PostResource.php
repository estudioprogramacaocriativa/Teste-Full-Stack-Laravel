<?php

namespace App\Http\Resources;

use App\Helpers\FileManager;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'image' => FileManager::get($this->image, "posts/{$this->id}", ['tim' => ['w' => 600, 'h' => 300]]),
            'friendly_url' => $this->friendly_url,
            'tags' => $this->tags,
            'author' => $this->author
        ];
    }
}
