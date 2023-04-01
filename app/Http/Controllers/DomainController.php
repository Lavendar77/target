<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDomainRequest;
use App\Models\Domain;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

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
            'reference' => uniqid() . time(),
        ]);

        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Domain $domain
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Domain $domain): RedirectResponse
    {
        abort_if(
            $domain->user_id !== auth()->user()->id,
            Response::HTTP_UNAUTHORIZED,
        );

        $domain->delete();

        return redirect()->route('dashboard');
    }
}
