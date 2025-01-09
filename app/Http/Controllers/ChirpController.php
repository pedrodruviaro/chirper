<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChirpRequest;
use App\Models\Chirp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $chirps = Chirp::with('user')->latest()->paginate(10);

        return view('chirps.index', ['chirps' => $chirps]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChirpRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        /*
        Chirp::create(
            [
                'message' => $validated['message'],
                'user_id' => Auth::id(),
            ]
        );
        */

        /*
        $chirp = new Chirp();
        $chirp->message = '';
        $chirp->save()
        */

        $request->user()->chirps()->create($validated);

        return redirect(route('chirps.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp): View
    {
        Gate::authorize('update', $chirp);

        return view('chirps.edit', ['chirp' => $chirp]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreChirpRequest $request, Chirp $chirp): RedirectResponse
    {
        Gate::authorize('update', $chirp);

        $validated = $request->validated();

        $chirp->update($validated);

        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        Gate::authorize('delete', $chirp);

        $chirp->delete();

        return redirect(route('chirps.index'));
    }
}
