<?php
header("Content-type:text/html; charset=utf-8");
/* 
 | Filnamn: forgotpassword.php
 | Beskrivning: Skickar lösenordet till en användare givet
 | en korrekt email-adress.
 |
 | Input:
 | 'email' = email-adress till användare som glömt sitt lösen.
 |
 | Output: Informations-sträng.
 */
session_start();
include('settings.php');
//echo("inside forgot");
// Kontrollera så att användaren har ett lgid och email finns, annars avbryt.
if((!isset($_SESSION["uid"])) || (!isset($_GET["email"]))){
  echo($_GET["jsoncallback"] . "({resp:\"Not logged in.\", err_code:\"1\"})");


  //	echo("No session or no email!");
	exit;
}

$db_conn = mysql_connect($db_host, $db_user, $db_pass) or
	die('Error connecting to mysql server!');
mysql_select_db($db_name);
$email = mysql_real_escape_string($_GET["email"]);

// Kontrollera att kontot finns i lg_users
if(mysql_num_rows(mysql_query("SELECT uid FROM $lg_user_table " .
	"WHERE uid = \"$email\""))==0) {
  echo($_GET["jsoncallback"] . "({resp:\"Email does not exist.\", err_code:\"2\"})");
  //echo("Email doesn't exist.");
	exit;
}

/* Generera engångsnyckel och försök skicka email. Om det lyckas,
   så lägger vi in engångsnyckeln i tabellen. */
$key = md5(uniqid(rand()));
$subject = "Livegrounds password";
$body = "Hello!,\n" .
		"If you have lost your Livegrounds password you can use the link below to change\n" .
		"it to a new one. If you already know your password and have no clue why you\n" .
		"receive this email, you can just ignore it.\n\nThe link will expire after 60 minutes.\n\n" .
		$lg_server . "/setpassword.php?key=" . $key . "&uid=" . $email . "\n\n" .
		"/Livegrounds team";
		
if(mail($email, $subject, $body)) {
	mysql_query("INSERT INTO $lg_onetimekeys_table" .
	" (uid, passkey) VALUES(\"$email\", \"$key\")");
	
	echo($_GET["jsoncallback"] . "({resp:\"The password has been sent to your email. Bear in mind that it can get stuck in your spam filter.\", err_code:\"0\"})");

	//echo("Mail successfully sent!");
 } else {
  echo($_GET["jsoncallback"] . "({resp:\"Mail delivery failed.\", err_code:\"3\"})");


  //	echo("Mail delivery failed...");
}

mysql_close($db_conn);
?>