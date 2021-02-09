<?php

namespace App\Http\Resources\Snippet;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SnippetCollection extends ResourceCollection
{

    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => SnippetResource::collection($this->collection),
        ];
    }
}
