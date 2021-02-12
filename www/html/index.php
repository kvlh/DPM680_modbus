<!DOCTYPE html>

<html>
<meta charset="utf-8">
<head>
<style>
.button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}
.back {
  background-color: #008CBA;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}
.b2 {
  background-color: #e7e7e7;
  border: none;
  color: black;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}

#list {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
    text-align center;
}

#list td, #list th {
    border: 1px solid #ddd;
    padding: 10px;
    font-size: 20px;
    text-align center;
}
#list {
    border-collapse: collapse;
    width: 70%;
    text-algin: center;
}

#list td{
text-algin: center;
}
#list th {
    padding-top: 5px;
    padding-bottom: 5px;
    text-align: center;
    padding: 10px;
    font-size: 20px;
    background-color: #4CAF50;
    color: white;
}
input[type=submit] {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 16px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
}

input[type=button] {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 16px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
}
</style>
</head>

<body>

<?php
$data1= ($_POST['d1']) . " " . ($_POST['t1']);
$data2=($_POST['d2']) . " " . ($_POST['t2']);  
$con=mysqli_connect("localhost","modbus","modbus2018","modbus");
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
function getProperColor($number)
{
    if ($number==1)
        return '#FF0000';
    else if($number==0)
        return  '#00FF00';
}
function getval($text)
{
    if ($text==1)
        echo "ON";
    else if($text==0)
        echo  "OFF";
}

//m1  read
$startdate1 = mysqli_query($con,"select var from m1 where ts >= '$data1' and ts <= '$data2' order by id asc limit 1");
$enddate1 = mysqli_query($con,"select var from m1 where ts >= '$data1' and ts <= '$data2' order by id desc limit 1");
$startDate1 = mysqli_fetch_array($startdate1);
$endDate1 = mysqli_fetch_array($enddate1);
$wynik1= $endDate1['var'] - $startDate1['var'];

//m2 read
$startdate2 = mysqli_query($con,"select var from m2 where ts >= '$data1' and ts <= '$data2' order by id asc limit 1");
$enddate2 = mysqli_query($con,"select var from m2 where ts >= '$data1' and ts <= '$data2' order by id desc limit 1");
$startDate2 = mysqli_fetch_array($startdate2);
$endDate2 = mysqli_fetch_array($enddate2);
$wynik2= $endDate2['var'] - $startDate2['var'];

//m3 read
$startdate3 = mysqli_query($con,"select var from m3 where ts >= '$data1' and ts <= '$data2' order by id asc limit 1");
$enddate3 = mysqli_query($con,"select var from m3 where ts >= '$data1' and ts <= '$data2' order by id desc limit 1");
$startDate3 = mysqli_fetch_array($startdate3);
$endDate3 = mysqli_fetch_array($enddate3);
$wynik3= $endDate3['var'] - $startDate3['var'];
// Przekażniki
//$relay1
$przekaznik1 = mysqli_fetch_array( mysqli_query($con,"select m1 from mdata where id=17"));
$przekaznik2 = mysqli_fetch_array( mysqli_query($con,"select m2 from mdata where id=17"));
$przekaznik3 = mysqli_fetch_array( mysqli_query($con,"select m3 from mdata where id=17"));


?>

	<table id="list" align="center">
	<tr>
	<th></th>
	<th>Stanowisko 32</th>
	<th>Stanowisko 33</th>
	<th>Stanowisko 34</th>
	</tr>

	<tr>
	<td><b>Pomiar energii w danym okresie <br><?php echo $data1 . "  - " . $data2 ;?> </b></td>
	<td align="center" ><?php echo $wynik1 ;?> KWh</td>
	<td align="center" ><?php echo $wynik2;?> KWh</td>
	<td align="center" ><?php echo  $wynik3 ;?> KWh</td>
	</tr>
	<tr>
        <td>Status załączenia zasilania na poszczególnych obwodach</td>
	<form name="update" method="post" >
	<td align="center"><button style="background-color:<?=getProperColor($przekaznik1['m1'])?>" class="b2" align="center" name = "relay1" type="submit"><?=getval($przekaznik1['m1']);?></button></td>
	<td align="center"> <button style="background-color:<?=getProperColor($przekaznik2['m2'])?>" class="b2" align="center" name = "relay2" type="submit"><?=getval($przekaznik2['m2']);?></button></td>
	<td align="center"><button style="background-color:<?=getProperColor($przekaznik3['m3'])?>" class="b2" align="center" name = "relay3" type="submit"><?=getval($przekaznik3['m3']);?></button></td>
	</tr>
	</form>
	        <tr>
        <td>Sumą prądu chwilowego</td>
<?php
        for($x=3;$x<6;$x++){
        global $mw1,$mw2,$mw3;
        $m1 = mysqli_query($con,"select m1 from mdata where id='$x'");
        $m11 = mysqli_fetch_array($m1);
        $mw1=  $mw1 + $m11['m1'];
        $m2 = mysqli_query($con,"select m2 from mdata where id='$x'");
        $m21 =  mysqli_fetch_array($m2);
        $mw2=  $mw2 + $m21['m2'];
        $m3 = mysqli_query($con,"select m3 from mdata where id='$x'");
         $m31 = mysqli_fetch_array($m3);
         $mw3= $mw3 + $m31['m3'];
}
?>
        <td align="center" ><?php echo $mw1;?> A</td>
        <td align="center" ><?php echo $mw2;?> A</td>
        <td align="center" ><?php echo $mw3;?> A</td>
        </tr>
	
	</table>
<?php
 mysqli_close($con); 
?>


<div id="center_button" align="center">
        <button class="back"  onclick="location.href='index.html'">Powrót do wpisywanie dat</button>

</div>

<?php

if (isset($_POST['relay1']))
{
	exec('/home/pi/chr1.py');
	echo '<meta http-equiv="refresh" content="1; URL=index.php" />';
}
if (isset($_POST['relay2']))
{
        exec('/home/pi/chr2.py');
	echo '<meta http-equiv="refresh" content="1; URL=index.php" />';
}
if (isset($_POST['relay3']))
{
        exec('/home/pi/chr3.py');
	echo '<meta http-equiv="refresh" content="1; URL=index.php" />';
}
?>

    <div style="position: absolute; bottom: 5px">
        <a href="pomiary.php">p</a>

    </div>


</body>
</html>
