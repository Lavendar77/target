<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDomainRequest;
use App\Models\Domain;
use Illuminate\Http\RedirectResponse;

class DomainController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreDomainRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreDomainRequest $request): RedirectResponse
    {
        Domain::query()->create([
            'user_id' => $request->user()->id,
            'name' => $request->name,
            'base_url' => $request->base_url,
        ]);

        return redirect()->route('dashboard');
    }
}
