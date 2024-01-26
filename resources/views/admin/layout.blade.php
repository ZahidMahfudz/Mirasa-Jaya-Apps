<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mirasa Jaya - Dashboard</title>
</head>
<body>
    <h1> Nama : {{ Auth::user()->name }}</h1>
    <h1> Role : {{ Auth::user()->role }}</h1>

    <a href="/logout" class="button btn-danger">Logout</a>
</body>
</html>
