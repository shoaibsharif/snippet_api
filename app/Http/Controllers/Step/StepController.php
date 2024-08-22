<?php

namespace App\Http\Controllers\Step;

use App\Http\Controllers\Controller;
use App\Http\Resources\Step\StepResource;
use App\Models\Snippet;
use App\Models\Step;
use Illuminate\Http\Request;

class StepController extends Controller
{
    public function store(Snippet $snippet, Request $request)
    {
        $step = $snippet->steps()->create(array_merge(
            $request->only('title', 'body'), [
                'order' => $this->getOrder($request),
            ]
        ));

        return new StepResource($step);
    }

    public function update(Snippet $snippet, Step $step, Request $request)
    {
        $this->authorize('update', $snippet);

        return $step->update($request->only('title', 'body'));
    }

    protected function getOrder(Request $request)
    {
        return Step::where('id', $request->before)->orWhere('id', $request->after)->first()->{($request->before ? 'before' : 'after').'Order'}();
    }

    public function destroy(Snippet $snippet, Step $step, Request $request)
    {
        $this->authorize('destroy', $snippet);
        if ($snippet->steps()->count() === 1) {
            return response('At least 1 step is required', 400);
        }
        $step->delete();
    }
}
