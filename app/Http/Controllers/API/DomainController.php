<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $reference
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request, string $reference): JsonResponse
    {
        $domain = Domain::query()
            ->with('rules')
            ->where('reference', $reference)
            ->firstOrFail();

        return response()->json([
            'status' => true,
            'message' => 'Domain fetched successfully.',
            'data' => [
                'domain' => $domain,
            ],
        ]);
    }
}
