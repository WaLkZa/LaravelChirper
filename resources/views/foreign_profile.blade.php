@php use Illuminate\Support\Facades\Auth; @endphp

<x-app-layout>

    <div class="content">
        <div class="chirper">
            <h2 class="titlebar">{{ $user->name }}</h2>

            <a id="btnFollow" class="chirp-author" href="{{ route('user_follow', ['user' => $user->id]) }}">
                {{ Auth::user()->following->contains($user->id) ? 'Unfollow' : 'Follow' }}
            </a>

            <div id="userProfileStats" class="user-details">
                {{ $user->chirps->count() }} chirps | <a href="">{{ $user->following_counter }} following</a> | <a href="">{{ $user->followers_counter }} followers</a>
            </div>
        </div>

        <div id="profileChirps" class="chirps">
            <h2 class="titlebar">{{ $user->name }}'s Chirps</h2>

            @forelse($user->chirps as $chirp)
                <article class="chirp">
                    <div class="titlebar">
                        <a href="{{ route('foreign_user', ['user' => $user->id]) }}" class="chirp-author">{{ $user->name }}</a>

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
                    <span class="loading">The user does not have any chirps!</span>
                </div>
            @endforelse
        </div>
    </div>

</x-app-layout>
