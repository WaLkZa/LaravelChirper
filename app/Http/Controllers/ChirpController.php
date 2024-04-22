<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ChirpController extends Controller
{
    public function index(): View
    {
        return view('chirp-index', [
            'chirps' => auth()->user()->chirps()->orderBy('date_added', 'desc')->get()
        ]);
    }

    public function create()
    {
        return view('chirp-create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $request->user()->chirps()->create($validated);

        return back();
    }

    public function show(Chirp $chirp)
    {
        //
    }

    public function edit(Chirp $chirp)
    {
//        dd($chirp->user_id, Auth::id());
        if ($chirp->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            return back()->with('error', 'You are not admin!');
        }

        return view('chirp-edit', ['chirp' => $chirp]);
    }

    public function update(Request $request, Chirp $chirp)
    {
        if ($chirp->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            return back()->with('error', 'You are not admin!');
        }

        $validated = $request->validate(['content' => 'required|string|max:255']);

        $chirp->update($validated);

        return back();
    }

    public function destroy(Chirp $chirp)
    {
        if ($chirp->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            return back()->with('error', 'You are not admin!');
        }

        $chirp->delete();

        return back();
    }

    public function like(Chirp $chirp)
    {
        if (Auth::user()->chirpLikes->contains($chirp)) {
            Auth::user()->chirpLikes()->detach($chirp);

            $chirp->decrement('likes_counter');
        } else {
            Auth::user()->chirpLikes()->attach($chirp->id);

            $chirp->increment('likes_counter');
        }

        return back();
    }

    public function feed()
    {
        $followingIds = Auth::user()->following->pluck('id'); // https://www.php.net/manual/en/function.array-column.php

        $chirps = Chirp::all()
            ->filter(fn(Chirp $chirp) => $followingIds->contains($chirp->user_id))
            ->sortByDesc('date_added');

        return view('feed', ['chirps' => $chirps]);
    }
}
