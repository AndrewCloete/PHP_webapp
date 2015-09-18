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

		$geyser_id = 1;
		if(strcmp(Session::get('user_name'), "ahcloete")==0){
			$geyser_id = 110;
		}else{
			$geyser_id = 1;
		}

		$sql = "SELECT * from timestamps where geyser_id=".$geyser_id." ORDER BY server_stamp DESC LIMIT 1";
		$result = $conn->query($sql);
?>

<div class="container">
    <h1>DashboardController/index</h1>
    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <h3>Geyser Status</h3>
        <p>
            <?php

		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
			echo "Last seen server: " . $row["server_stamp"]. "<br>"
				."Last seen client: " . $row["client_stamp"]. "<br>"
				."Geyser ID: " . $row["geyser_id"]. "<br>"
				."Version: " . $row["version"]. "<br>"
				."Relay state: " . $row["relay_state"]. "<br>"
				."Valve state: " . $row["valve_state"]. "<br>"
				."Geyser state: " . $row["drip_detect"]. "<br>"
				."T1: " . $row["t1"]. "<br>"
				."T2: " . $row["t2"]. "<br>"
				."T3: " . $row["t3"]. "<br>"
				."T4: " . $row["t3"]. "<br>"
				."KW: " . $row["watt_avgpmin"]. "<br>"
				."KWH: " . $row["kwatt_tot"]. "<br>"
				."Hot/min: " . $row["hot_flow_ratepmin"]. "<br>"
				."Hot total: " . $row["hot_litres_tot"]. "<br>"
				."Cold/min: " . $row["cold_flow_ratepmin"]. "<br>"
				."Cold total: " . $row["cold_litres_tot"]. "<br>";
		    }
		} else {
		    echo "0 results";
		}
		$conn->close();
		?>
        <p>
    </div>
</div>
