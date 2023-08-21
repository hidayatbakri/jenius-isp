<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sign up - Internet Service</title>
  <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/css/auth.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="/assets/js/jQuery.js"></script>
</head>

<body>
  <section class="register">
    <div class="row h-100 me-2 d-flex justify-content-center align-items-center">
      <div class="col-md-6 col-sm-12 bg-white p-4 rounded-2">
        <h1 class="fs-3">Sign-up</h1>
        <p class="text-secondary mb-4">Fill out the sign up form</p>
        <form action="/register" method="post">
          @csrf
          <div class="form-floating mb-3">
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Your Name" value="{{ @old('name') }}">
            <label for="name">Your Name</label>
            @error('name')
            <div id="validationServer04Feedback" class="invalid-feedback">
              {{$message}}
            </div>
            @enderror
          </div>
          <div class="form-floating mb-3">
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="name@example.com" value="{{ @old('email') }}">
            <label for="email">Email address</label>
            @error('email')
            <div id="validationServer04Feedback" class="invalid-feedback">
              {{$message}}
            </div>
            @enderror
          </div>
          <div class="form-floating">
            <input type="password" class="form-control @error('password') is-invalid @enderror" name=" password" id="password" placeholder="Password">
            <label for="password">Password</label>
            @error('password')
            <div id="validationServer04Feedback" class="invalid-feedback">
              {{$message}}
            </div>
            @enderror
          </div>
          <button type="submit" class="btn btn-primary btn-block w-100 mt-5 mb-3 py-3 fs-6 ">Sign-up</button>
          <p class="pt-4 text-center">Already have an account? <a href="/" class="text-decoration-none">Click here to sign in.</a></p>
        </form>

      </div>
    </div>
  </section>
  <script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>