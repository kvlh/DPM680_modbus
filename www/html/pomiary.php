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
.hidden {
  background-color: black;
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
$con=mysqli_connect("localhost","modbus","modbus2018","modbus");
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>
	<table id="list" align="center">
	<tr>
	<th>Aktualne pomiary</th>
	<th></th><th></th><th></th>
	</tr>
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
	<td><?php echo $mw1;?></td>
	<td><?php echo $mw2;?></td>
	<td><?php echo $mw3;?></td>
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
</table>

<div id="center_button" align="center">
        <button class="back"  onclick="location.href='index.html'">Powrót do wpisywanie dat</button>
	<button class="back"  onclick="location.href='index.php'">Powrót do wyników</button>
</div>



</body>
</html>
