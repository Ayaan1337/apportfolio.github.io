<?php


include("connection.php");

$rs=0;
$av=0;
$count=0;

$inday=$_POST["inday"];
$inmth=$_POST["inmonth"];

$outday=$_POST["outday"];
$outmth=$_POST["outmonth"];


if($inday < 10)   $inday= "0".$inday;
if($inmth < 10)   $inmth= "0".$inmth;

if($outday < 10)   $outday= "0".$outday;
if($outmth < 10)   $outmth= "0".$outmth;

$indate =$inday.'/'.$inmth .'/'.$_POST["inyear"];
$outdate =$outday.'/'.$outmth .'/'.$_POST["outyear"];


echo "<table border=1 cellpadding=7 cellspacing=4 width=95%>";
echo "<tr> <th><font color=#5C3317>Room Type</font></th>  <th><font color=#5C3317>Total Rooms</font></th>  <th><font color=#5C3317>Reserved Rooms</font</th> <th><font color=#5C3317>Available Rooms</font></th> <th><font color=#5C3317>Charges/Day</font></th> </tr>";


$resv= pg_query("select r.res_id from reservation r, payment p where r.res_id=p.r_id");

while($res = pg_fetch_array($resv)) 
{
	pg_query("delete from reservation where res_id <> '".$res[0]."'");
}



$room=pg_query("select * from room");

while($rom=pg_fetch_array($room))
{

	$rs=0;
	$av=0;
	$type=$rom[0];

	$resv= pg_query("select * from reservation where type='".$type."'");

	while($res = pg_fetch_array($resv))
	{
			

			$inday=$_POST["inday"];
			$outday=$_POST["outday"];

			if($inday < 10)   $inday= "0".$inday;
			if($outday < 10)   $outday= "0".$outday;

			$oday=0;
			$iday=0;

			$idate= $res['chk_in'];
			$iday=$idate[0].$idate[1];
			$imnth=$idate[3].$idate[4];
			
			$odate=$res['chk_out'];
			$oday=$odate[0].$odate[1];
			$omnth=$odate[3].$odate[4];
			
			if($imnth < $omnth || $inmth < $omnth  ||  $outmth <$omnth)  
			{
				
				$oday = (intval($oday) + 31);

			}
			if($inmth < $outmth ||$imnth < $outmth || $omnth < $outmth) $outday=(intval($outday)+31);

			if( $outmth < $imnth  ||  $inmth < $imnth || $imnth < $omnth) $iday=(intval($iday)+31);

			if($imnth < $inmth || $omnth < $inmth || $outmth < $inmth)  $inday=(intval($inday)+31);
				
				
			if(($inday >= $iday  &&  $inday <= $oday) ||  ($outday >= $iday && $outday <= $oday))
			{
				$rs = $rs + $res['nor'];
			}
			else
			{
			if(($iday >= $inday  &&  $iday <= $outday) ||  ($oday >= $inday && $oday <= $outday))
			{
				$rs = $rs + $res['nor'];
			}}

		}
	
		$av= $rom['total_room']-$rs;
		if($av < 0)  
		{
			$av=0;
			$rs=$rom['total_room'];
		}


	echo "<tr align=center><td><font color=#5C3317> $rom[0] </font></td> <td><font color=#5C3317>$rom[1]</font></td> <td><font color=#5C3317> $rs </font></td> <td><font color=#5C3317>$av </font></td> <td><font color=#5C3317>$rom[4]</font></td> </tr>";
}


echo "</table>";


/*imnt<omnt      oday+31

inmnth<outmnt    outday+31

imnth<inmnth      inday+31


imnth<outmnth    outday+31

omnth<inmnth    inday+31

omnth<outmnth    outday+31*/
 ?>			
