<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Mirasa Jaya - Login</title>

    {{-- <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <!-- Bootstrap core CSS -->
<link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>


    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
  </head>
  <body class="text-center">

<main class="form-signin">
  <form action="" method="POST">
    @csrf
    <img class="mb-4" src="/logo_perusahaan.png" alt="" width="120" height="60">
    <h1 class="h3 mb-3 fw-normal">Silahkan Masuk</h1>
    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $item)
               <li>{{ $item }}</li>
            @endforeach
        </div>
    @endif
    <div class="form-floating">
      <input type="text" name="username" class="form-control" id="floatingInput" value="{{ old('username') }}" placeholder="example">
      <label for="floatingInput">Username</label>
    </div>

    <div class="form-floating">
      <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>

    <button class="w-100 btn btn-lg btn-primary mt-2" type="submit">Masuk</button>
  </form>
</main>

  </body>
</html>
