<x-app-layout>

<div class="content">
    <div class="chirper">
        <h2 class="titlebar">{{ \Illuminate\Support\Facades\Auth::user()->name }}</h2>

        <form id="formSubmitChirp" action="{{ route('chirps.update', ['chirp' => $chirp->id]) }}" class="chirp-form" method="post"
              onsubmit="return confirm('Will be edited');">
            @csrf

            <label>
                <textarea name="content" class="chirp-input">{{ $chirp->content }}</textarea>
            </label>
            <input class="chirp-submit" id="btnSubmitChirp" value="Edit" type="submit">
        </form>
    </div>
</div>
</x-app-layout>
