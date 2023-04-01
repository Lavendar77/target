<?php

namespace App\Http\Controllers;

use App\Actions\SaveDomainRuleAction;
use App\Http\Requests\StoreDomainRuleRequest;
use App\Models\Domain;
use Illuminate\Http\RedirectResponse;

class DomainRuleController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreDomainRuleRequest $request
     * @param string $domain
     * @param \App\Actions\SaveDomainRuleAction $saveDomainRuleAction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(
        StoreDomainRuleRequest $request,
        string $domain,
        SaveDomainRuleAction $saveDomainRuleAction
    ): RedirectResponse {
        $domain = Domain::query()
            ->where('user_id', $request->user()->id)
            ->findOrFail($domain);

        // store the rules
        $saveDomainRuleAction->create($domain->id, $request->domain_rules);

        session()->flash('message', 'Domain rules saved successfully.');

        return redirect()->route('dashboard', [
            'd' => $domain->id,
        ]);
    }
}
