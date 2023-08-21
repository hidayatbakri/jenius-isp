<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="font-family: sans-serif;">
  <table style="max-width: 500px;margin: 0 auto;" border="0" cellpadding="5" cellspacing="0">
    <tr>
      <th style="font-size: 26px; color: rgb(5, 77, 141);">Verify Your Account</th>
    </tr>
    <tr>
      <td>
        <p style="font-weight: 600;">Halo {{ $data_email['username'] }}, <br>
          Kode Verifikasi akun anda adalah :</p>
      </td>
    </tr>
    <tr style="height: 150px;">
      <td style="text-align: center; font-size: 20px;">{{ $data_email['otp'] }}</td>
    </tr>
    <tr>
      <td>
        <p>Segera masukkan kode tersebut dan akan otomatis kadaluarsa dalam 1 menit jika tidak digunakan. Apabila kode
          ini tidak bekerja silahkan tekan tombol "kirim ulang".
          <br>
          Buka link berikut untuk verifikasi : <a href="{{ $data_email['link'] }}">{{ $data_email['link'] }}</a>
          <br> <br>
          Terima kasih, <br>
          <a href="#" style="text-decoration: none;">Smart Internet</a>
        </p>
      </td>
    </tr>
  </table>
</body>

</html>