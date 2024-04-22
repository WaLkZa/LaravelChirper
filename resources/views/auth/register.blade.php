<x-app-layout>

    <form name="register" action="{{ route('register') }}" class="form chirps" id="formRegister" method="post">
        @csrf

        <label>Name</label>
        <input name="name" type="text">

        <label>Email</label>
        <input name="email" type="email">

        <label>Password</label>
        <input name="password" type="password">

        <label>Repeat Password</label>
        <input name="password_confirmation" type="password">

        <input id="btnRegister" value="Register" type="submit">

        <a href="{{ route('login') }}">Log in</a>
    </form>

</x-app-layout>
