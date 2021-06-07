<?php

namespace App\Http\Resources\Snippet;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SnippetCollection extends ResourceCollection
{
    public $collects = SnippetResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
    }
}
