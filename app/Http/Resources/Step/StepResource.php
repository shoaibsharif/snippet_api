<?php

namespace App\Http\Resources\Step;

use Illuminate\Http\Resources\Json\JsonResource;

class StepResource extends JsonResource
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
            'order' => (float)$this->order,
            'title' => $this->title ?? '',
            'body' => $this->body ?? ''
        ];
    }
}
