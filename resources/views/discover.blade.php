<x-app-layout>

<div class="content">
    <div class="chirps">

        {{-- {% set route = app.request.attributes.get('_route') %} --}}
        {{-- {% if route == 'user_discover' %} --}}
        {{-- <h2 class="titlebar">Discover all users</h2> --}}
        {{-- {% elseif route == 'followers_list' %} --}}
        {{-- <h2 class="titlebar">{{ currentUser.username }}'s followers:</h2> --}}
        {{-- {% elseif route == 'following_list' %} --}}
        {{-- <h2 class="titlebar">{{ currentUser.username }} follows:</h2> --}}
        {{-- {% endif %} --}}

        <div id="userlist">
            @forelse($users as $user)
            <div class="userbox">
                <div><a href="{{ route('foreign_user', ['user' => $user->id]) }}" class="chirp-author">{{ $user->name }}</a></div>

                <div class="user-details">
                    {{ $user->chirps->count() }} chirps | <a href="">{{ $user->following_counter }} following</a> | <a href="">{{ $user->followers_counter }} followers</a>
                </div>
            </div>
            @empty
            <div class="chirp">
                <span class="loading">No users</span>
            </div>
            @endforelse
        </div>
    </div>
</div>

</x-app-layout>