<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use Illuminate\Http\JsonResponse;

class DomainController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param string $reference
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(string $reference): JsonResponse
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
