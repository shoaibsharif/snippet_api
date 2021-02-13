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

    public function index(Request $request)
    {
        return new SnippetCollection(Snippet::with('user')->latest()->public()->paginate($request->get('limit', 10)));
    }

    public function show(Snippet $snippet)
    {

        $this->authorize('show', $snippet);
        return new SnippetResource($snippet->load('steps'));
    }

    public function update(Snippet $snippet, Request $request)
    {
        $this->authorize('update', $snippet);
        $this->validate($request, [
            'title' => 'nullable',
            'is_public' => 'nullable|boolean'
        ]);

        $snippet->update($request->only('title', 'is_public'));
        return $snippet;
    }

    public function destroy(Snippet $snippet)
    {
        $this->authorize('destroy', $snippet);

        $snippet->delete();
    }
}
