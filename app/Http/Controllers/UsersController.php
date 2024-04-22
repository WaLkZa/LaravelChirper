<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UsersController extends Controller
{
    public function index(): View
    {
        return view('discover', [
            'users' => User::all()->filter(fn (User $user) => $user->id !== Auth::id())
        ]);
    }

    public function foreign(User $user): View
    {
        return view('foreign_profile', ['user' => $user]);
    }

    public function follow(User $user)
    {
        if (Auth::user()->following->contains($user->id)) {
            Auth::user()->following()->detach($user);

            $user->decrement('followers_counter');
            Auth::user()->decrement('following_counter');
        } else {
            Auth::user()->following()->attach($user);

            $user->increment('followers_counter');
            Auth::user()->increment('following_counter');
        }

        return back();
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

        return redirect(route('chirps.index'));
    }

    public function show(Chirp $chirp)
    {
        //
    }

    public function edit(Chirp $chirp)
    {
        return view('chirp-edit', ['chirp' => $chirp]);
    }

    public function update(Request $request, Chirp $chirp)
    {
        $validated = $request->validate(['content' => 'required|string|max:255']);

        $chirp->update($validated);

        return redirect(route('chirps.index'));
        // return redirect(route('chirps.edit', ['chirp' => $chirp->id]));
    }

    public function destroy(Chirp $chirp)
    {
        $chirp->delete();

        return redirect(route('chirps.index'));
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

        return redirect(route('chirps.index'));
    }
}
