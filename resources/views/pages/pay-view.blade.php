<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Flutterwave payment with laravel</title>
  </head>
  <body>
      
    <div class="container">
      <div class="header px-5 text-center bg-primary py-5 text-white mt-2">
        <h1>Pay for services</h1>
      </div>

      <div class="main">
        <form id="makePaymentForm">
          <div class="row mt-4">
            <div class="col-6">
               <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" placeholder="Enter Fullname" class="form-control" required="required">
              </div>
            </div>  
            <div class="col-6">
               <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter Email" class="form-control" required="required">
              </div>
            </div>

            <div class="col-6">
               <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" name="amount" id="amount" placeholder="Enter Amount" class="form-control" required="required">
              </div>
            </div>

            <div class="col-6">
               <div class="form-group">
                <label for="number">Phone Number</label>
                <input type="number" name="number" id="number" placeholder="Enter Phone Number" class="form-control" required="required">
              </div>
            </div>
          </div>

         <div class="form-group mt-2">
            <button type="submit" class="btn btn-primary">Pay Now</button>
         </div>
        </form>
      </div>
    </div>

    <!-- Jquery cdn added here! -->
    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>

    <!--Flutterwave cdn added here-->
    <script src="https://checkout.flutterwave.com/v3.js"></script>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>



<script>

  $(function () {
    $("#makePaymentForm").submit(function (e){
      e.preventDefault();
      var name = $("#name").val();
      var email = $("#email").val();
      var phone = $("#number").val();
      var amount = $("#amount").val();

      //Make Our payment
      makePayment(amount,email,phone,name);
    });
  });

  function makePayment(amount,email,phone_number,name) {
    FlutterwaveCheckout({
      public_key: "FLWPUBK_TEST-SANDBOXDEMOKEY-X",
      tx_ref: "RX1_{{substr(rand(0,time()),0,7)}}",
      amount,
      currency: "USD",
      country: "US",
      payment_options: " ",
      meta: {
        consumer_id: 23,
        consumer_mac: "92a3-912ba-1192a",
      },
      customer: {
        email,
        phone_number,
        name,
      },
      callback: function (data) {
        var transaction = data.transaction_id;
        console.log(transaction);
      },
      onclose: function() {
        // close modal
      },
      customizations: {
        title: "Ep-Studio",
        description: "Payment for items in cart",
        logo: "data:image/png;base64,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",
      },
    });
  }
</script>

  </body>
</html>