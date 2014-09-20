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

function addKey($fb_id,$tag,$freq){
        $check = mysql_query("select * from tags where fb_id='$fb_id' LIMIT 1");
        
        while ($row = mysql_fetch_assoc($result)) {
        if ($row['1'] != $tag) { 
        $query = "INSERT INTO tags (fb_id,keyword,frequency) VALUES ('$fb_id','$tag','1')";
        mysql_query($query);
        } else {   // If Returned user . update the user record
        	$freq_new = $row['2'] +1;
        $query = "UPDATE tags SET  frequency='$freq_new' where fb_id='$fb_id'";
        mysql_query($query);
        }
    }
    }

?>
