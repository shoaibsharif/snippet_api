<?php

namespace App\Http\Resources\Snippet;

use App\Http\Resources\Step\StepResource;
use App\Http\Resources\User\PublicUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SnippetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title ?? "",
            'steps' => StepResource::collection($this->steps),
            'author' => new PublicUserResource($this->user),
            'owner' => auth()->guard('sanctum')->user()?->id == $this->user_id
        ];
    }
}
