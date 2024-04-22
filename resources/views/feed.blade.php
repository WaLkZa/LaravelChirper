<x-app-layout>

<div class="content">
    <div id="chirps" class="chirps"><h2 class="titlebar">Chirps from all followed users</h2>
        @forelse($chirps as $chirp)
            <article class="chirp">
                <div class="titlebar">
                    <a href="{{ route('foreign_user', ['user' => $chirp->author->id]) }}" class="chirp-author">{{ $chirp->author->name }}</a>
                    <span class="chirp-time">
                        <a href="">Likes: {{ $chirp->likes_counter }} |</a>
                        <a href="{{ route('chirps.like', ['chirp' => $chirp->id]) }}"><i class="fas fa-thumbs-up"></i></a> |

                        @if(Auth::user()->isAdmin())
                        <a href="{{ route('chirps.edit', ['chirp' => $chirp->id]) }}"><i class="fas fa-edit"></i></a> |
                        <a href="{{ route('chirps.destroy', ['chirp' => $chirp->id]) }}" onclick="return confirm('Chirp will be deleted');"><i class="fas fa-trash"></i></a>
                        @endif

                        {{ $chirp->date_added->diffForHumans() }}
                    </span>
                </div>

                <p>{{ $chirp->content }}</p>
            </article>
        @empty
            <div class="chirp">
                <span class="loading">No chirps in feed. Try to follow user(s) with chirps.</span>
            </div>
        @endforelse
    </div>
</div>

</x-app-layout>
