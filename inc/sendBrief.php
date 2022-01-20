<?php

// Replace this with your own email address
$siteOwnersEmail = 'info@miralmedia.it';


if($_POST) {

    $name = trim(stripslashes($_POST['name']));
    $surname = trim(stripslashes($_POST['surname']));
    $email = trim(stripslashes($_POST['email']));
    $phone = trim(stripslashes($_POST['phone']));
    $rag_soc = trim(stripslashes($_POST['rag_soc']));

    // Check Name
    if (strlen($name) < 2) {
        $error['name'] = "Inserisci il tuo nome.";
    }
    if (strlen($surname) < 2) {
        $error['surname'] = "Inserisci il tuo cognome.";
    }
    // Check Email
    if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
        $error['email'] = "inserisci un indirizzo email valido.";
    }
    // Check Message
    if (strlen($rag_soc) < 5) {
        $error['message'] = "Per favore inserisci la tua ragione sociale completa.";
    }
    // Subject
    $subject = "Contact Form Submission"; 


    // Set Message
    $message .= "Email from: " . $name . ' ' . $surname . "<br />";
    $message .= "Email address: " . $email . "<br />";
    $message .= "Ragione Sociale: <br />";
    $message .= $rag_soc;
    $message .= "<br /> ----- <br /> This email was sent from your site's contact form. <br />";

    // Set From: header
    $from =  $name . " <" . $email . ">";

    // Email Headers
    $headers = "From: " . $from . "\r\n";
    $headers .= "Reply-To: ". $email . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


   if (!$error) {

      ini_set("sendmail_from", $siteOwnersEmail); // for windows server
      $mail = mail($siteOwnersEmail, $subject, $message, $headers);

		if ($mail) { echo "OK"; }
      else { echo "Qualcosa è andato storto. Per favore riprova più tardi."; }
		
	} # end if - no validation error

	else {

		$response = (isset($error['name'])) ? $error['name'] . "<br /> \n" : null;
		$response .= (isset($error['email'])) ? $error['email'] . "<br /> \n" : null;
		$response .= (isset($error['message'])) ? $error['message'] . "<br />" : null;
		
		echo $response;

	} # end if - there was a validation error

}

?>