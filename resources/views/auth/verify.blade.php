<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Verify - Internet Service</title>
  <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/css/auth.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="/assets/js/jQuery.min.js"></script>
</head>

<body>
  <section class="register">
    <div class="row h-100 me-2 d-flex justify-content-center align-items-center">
      <div class="col-md-6 col-sm-12 bg-white p-4 rounded-2">
        <h1 class="fs-3">Verify account</h1>
        <p class="text-secondary mb-4">Verify your account</p>
        <form action="/verify" method="post">
          @csrf
          <div class="form-floating mb-3">
            <input type="text" class="form-control text-center @error('otp') is-invalid @enderror" name="otp" id="otp" placeholder="Your otp" value="{{ @old('otp') }}">
            <label for="otp">Enter the otp code</label>
            @error('otp')
            <div id="validationServer04Feedback" class="invalid-feedback">
              {{$message}}
            </div>
            @enderror
          </div>
          <button type="submit" class="btn btn-primary btn-block w-100 mt-5 mb-3 py-3 fs-6 ">Activate</button>
        </form>
        <div class="resend"></div>
        <p class="text-center time">
          Resend the otp
          <span id="resend">0:00</span>
        </p>

      </div>
    </div>
  </section>
  <script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  @if(Cache::get('otp'))
  <script>
    setInterval(() => {
      // Mendapatkan waktu UTC saat ini
      var currentTime = new Date();

      // Mendapatkan komponen waktu UTC
      var year = currentTime.getUTCFullYear();
      var month = currentTime.getUTCMonth();
      var day = currentTime.getUTCDate();
      var hours = currentTime.getUTCHours();
      var minutes = currentTime.getUTCMinutes();
      var seconds = currentTime.getUTCSeconds();

      // Menyusun komponen waktu menjadi timestamp
      var time2 = Date.UTC(year, month, day, hours, minutes, seconds);

      // Menampilkan timestamp
      // console.log("UTC Timestamp: " + timestamp);

      time1 = new Date(`{{ Cache::get('fromtime') }}`);
      console.log("ok" + time1)
      // time2 = new Date().getTime();
      // console.log(time1 + ' - ' + time2WIB)
      let jarakMilidetik = Math.abs(time2 - time1);
      let jarakDetik = Math.floor(jarakMilidetik / 1000);

      if (parseInt(jarakDetik) <= 0) {
        $('.time').hide();
        $('.resend').html(`<form action="/verify/resend/{{ $data }}" method="post">
        @csrf
          <button type="submit" class="mb-3 btn btn-light btn-block py-2 w-100">Resend OTP</button>
          </form>`);
      } else {
        $('#resend').html('0:' + jarakDetik + 's');
      }
    }, 1000);
  </script>
  @else
  <script>
    $('.time').hide();
    $('.resend').html(`<form action="/verify/resend/{{ $data }}" method="post">
      @csrf
      <button type="submit" class="mb-3 btn btn-light btn-block py-2 w-100">Resend OTP</button>
    </form>`);
  </script>
  @endif

  @if(@session('error'))
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