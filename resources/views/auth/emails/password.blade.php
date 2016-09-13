<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Pixbo::PasswordReset</title>
	</head>
	<body>
		Click here to reset your password:<br>
		<br>
		<a href="{{ $link = url('/').'#!/auth/forgot/'.$token.'/'.$user->getEmailForPasswordReset() }}"> {{ $link }} </a>
	</body>
</html>