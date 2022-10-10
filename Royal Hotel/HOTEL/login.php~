<?php

include("connection.php");

$uname=$_POST["uname"];
$pwd=$_POST["pwd"];


$resv= pg_query("select * from usr where userid='".$uname."' and password='".$pwd."'");


if(pg_num_rows($resv)<=0) 
{
	header("location:booking.php");
	exit();
}

else header("location:bookingmain.php");

	
?>
