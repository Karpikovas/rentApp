<?php

/*
  Generate cookie
*/
//$bytes = random_bytes(60);
//var_dump(bin2hex($bytes));
//

/*
  Generate hash
*/

$password = 'root';
$hash = password_hash($password, PASSWORD_BCRYPT );

$flag = password_verify($password, $hash);

var_dump($hash);




