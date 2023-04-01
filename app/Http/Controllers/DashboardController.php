<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Inertia\Response
     */
    public function __invoke(Request $request): Response
    {
        $domains = $request->user()->domains;

        if ($domain = $request->query('d')) {
            // get the rules of the domain
        }

        return Inertia::render('Dashboard', [
            'domains' => $domains,
            'domain' => $domain,
        ]);
    }
}
