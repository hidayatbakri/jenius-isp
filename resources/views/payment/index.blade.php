<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-qlnb_IrUYwqSwW0V"></script>
  <script src="/assets/js/jQuery.min.js"></script>
  <!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->
</head>
<p></p>

<body>
  <button id="pay-button">Pay!</button>

  <script type="text/javascript">
    // For example trigger on button clicked, or any time you need
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function() {
      // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
      window.snap.pay('{{$snapToken}}', {
        onSuccess: function(result) {
          /* You may add your own implementation here */
          alert("payment success!");
          console.log(result);
          sendData(result);
        },
        onPending: function(result) {
          /* You may add your own implementation here */
          alert("wating your payment!");
          console.log(result);
          sendData(result);
        },
        onError: function(result) {
          /* You may add your own implementation here */
          alert("payment failed!");
          console.log(result);
        },
        onClose: function() {
          /* You may add your own implementation here */
          alert('you closed the popup without finishing the payment');
        }
      })
      // customer will be redirected after completing payment pop-up
    });

    function sendData(result) {
      const myData = JSON.stringify(result);
      $.ajax('/payment/postData', {
        type: 'POST', // http method
        data: {
          "_token": "{{ csrf_token() }}",
          request: myData
        }, // data to submit
        success: function(data, status, xhr) {
          $('p').append('status: ' + status + ', data: ' + JSON.parse(data));
        },
        error: function(jqXhr, textStatus, errorMessage) {
          $('p').append('Error' + errorMessage);
        }
      });
    }
  </script>
</body>

</html>