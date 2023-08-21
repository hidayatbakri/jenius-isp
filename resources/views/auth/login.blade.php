<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sign in - Internet Service</title>
  <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/css/auth.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="/assets/js/jQuery.min.js"></script>
</head>

<body>
  <section class="login">
    <div class="row h-100 me-2 p-0">
      <div class="col-md-5 col-lg-4 col-sm-12 left d-flex align-items-center justify-content-center">
        <div class="w-100 p-5">
          <h2 class="fw-medium text-start">Welcome back 👋</h2>
          <p class=" mb-5">Sign-in to get access</p>
          <form action="/login" method="post">
            @csrf
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
            <button type="submit" class="btn btn-primary btn-block w-100 mt-5 mb-3 py-3 fs-6 ">Login</button>
          </form>
          <!-- <div class="mt-4 d-flex justify-content-around align-items-center">
            <div class="line"></div>
            <h6 class="pt-2 text-secondary fs-6">or</h6>
            <div class="line"></div>
          </div> -->
          <!-- <button type="button" class="btn btn-outline-secondary py-3 mt-4 bt-block w-100"><img src="/assets/img/google-logo.png" class="icon-btn me-3"> Google</button> -->
          <p class="pt-4 text-center">You don't have an account? <a href="/register" class="text-decoration-none">Click here to sign up.</a></p>
        </div>
      </div>
      <div class="col-md-7 col-lg-8 col-sm-12 right">
        <h1></h1>
      </div>
    </div>
  </section>
  <script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script>
    setInterval(() => {
      if ($(window).width() <= 768) {
        $(".right").hide(500);
        $(".right").removeClass("col-md-7 col-lg-8 col-sm-12");
      } else {
        $(".right").show(500);
        $(".right").addClass("col-md-7 col-lg-8 col-sm-12");
      }
    }, 500);
  </script>

  @if (@session('success'))
  <script>
    Swal.fire(
      'Good job!',
      `{{ @session('success') }}`,
      'success'
    )
  </script>
  @endif
  @if (@session('error'))
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: `{{ @session('error') }}`,
    })
  </script>
  @endif
</body>

</html>