<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <div>
        <p>Dear {{ $user->name }},</p>
        <p> Your registration for on-line courses is
now complete.</p>
        <p>You will receive an additional email
when your account is activated.</p>
<p>After the account is activated, you will
be able to select modules and pay for
your course fees, if any.</p>
        
        <p>Thanking You!!</p>
    </div>
</body>
</html>