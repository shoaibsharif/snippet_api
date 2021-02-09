<?php

namespace App\Http\Controllers\Keys;

use Algolia\AlgoliaSearch\SearchClient;
use App\Http\Controllers\Controller;

class AlgoliaController extends Controller
{
    public function __invoke()
    {
        return response()->json([
            'data' => SearchClient::generateSecuredApiKey(
                config('scout.algolia.key'), [
                    'filters' => 'data.is_public'
                ]
            )
        ]);
    }
}
