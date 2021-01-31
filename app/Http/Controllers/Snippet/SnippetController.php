<?php

namespace App\Http\Controllers\Snippet;

use App\Http\Controllers\Controller;
use App\Http\Resources\Snippet\SnippetCollection;
use App\Http\Resources\Snippet\SnippetResource;
use App\Models\Snippet;
use Illuminate\Http\Request;

class SnippetController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $snippet = auth()->user()->snippets()->create();
        return $snippet;
    }

    public function index()
    {
        return new SnippetCollection(Snippet::with('user', 'steps')->paginate());
    }

    public function show(Snippet $snippet)
    {
        return new SnippetResource($snippet);
    }

    public function update(Snippet $snippet, Request $request)
    {
        $this->validate($request, [
            'title' => 'nullable'
        ]);

        $snippet->update($request->only('title'));
        return $snippet;
    }
}
