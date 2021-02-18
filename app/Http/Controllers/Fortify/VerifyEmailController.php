<?php

namespace App\Http\Controllers\Fortify;

use Illuminate\Auth\Events\Verified;
use Illuminate\Routing\Controller;
use Laravel\Fortify\Http\Requests\VerifyEmailRequest;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param \Laravel\Fortify\Http\Requests\VerifyEmailRequest $request
     */
    public function __invoke(VerifyEmailRequest $request)
    {
        if ($request->email)
            if ($request->user()->hasVerifiedEmail()) {
//            return redirect()->intended(config('fortify.home').'?verified=1');
                return response()->noContent();
            }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

//        return redirect()->intended(config('fortify.home').'?verified=1');
        return response()->noContent();
    }
}
