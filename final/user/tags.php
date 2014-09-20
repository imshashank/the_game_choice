<?php
require 'dbconfig.php';

session_start(); 
$data = unserialize($_POST['data'];
$fb_id = $_SESSION['FBID'];


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
?>