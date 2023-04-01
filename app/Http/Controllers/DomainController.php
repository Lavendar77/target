<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDomainRequest;
use App\Http\Requests\UpdateDomainRequest;
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
        $domain = Domain::query()->create([
            'user_id' => $request->user()->id,
            'name' => $request->name,
            'base_url' => $request->base_url,
            'reference' => uniqid() . time(),
        ]);

        session()->flash('message', 'Domain created successfully.');

        return redirect()->route('dashboard', [
            'd' => $domain->id,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateDomainRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateDomainRequest $request, Domain $domain): RedirectResponse
    {
        abort_if(
            $domain->user_id !== auth()->user()->id,
            Response::HTTP_UNAUTHORIZED,
        );

        $domain->updateOrFail([
            'name' => $request->name,
            'base_url' => $request->base_url,
        ]);

        session()->flash('message', 'Domain updated successfully.');

        return redirect()->route('dashboard', [
            'd' => $domain->id,
        ]);
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

        $domain->deleteOrFail();

        session()->flash('message', 'Domain deleted successfully.');

        return redirect()->route('dashboard');
    }
}
