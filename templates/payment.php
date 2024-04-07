<?php
include '../config/core.php';
include '../config/connection.php'; 
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300italic,300,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
    	<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>	
        <link href="https://fonts.googleapis.com/css2?family=Italianno&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://kit.fontawesome.com/44f557ccce.js"></script>
        <link rel="stylesheet" href="../public/css/payment.css">


        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <title>Online Flight Booking</title>
        <link rel = "icon" href ="../assets/images/brand.png"  type = "image/x-icon">       
    </head>

    <body>        
       


<main>

	<div class="container-fluid py-3">
    <div class="row">
        <div class="col-12 col-sm-8 col-md-6 col-lg-4 mx-auto">
          <h1 class="text-center text-light">PAY INVOICE</h1>
            <div id="pay-invoice" class="card">
                <div class="card-body">
            <label for="fname">Accepted Cards</label>
            <div class="icon-container">
              <i class="fa fa-cc-visa fa-3x" style="color:navy;"></i>
              <i class="fa fa-cc-amex fa-3x" style="color:blue;"></i>
              <i class="fa fa-cc-mastercard fa-3x" style="color:red;"></i>
              <i class="fa fa-cc-discover fa-3x" style="color:orange;"></i>
               <i class="fa fa-cc-stripe fa-3x" style="color:blue;"></i>
            </div>
            <hr><!-- log on to codeastro.com for more projects -->
            <form action="includes/payment.inc.php" method="post" 
                novalidate="novalidate" class="needs-validation">
  
                <div class="form-group">
                    <label for="cc-number" class="control-label mb-1">Card number</label>
                    <input id="cc-number" name="cc-number" type="tel" class="form-control cc-number identified visa" required autocomplete="off"  >
                    <span class="invalid-feedback">Enter a valid 12 to 16 digit card number</span>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="cc-exp" class="control-label mb-1">Expiration</label>
                            <input id="cc-exp" name="cc-exp" type="tel" class="form-control cc-exp" required placeholder="MM / YY" autocomplete="cc-exp">
                            <span class="invalid-feedback">Enter the expiration date</span>
                        </div>
                    </div>
                    <div class="col-6 p-0">
                        <label for="x_card_code" class="control-label mb-1">CVV</label>
                        <div class="row">
                            <div class="col pr-0">
                                <input id="x_card_code" name="x_card_code" type="password" class="form-control cc-cvc" required autocomplete="off">
                            </div><!-- log on to codeastro.com for more projects -->
                            <div class="col pr-0">                            
                                <span class="invalid-feedback order-last">Enter the 3-digit code on back</span>
                                <div class="input-group-append"><!-- log on to codeastro.com for more projects -->
                                    <div class="input-group-text">
                                    <span class="fa fa-question-circle fa-lg" data-toggle="popover" data-container="body" data-html="true" data-title="CVV" 
                                    data-content="<div class='text-center one-card'>The 3 digit code on back of the card..<div class='visa-mc-cvc-preview'></div></div>"
                                    data-trigger="hover"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <br/>

                <div class='form-row'><!-- log on to codeastro.com for more projects -->
                <div class='col-md-12 mb-2'>
                    <button id="payment-button" type="submit"  name="pay_but"
                    class="btn btn-lg btn-primary btn-block">
                        <i class="fa fa-lock fa-lg"></i>&nbsp;
                        <span id="payment-button-amount">Pay </span>
                        <span id="payment-button-sending" style="display:none;">Sending…</span>
                    </button>
                </div>
            </form>
                </div>
            </div>
        </div>
    </div>
</div>
</main>

<script>
$(document).ready(function(){
  $('.input-group input').focus(function(){
    me = $(this) ;
    $("label[for='"+me.attr('id')+"']").addClass("animate-label");
  }) ;
  $('.input-group input').blur(function(){
    me = $(this) ;
    if ( me.val() == ""){
      $("label[for='"+me.attr('id')+"']").removeClass("animate-label");
    }
  }) ;
});

$(function () {
  $('[data-toggle="popover"]').popover()
})



$("#payment-button").click(function(e) {
 
    var form = $(this).parents('form');
    
    var cvv = $('#x_card_code').val();
    var regCVV = /^[0-9]{3,4}$/;
    var CardNo = $('#cc-number').val();
    var regCardNo = /^[0-9]{12,16}$/;
    var date = $('#cc-exp').val().split('/');
    var regMonth = /^01|02|03|04|05|06|07|08|09|10|11|12$/;
    var regYear = /^20|21|22|23|24|25|26|27|28|29|30|31$/;
    
    if (form[0].checkValidity() === false) {
      e.preventDefault();
      e.stopPropagation();
    }
    else {
       if (!regCardNo.test(CardNo)) {
       
        $("#cc-number").addClass('required');
        $("#cc-number").focus();
        alert(" Enter a valid 10 to 16 card number");
        return false;
      }
      else if (!regCVV.test(cvv)) {
       
        $("#x_card_code").addClass('required');
        $("#x_card_code").focus();
        alert(" Enter a valid CVV");
        return false;
      }
      else if (!regMonth.test(date[0]) && !regMonth.test(date[1]) ) {
       
        $("#cc_exp").addClass('required');
        $("#cc_exp").focus();
        alert(" Enter a valid exp date");
        return false;
      }
      
      
      
      form.submit();
    }
    
    form.addClass('was-validated');
});
</script>
</main>
