<!DOCTYPE html>
<html>
<head>
	<title>Contact Page</title>
</head>
<body>	
	<h1>Contact us any time</h1>
	<form action="{{route('contact')}}" method="post">
		@csrf
		<input type="text" name="name" placeholder="your name">
		<input type="email" name="email" placeholder="your email value">
		<textarea name="message" cols='43' rows="15">
			
		</textarea>
		<input type="submit" name="submit">
	</form>
</body>
</html>