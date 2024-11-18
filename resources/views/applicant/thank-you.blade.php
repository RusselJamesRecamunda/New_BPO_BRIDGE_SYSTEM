<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Thank you page</title>
  <link rel="icon" href="{{ asset('asset/img/browser-icons/bpo_icon.png') }}">
  <link rel="stylesheet" href="{{ asset('asset/css/thank-you.css') }}">
</head>
<body>

<div class=content>
  <div class="wrapper-1">
    <div class="wrapper-2">
      <h1>Thank you !</h1>
      <h4>You've successfully sent your application</h4>
      <p>Congratulations, you have sent your application for this job</p>
       <br>
       <a class="go-home text-decoration-none" href="{{ route('home') }}">
        Go Home
      </a>

    </div>
    <div class="footer-like">
      <p>Email not received?
       <a href="#">Click here to send again</a>
      </p>
    </div>
</div>
</div>



<link href="https://fonts.googleapis.com/css?family=Kaushan+Script|Source+Sans+Pro" rel="stylesheet">
<!-- partial -->

</body>
</html>