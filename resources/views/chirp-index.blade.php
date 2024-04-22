<x-app-layout>

{{-- {% block body %} --}}
{{-- {% for msg in app.session.flashBag.get('delete') %} --}}
{{-- <script> --}}
{{--     toastr.info('{{ msg }}') --}}
{{-- </script> --}}
{{-- {% endfor %} --}}

<div class="content">
    <div class="chirper">

        <h2 class="titlebar">{{ \Illuminate\Support\Facades\Auth::user()->email }}</h2>

         <form id="formSubmitChirp" action="{{ route('chirps.store') }}" class="chirp-form" method="post">
             @csrf

             <label>
                 <textarea name="content" class="chirp-input"></textarea>
             </label>

             <input class="chirp-submit" id="btnSubmitChirp" value="Publish" type="submit">
         </form>

        {{-- <div id="myStats" class="user-details"> --}}
        {{--     {{ chirpsCount }} chirps | <a href="{{ path('following_list', {userId: user.id}) }}">{{ followingCount }} following</a> | <a href="{{ path('followers_list', {userId: user.id}) }}">{{ followersCount }} followers</a> --}}
        {{-- </div> --}}
    </div>
    <div id="myChirps" class="chirps">
        <h2 class="titlebar">My Chirps</h2>

        @forelse($chirps as $chirp)
            <article class="chirp">
                <div class="titlebar">
                    <a href="" class="chirp-author">{{ $chirp->author->email }}</a>
                    <span class="chirp-time">
                            <a href="">Likes: {{ $chirp->likes_counter }} |</a>
                            <a href="{{ route('chirps.like', ['chirp' => $chirp->id]) }}"><i class="fas fa-thumbs-up"></i></a> |
                            <a href="{{ route('chirps.edit', ['chirp' => $chirp->id]) }}"><i class="fas fa-edit"></i></a> |
                            <a href="{{ route('chirps.destroy', ['chirp' => $chirp->id]) }}" onclick="return confirm('Chirp will be deleted');"><i class="fas fa-trash"></i></a>

                            <span>{{ $chirp->date_added->diffForHumans() }}</span>
                        </span>
                </div>
                <p>
                    {{ $chirp->content }}
                </p>
            </article>
        @empty
            <div class="chirp">
                <span class="loading">No chirps in database</span>
            </div>
        @endforelse
    </div>
</div>
</x-app-layout>
