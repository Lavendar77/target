<?php

namespace App\Http\Controllers;

use App\Enums\DomainRuleEnum;
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
        $domains = $request->user()
            ->domains()
            ->oldest()
            ->with('rules')
            ->get();

        return Inertia::render('Dashboard', [
            'domains' => $domains,
            'rules' => DomainRuleEnum::cases(),
            'domain_id' => $request->query('d'),
        ]);
    }
}
