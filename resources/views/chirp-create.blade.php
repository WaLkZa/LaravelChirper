<x-app-layout>

    <div class="content">
        <div class="chirper">
            <h2 class="titlebar">{{ \Illuminate\Support\Facades\Auth::id() }}</h2>

            <form id="formSubmitChirp" action="{{ route('chirps.store') }}" class="chirp-form" method="post">
                <textarea name="chirp[content]" class="chirp-input"></textarea>
                <input class="chirp-submit" id="btnSubmitChirp" value="Edit" type="submit">
            </form>
        </div>
    </div>
</x-app-layout>
