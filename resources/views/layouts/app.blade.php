<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

        header, footer {
            text-align: center;
            background: #cfcfcf;
            height: 40px;
            vertical-align: middle;
        }

        header > *, footer > * {
            vertical-align: middle;
            line-height: 40px;
        }

        #main > div {
            margin: auto;
            padding: 20px;
            max-width: 800px;
        }

        .menu {
            background: #4d4d4d;
        }

        .menu > a {
            color: #e0e0e0;
            text-decoration: none;

            padding: 5px 10px;
        }

        .menu > span {
            color: #e0e0e0;
        }

        .menu a:nth-of-type(3),
        a:nth-of-type(4),
        .menu span {
            padding: 1px 10px;
            float: right;
        }

        .menu > a:hover {
            background: #7f7f7f;
        }

        .nav-active {
            color: rgb(76, 151, 170) !important;
        }

        .loading {
            padding: 10px;
        }

        .chirps {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
        }

        .chirp {
            position: relative;
            border-top: 1px solid #e0e0e0;
        }

        .titlebar {
            overflow: auto;
            padding: 10px;
        }

        .chirp-author {
            font-weight: bold;
        }

        .chirp-time {
            float: right;
        }

        .chirp-time > a, .user-details > a {
            text-decoration: none;
        }

        .chirp > p {
            padding: 10px;
            word-break: break-all;
        }

        .userbox {
            border-top: 1px solid #e0e0e0;
            padding: 10px;
            overflow: auto;
            position: relative;
        }


        .user-details {
            vertical-align: bottom;
            display: inline-block;
            position: absolute;
            right: 10px;
            bottom: 10px;
            color: #7f7f7f;
        }

        .chirper {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            margin-bottom: 10px;
            overflow: auto;
            vertical-align: bottom;
            position: relative;
        }

        #formSubmitChirp {
            text-align: right;
            margin: 10px;
            display: inline-block;
            width: 300px;
        }

        .chirp-input {
            resize: none;
            width: 300px;
            height: 5em;
            display: block;
        }

        #btnSubmitChirp {
            width: 75px;
            height: 25px;
            background: #6592bf;
            color: #ffffff;
            border: none;
            display: inline-block;
            margin-top: 5px;
        }

        #btnSubmitChirp:hover {
            background: #83bef7;
            cursor: pointer;
        }

        .chirp-author {
            color: #6592bf;
            text-decoration: none;
        }

        .chirp-author:hover {
            color: #83bef7;
        }

        .chirp-time {
            color: #7f7f7f;
        }

        #btnFollow {
            margin: 2px;
            padding: 5px;
            background: #6592bf;
            color: #ffffff;
            display: inline-block;
        }

        #btnFollow:hover {
            background: #83bef7;
        }

        #btnUnfollow {
            margin: 10px;
            padding: 5px 10px;
            background: #6592bf;
            color: #ffffff;
            display: inline-block;
        }

        #btnUnfollow:hover {
            background: #f79c97;
        }

        .form {
            margin: 20px auto;
            padding: 20px;
            text-align: center;
            max-width: 200px;
        }

        .form > * {
            display: block;
            margin: auto;
            margin-bottom: 5px;
        }

        .form > input[type="submit"] {
            border: 0;
            margin: auto;
            margin-bottom: 5px;
            padding: 5px 10px;
            background: #6592bf;
            color: #ffffff;
        }

        .form > input[type="submit"]:hover {
            background: #83bef7;
            cursor: pointer;
        }

        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            border-radius: 10px;
            width: 30%;
        }
    </style>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
          integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
</head>
<body>
<div id="main">
    <header><span>Chirper</span></header>

    @auth
        <div class="menu">
            <a href="{{ route('feed') }}">Home</a>
            <a href="{{ route('discover') }}">Discover</a>
            <a href="{{ route('logout') }}">Logout</a>
            <a href="{{ route('chirps.index') }}">Me</a>
            {{-- <a href="{{ route('user_profile') }}" class="{{ route == 'user_profile' ? 'nav-active' }}">Me</a> --}}
            @if(Auth::user()->isAdmin())
                <span>Welcome ADMIN {{ \Illuminate\Support\Facades\Auth::user()->name }}</span>
            @else
                <span>Welcome {{ \Illuminate\Support\Facades\Auth::user()->name }}</span>
            @endif
        </div>
    @endauth

    @if(session()->get('error'))
        <div style="color: red">
            {{ session()->get('error') }}
        </div><br />
    @endif

    @if ($errors->any())
        <div style="color: red">
{{--            @dd($errors->all())--}}
            {{join(', ', $errors->all())}}
        </div>
    @endif

    {{ $slot }}

    <footer><p>Chirper © 2024</p></footer>
</div>
</body>
</html>
