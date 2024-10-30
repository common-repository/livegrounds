<?php
header("Content-type:text/html; charset=utf-8");
/*
 | Filnamn: lg_getinfo.php
 | Beskrivning:
 | returnerar json-data som beskriver en användare på scenen. 
 | Beroende på parametrar så returneras kort information utan 
 | "fritext" (name,birthdate,gender,location,status,marked_users,
 | blocked_users) eller lång information med "fritext"(name,
 | birthdate,gender,location,status,marked_users,blocked_users,info)
 |
 | Input:
 | 'uid' är användare att hämta info om.
 | 'fmt' = ["short" | "long"] är format  på information, kort eller långt (se beskrivning)
 |
 | Output: JSON-sträng
jaan: jsonp
jaan: logging
 */
session_start();
require("./../../../wp-blog-header.php");
require_once('lib.php');
global $wpdb;
global $lg_table;
logg0(getSessionGetPostDump());
/* Om parametrar saknas eller om anropet kommer ifrån någon som inte är registrerad så avbryter vi. */
if(!isset($_GET["uid"]) || !isset($_GET["fmt"]) || 
	!isset($_SESSION["uid"])){
  logg0("missing data");
	exit;
}

$user = $wpdb->escape($_GET["uid"]);

if($_GET["fmt"]=="short"){
  logg0("short data");
  $sqlStr = "SELECT name, birthdate, gender, location, status, marked_users, " .
    "blocked_users FROM $lg_table WHERE uid = \"$user\"";
    
    logg0($sqlStr);
	$info = $wpdb->get_row(
		$sqlStr
	);

	if($wpdb->num_rows == 0){
	  logg0("no info on this guy");
		exit;
	} else {
		echo($_GET["jsoncallback"] . "({name:\"$info->name\",birthdate:\"$info->birthdate\"," .
		"gender:\"$info->gender\",location:\"$info->location\"," .
		"status:\"$info->status\",marked_users:\"$info->marked_users\"," .
		"blocked_users:\"$info->blocked_users\"})");
	}
} else if($_GET["fmt"]=="long"){
	$info = $wpdb->get_row(
		"SELECT name, birthdate, gender, location, status, marked_users, " .
		"blocked_users, info FROM $lg_table WHERE uid = \"$user\""
	);

	if($wpdb->num_rows == 0){
		exit;
	} else {
		echo($_GET["jsoncallback"] . "({name:\"$info->name\",birthdate:\"$info->birthdate\"," .
		"gender:\"$info->gender\",location:\"$info->location\"," .
		"status:\"$info->status\",marked_users:\"$info->marked_users\"," .
		"blocked_users:\"$info->blocked_users\",info:\"$info->info\"})");
	}
}

function logg0($msg) {
  
 logg("[lg_getinfo.php] " . $msg);
}


?>
