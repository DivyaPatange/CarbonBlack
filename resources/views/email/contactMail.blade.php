<!DOCTYPE html>
<html>
<head>
    <title>Carbon Black Education</title>
</head>
<body>
    <p>Dear Admin,</p>
    <p>Enquiry of User is successfully done. User Details are listed below.</p>
    <table>
        <tr>
            <th>First Name</th>
            <td>{{ $first_name }}</td>
        </tr>
        <tr>
            <th>Last Name</th>
            <td>{{ $last_name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $email }}</td>
        </tr>
        <tr>
            <th>Phone No</th>
            <td>{{ $phone_no }}</td>
        </tr>
        <tr>
            <th>Country</th>
            <td>{{ $country }}</td>
        </tr>
        <tr>
            <th>Message</th>
            <td>{{ $message }}</td>
        </tr>
    </table>
    <p>Thank you</p>
</body>
</html>