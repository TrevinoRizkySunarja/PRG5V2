@props(['title' => 'My Application'])

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css'])
    <title>{{ $title }}</title>
</head>
<body>

</body>
</html>
<nav>
    @if(auth()->check())
        <a href="/dashboard">Dashboard</a>
        <a href="/profile">{{ auth()->user()->name }}</a>
        <a href="/logout">Logout</a>
    @else
        <a href="/login">Login</a>
        <a href="/register">Register</a>
    @endif
</nav>

