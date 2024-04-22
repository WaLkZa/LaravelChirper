<x-app-layout>

<form name="authenticate" action="{{ route('login') }}" id="formLogin" class="form chirps" method="post">
    @csrf

    {{-- $errors->get('email') --}}
    <label>Email</label>
    <input name="email" type="text">
    <label>Password</label>
    <input name="password" type="password">

    <input id="btnLogin" value="Sign In" type="submit">

    <a href="{{ route('register') }}">Register</a>
</form>

</x-app-layout>