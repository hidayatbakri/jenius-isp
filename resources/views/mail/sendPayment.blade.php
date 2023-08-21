<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="font-family: sans-serif;">
  <table style="max-width: 500px;margin: 0 auto;" border="0" cellpadding="5" cellspacing="0">
    <tr>
      <th colspan="3" style="font-size: 26px; color: rgb(5, 77, 141);">Pembayaran Langganan</th>
    </tr>
    <tr>
      <td colspan="3">
        <p style="font-weight: 600;">Halo {{ $data_email['name'] }}, <br>
          Silahkan selesaikan pembayaran anda</p>
      </td>
    </tr>
    <tr style="height: 150px;">
      <td colspan="3" style="text-align: center;"><a style="text-decoration: none; color: white; background-color: #003566; padding: 15px 8px" href="{{ $data_email['linkPayment'] }}">Bayar Sekarang</a></td>
    </tr>
    <tr>
      <td colspan="3" style="text-align: center; font-size: 18px;">
        <p>Detail Pembayaran</p>
      </td>
    </tr>
    <tr>
      <td>Nama</td>
      <td>: </td>
      <td>{{ $data_email['name'] }}</td>
    </tr>
    <tr>
      <td>Paket</td>
      <td>: </td>
      <td>{{ $data_email['paket'] }}mbps</td>
    </tr>
    <tr>
      <td>Harga</td>
      <td>: </td>
      <td>Rp. {{ number_format($data_email['price'],0,".",".") }}</td>
    </tr>
    <tr>
      <td>Biaya Admin</td>
      <td>: </td>
      <td>Rp. {{ number_format($data_email['biayaAdmin'],0,".",".") }}</td>
    </tr>
    <tr>
      <td>Alamat Pembayaran</td>
      <td>: </td>
      <td>{{ $data_email['linkPayment'] }}</td>
    </tr>
    <tr>
      <td>
        <p>
          <a href="#" style="text-decoration: none;">Smart Internet</a>
        </p>
      </td>
    </tr>
  </table>
</body>

</html>