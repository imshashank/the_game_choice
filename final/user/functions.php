<?php
require 'dbconfig.php';
function checkuser($fuid,$funame,$ffname,$femail){
    	$check = mysql_query("select * from Users where Fuid='$fbid'");
	$check = mysql_num_rows($check);
	if (empty($check)) { // if new user . Insert a new record		
	$query = "INSERT INTO Users (Fuid,Funame,Ffname,Femail) VALUES ('$fuid','$funame','$ffname','$femail')";
	echo $query;
	mysql_query($query);	
	} else {   // If Returned user . update the user record		
	$query = "UPDATE Users SET Funame='$funame', Ffname='$ffname', Femail='$femail' where Fuid='$fuid'";
	echo $query;
	mysql_query($query);
	}
}

function addKey($key,$freq,$user,$femail){
        $check = mysql_query("select * from Users where Fuid='$fbid'");
        $check = mysql_num_rows($check);
        if (empty($check)) { // if new user . Insert a new record
        $query = "INSERT INTO Users (Fuid,Funame,Ffname,Femail) VALUES ('$fuid','$funame','$ffname','$femail')";
        mysql_query($query);
        } else {   // If Returned user . update the user record
        $query = "UPDATE Users SET Funame='$funame', Ffname='$ffname', Femail='$femail' where Fuid='$fuid'";
        mysql_query($query);
        }

?>
