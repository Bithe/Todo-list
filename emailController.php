<?php

require_once 'vendor/autoload.php';
require_once 'db.php';
/*require_once '../login/vendor/swiftmailer/swiftmailer/lib/swift_required.php';*/

// for email verification email send

	function sendVerificationEmail($userEmail, $token)
	{
		
		$body = '<!DOCTYPE html>
			<html>
			<head>
				<title>Verify Email</title>
			</head>
			<body>

				<div class="wrapper">
					<p>
						Thank you for your signing up on our website. Please click on the link below to verify your email.
						ek utha latthi sob marte mon cay majeh majeh.

					</p>
					<a href="http://localhost/project/todo_index.php?token='. $token .'"><b>Verify your email address</b></a>		
				</div>

			</body>
			</html> ';

				// Create the Transport
				$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
				  ->setUsername('farzana.hossain5@gmail.com')
				  ->setPassword('01711370571a')
				;

				// Create the Mailer using your created Transport
				$mailer = new Swift_Mailer($transport);

				// Create a message
				$message = (new Swift_Message('Verify your email address'))
				  ->setFrom(['farzana.hossain5@gmail.com' => 'Fatema Tuz Zohra(Bithe)'])
				  ->setTo([$userEmail => 'bijoy goru'])
				  ->setBody($body, 'text/html')
				  ;

				// Send the message
				$result = $mailer->send($message);


return "Ok";

}

//For reset password


	function sendPasswordResetLink($userEmail, $token){
		$body = '<!DOCTYPE html>
			<html>
			<head>
				<title>Verify Email</title>
			</head>
			<body>

				<div class="wrapper">
					<p>
						Hello there, 

						Please click on the link to reset your password.

					</p>
					<a href="http://localhost/project/todo_index.php?password-token='. $token .'"><b>Reset your pasword </b></a>		
				</div>

			</body>
			</html> ';

				// Create the Transport
				$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
				  ->setUsername('farzana.hossain5@gmail.com')
				  ->setPassword('01711370571a')
				;

				// Create the Mailer using your created Transport
				$mailer = new Swift_Mailer($transport);

				// Create a message
				$message = (new Swift_Message('Reset your Password'))
				  ->setFrom(['farzana.hossain5@gmail.com' => 'Fatema Tuz Zohra(Bithe)'])
				  ->setTo([$userEmail => 'A name'])
				  ->setBody($body, 'text/html')
				  ;

				// Send the message
				$result = $mailer->send($message);


return "Ok";

	}





?>