<?php

session_start();
// ini_set("display_errors", "1");

// error_reporting(E_ALL);
//require ("inc/header_session.php");
require "inc/header_session.php";
require "mainfunctions/database.php";
require "mainfunctions/general-functions.php";

// <?php echo $rowcolor1;

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Matching Tools v3.0</title>
		<link rel="stylesheet" type="text/css" href="css/front_style.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<script src="scripts/jquery.min.js"></script>
		<script type="text/javascript">
			var timerStart = Date.now();

			function show_loading(){
				document.getElementById('overlay').style.display='block';
			}

			function frm_check(){
				var apin = document.getElementById("zipcode").value;
				var boxs = document.getElementById("itype").value;



				if (boxs == 0){
					alert("Please select any one Item type.");
					return false;
				}
			}

			function show_options_tbl(e){
				if(e == 1){
					document.getElementById("1").style.display = "block";
					document.getElementById("2").style.display = "none";
					document.getElementById("3").style.display = "none";
					document.getElementById("4").style.display = "none";
				}else if(e == 2){
					document.getElementById("1").style.display = "none";
					document.getElementById("2").style.display = "block";
					document.getElementById("3").style.display = "none";
					document.getElementById("4").style.display = "none";
				}else if(e == 3){
					document.getElementById("1").style.display = "none";
					document.getElementById("2").style.display = "none";
					document.getElementById("3").style.display = "block";
					document.getElementById("4").style.display = "none";
				}else if(e == 4){
					document.getElementById("1").style.display = "none";
					document.getElementById("2").style.display = "none";
					document.getElementById("3").style.display = "none";
					document.getElementById("4").style.display = "block";
				}else{
					document.getElementById("1").style.display = "none";
					document.getElementById("2").style.display = "none";
					document.getElementById("3").style.display = "none";
					document.getElementById("4").style.display = "none";
				}
			}

			function isNumberKey(evt){

				var charCode = (evt.which) ? evt.which : evt.keyCode;
				if (charCode != 46 && charCode > 31	&& (charCode < 48 || charCode > 57))
					return false;

				return true;
			}

		</script>
	</head>
<body>

	<script>
		window.addEventListener('load', (event) => {
		    console.log('All assets are loaded')
		    console.log(Date.now() - window.performance.timing.navigationStart);
		    $('#overlay').fadeOut();
		});
	</script>
	<div id="overlay" style="border: 1px solid black; text-align: center; margin: 0 auto; width: 100%; display: none;">
			<font color="black"><div style="background-color:rgba(255, 255, 255, 1); width: 150px; display: block; padding: 10px; text-align: center; box-shadow: 0px 10px  5px rgba(0,0,0,0.6);
	  -moz-box-shadow: 0px 10px  5px  rgba(0,0,0,0.6);
	  -webkit-box-shadow: 0px 10px 5px  rgba(0,0,0,0.6);
	  -o-box-shadow: 0px 10px 5px  rgba(0,0,0,0.6); border-radius:10px;">Loading... </font><img src="images/wait_animated.gif" alt="Loading" /></div>

	</div>
	<header>
		<div class="main_container">
			<div class="sub_container">
				<div class="header">
					<div id="container">

					<div id="left">
						<div class="logo_img">
							<div class="logo_display">
								<a href="client_matching_tool.php"  onclick="show_loading()">
								<img id="site-logo" src="images/ucb_logo.png" alt="moving boxes" style="object-fit: cover;"></a>
							</div>
						</div>
					</div>

					<div id="middle">
						<div class="middle-col">
							<h3 class=""><b><i>Matching Tools v3.0</i></b></h3>
							<br>
						</div>
					</div>

					<div id="right">
					</div>

				</div>

				</div>
			</div>
		</div>
	</header>
	<br><br>

	<main>
		<div class="sub_container">
			<div class="mb-30">
				<div class="col">
					<?php
					include 'client_matching_tool_inc.php';
					?>
				</div>
			</div>
		</div>
	</main>

	<footer>
		<div class="footer_l">
			<div class="copytxt">© UsedCardboardBoxes</div>
		</div>
	</footer>
</body>

</html>
