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
        <p>Dear Admin,</p>
        <p>{{ $user->name }} user is registered successfully.</p>
        <table class="table">
        	<tr>
        		<th>Email</th>
        		<td>{{ $user->email }}</td>
        	</tr>
        	<tr>
        		<th>Phone</th>
        		<td>{{ $user->phone }}</td>
        	</tr>
        	<tr>
        		<th>Designation</th>
        		<td>{{ $user->designation }}</td>
        	</tr>
        	<tr>
        		<th>Department</th>
        		<td>{{ $user->department }}</td>
        	</tr>
        	<tr>
        		<th>City</th>
        		<td>{{ $user->city }}</td>
        	</tr>
        	<tr>
        		<th>State</th>
        		<td>{{ $user->state }}</td>
        	</tr>
        	<tr>
        		<th>Country</th>
        		<td>{{ $user->country }}</td>
        	</tr>
        	<tr>
        	    <a href="{{route('activate', ['id'=>$user->id])}}">Activate</a>
        	</tr>
        </table>
        <p>Thanking You!!</p>
    </div>
</body>
</html>