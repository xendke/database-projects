<?php

$pwd = $_POST['pwd'];

if( strlen($pwd) < 8 ) {
	$error .= "Password too short! <br />";
}

if( strlen($pwd) > 20 ) {
	$error .= "Password too long! <br />";
}

if( strlen($pwd) < 8 ) {
	$error .= "Password too short! <br />";
}

if( !preg_match("#[0-9]+#", $pwd) ) {
	$error .= "Password must include at least one number! <br />";
}


if( !preg_match("#[a-z]+#", $pwd) ) {
	$error .= "Password must include at least one letter! <br />";
}


if( !preg_match("#[A-Z]+#", $pwd) ) {
	$error .= "Password must include at least one CAPS! <br />";
}



if( !preg_match("#\W+#", $pwd) ) {
	$error .= "Password must include at least one symbol! <br />";
}


if($error){
	echo "Password validation failure(your choise is weak): $error";
} else {
	echo "Your password is strong.";
}

?>