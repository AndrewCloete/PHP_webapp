<?php
		$servername = "localhost";
		$username = "root";
		$password = "2538";
		$dbname = "GeyserM2M";

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 
		
		$name = Session::get('user_name');
		$geyser_id = 1;
		if(strcmp($name, "admin")==0){
			$geyser_id = array(1, 2, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111, 112);
		}else if(strcmp($name, "ahcloete")==0){
			$geyser_id = array(110);
		}else if(strcmp($name, "pi")==0){
			$geyser_id = array(2);
		}else if(strcmp($name, "aws")==0){
			$geyser_id = array(1);
		}else{
			$geyser_id = array(1);
		}
		
		//select * from users where user_name='admin';

		
?>

<div class="container">
    <h1>DashboardController/index</h1>
    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <h3>Geyser Status</h3>
        <p>
	<?php

		//echo "<br>"
		//echo "Geyser_ID: ".$geyser_id[$i]."<br>";
		//echo "Last seen server: " . $row["server_stamp"]. "<br>"
		//echo "Last seen client: " . $row["client_stamp"]. "<br>"
		//echo "Version: " . $row["version"]. "<br>"	
		echo '<table style="width:100%">
  		<tr>
			<th>ID</th>
			<th>Last Server</th>
			<th>Last Client</th>
			<th>Ver</th>
			<th>Relay</th>
			<th>Valve</th>
			<th>Burst</th>
			<th>T1</th>
			<th>T2</th>
			<th>T3</th>
			<th>T4</th>
			<th>KW</th>
			<th>KWH</th>
			<th>H/min</th>
			<th>Htot</th>
			<th>C/min</th>
			<th>Ctot</th>

		</tr>';

		for($i = 0; $i < sizeof($geyser_id); $i++){	

			$sql = "SELECT * from timestamps where geyser_id=".$geyser_id[$i]." ORDER BY server_stamp DESC LIMIT 1";
			$result = $conn->query($sql);

			//echo $geyser_id[$i];
			if ($result->num_rows > 0) {
			    // output data of each row
			    while($row = $result->fetch_assoc()) {
				echo '<tr style="text-align:center">'
					."<td>".$row["geyser_id"]."</td>"
					."<td>".$row["server_stamp"]."</td>"
					."<td>".$row["client_stamp"]."</td>"
					."<td>".$row["version"]."</td>"
					."<td>".$row["relay_state"]."</td>"
					."<td>".$row["valve_state"]."</td>"
					."<td>".$row["drip_detect"]."</td>"
					."<td>".$row["t1"]."</td>"
					."<td>".$row["t2"]."</td>"
					."<td>".$row["t3"]."</td>"
					."<td>".$row["t3"]."</td>"
					."<td>".$row["watt_avgpmin"]."</td>"
					."<td>".$row["kwatt_tot"]."</td>"
					."<td>".$row["hot_flow_ratepmin"]."</td>"
					."<td>".$row["hot_litres_tot"]."</td>"
					."<td>".$row["cold_flow_ratepmin"]."</td>"
					."<td>".$row["cold_litres_tot"]."</td>"
				."</tr>";
			    }
			} else {
		   		echo '<tr style="text-align:center">'
						."<td>".$geyser_id[$i]."</td>"
						.'<td> - </td>
						<td> - </td>
						<td> - </td>
						<td> - </td>
						<td> - </td>
						<td> - </td>
						<td> - </td>
						<td> - </td>
						<td> - </td>
						<td> - </td>
						<td> - </td>
						<td> - </td>
						<td> - </td>
						<td> - </td>
						<td> - </td>

					</tr>';
			}
			
		}
		$conn->close();
	?>
        <p>
    </div>

<form method="POST" action="/dashboard/command/">

<table class="center">
</tr>
<tr>
	<th>Geyser ID:</th>
	<td>
 		<input type="text" name="geyser_id" <?php if(!strcmp($name, "admin")==0){ echo 'value='.$geyser_id[0].' readonly';} ?>><br>
 	</td>
</tr>
<tr>
	<th>Schedule:</th>
	<td>
 		<button style="height:25px; width:75px" name = "s" type="submit" value="low">LOW</button>
		<button style="height:25px; width:75px" name = "s" type="submit" value="high">HIGH</button>
		<button style="height:25px; width:75px" name = "s" type="submit" value="smart">SMART</button>
 	</td>
</tr>
<tr>
	<th>Switch element:</th>
	<td>
 		<button style="height:25px; width:75px" name = "e" type="submit" value="on">ON</button>
		<button style="height:25px; width:75px" name = "e" type="submit" value="off">OFF</button>
		<button style="height:25px; width:75px" name = "e" type="submit" value="auto">AUTO</button>
 	</td>
</tr>
<tr>
	<th>GSTATE:</th>
	<td>
 		<button style="height:25px; width:75px" name = "g" type="submit" value="set">SET</button>
		<button style="height:25px; width:75px" name = "g" type="submit" value="resest">RESET</button>
 	</td>
</tr>	
</table>
</form>


</div>
