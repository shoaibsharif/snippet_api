<?php

namespace App\Http\Resources\Snippet;

use App\Http\Resources\Step\StepResource;
use App\Http\Resources\User\PublicUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SnippetResource extends JsonResource
{
    /**
     * @var mixed
     */

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return array_filter([
            'id' => $this->id,
            'title' => $this->title ?? '',
            'steps' => StepResource::collection($this->whenLoaded('steps')),
            'is_public' => (bool) $this->is_public,
            'author' => new PublicUserResource($this->user),
            'owner' => auth()->guard('sanctum')->user()?->id == $this->user_id,
            'steps_count' => $this?->steps_count,
        ]);
    }
}
