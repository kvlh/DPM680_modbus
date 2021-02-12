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
.b1 {
  background-color: #f44336;
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
.b3 {
  background-color: #555555;
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

#list {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
    text-align center;
}

#list td, #lista th {
    border: 1px solid #ddd;
    padding: 5px;
    text-align center;
}
#list {
    border-collapse: collapse;
    width: 50%;
    text-algin: center;
}
#list tr:nth-child(even){background-color: #f2f2f2;}

#list tr:ver {background-color: #ddd;}

#list td{
text-algin: center;
}
#list th {
    padding-top: 5px;
    padding-bottom: 5px;
    text-align: center;
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
	<th>Licznik 1</th>
	<th>Licznik 2</th>
	<th>Licznik 3</th>
	</tr>

	<tr>
	<td><b>Pomiar energii w danym okresie <br><?php echo $data1 . "  - " . $data2 ;?> </b></td>
	<td><?php echo $wynik1 ;?></td>
	<td><?php echo $wynik2;?></td>
	<td><?php echo  $wynik3 ;?></td>
	</tr>
	<tr>
        <td>Status załączenia zasilania na poszczególnych obwodach</td>
	<th><?php echo $przekaznik1['m1'];?> </th>
	<th><?php echo $przekaznik2['m2'];?> </th>
	<th><?php echo $przekaznik3['m3'];?> </th>
	</tr>
	<tr>
	<td></td><td></td><td></td><td></td>
	</tr>
	<tr>
	<th>Aktualne pomiary</th>
	<th></th><th></th><th></th>
	</tr>

<?php
for($x=1;$x<17;$x++){
	$text = mysqli_query($con,"select text from mdata where id='$x'");
	$text1 = mysqli_fetch_array($text);
        $m1 = mysqli_query($con,"select m1 from mdata where id='$x'");
        $m11 = mysqli_fetch_array($m1);
        $m2 = mysqli_query($con,"select m2 from mdata where id='$x'");
        $m21 = mysqli_fetch_array($m2);
        $m3 = mysqli_query($con,"select m3 from mdata where id='$x'");
        $m31 = mysqli_fetch_array($m3);

//	echo "<tr><td>" . $text1['text'] . "</td>" ."<td>" . $m11['m1'] . "</td>" ."<td>" . $m21['m2'] . "</td>" ."<td>" . $m31['m3'] . "</td></tr>" ;
?>
	<tr><td><?php echo  $text1['text']; ?></td><td><?php echo $m11['m1'];?></td><td><?php echo $m21['m2'];?></td><td><?php echo $m31['m3'];?></td></tr>
<?php
}


 mysqli_close($con); 
?>


<div id="center_button" align="center">
        <button class="back"  onclick="location.href='index.html'">Powrót do wpisywanie dat</button>
        <button class="back"  value="Refresh Page" onClick="history.go(0)">Odświerzenie strony </button>

	<form name="update" method="post" >
		 <button class="b1"name = "relay1" type="submit">Załączenie/Rozłączenie obwodu 1</button>
		 <button class="b2" name = "relay2" type="submit">Załączenie/Rozłączenie obwodu 2</button>
		 <button class="b3" name = "relay3" type="submit">Załączenie/Rozłączenie obwodu 3</button>
	</form>
</div>

<?php

if (isset($_POST['relay1']))
{
	exec('/home/pi/chr1.py');
	echo '<meta http-equiv="refresh" content="1; URL=index.html" />';
}
if (isset($_POST['relay2']))
{
        exec('/home/pi/chr2.py');
	echo '<meta http-equiv="refresh" content="1; URL=index.html" />';
}
if (isset($_POST['relay3']))
{
        exec('/home/pi/chr3.py');
	echo '<meta http-equiv="refresh" content="1; URL=index.html" />';
}
?>



</body>
</html>
