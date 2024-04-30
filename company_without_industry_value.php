<?php 


// ini_set("display_errors", "1");

// error_reporting(E_ALL);
require ("inc/header_session.php");
require ("mainfunctions/database.php");
require ("mainfunctions/general-functions.php");



?>

<html>



<head>

    <title>Company records with missing industry value</title>

</head>



<style>

.outer-container {

    width: 100%;

    margin: 0 auto;

}



.container {

    padding: 10px;



}



.content {

    width: 50%;

    margin: unset;

    display: grid;

}



.txtstyle,

.txtstyle_color {

    font-family: arial;

    font-size: 13;

    font-weight: 700;

    height: 16px;

    background: #ABC5DF;

    text-align: center;

}



.center {

    text-align: center;

}



.left {

    text-align: left;

}



.tooltip {

  position: relative;

  display: inline-block;

  border-bottom: 1px dotted black;

}



.tooltip .tooltiptext {

  visibility: hidden;

  width: 120px;

  background-color: #D9F2FF;

  color: #000;

  text-align: center;

  border-radius: 6px;

  padding: 5px 0;

  position: absolute;

  z-index: 1;

  top: -5px;

  left: 110%;

  border: 1px solid #5E5E5E;

}



.tooltip .tooltiptext::after {

  content: "";

  position: absolute;

  top: 50%;

  right: 100%;

  margin-top: -5px;

  border-width: 5px;

  border-style: solid;

  border-color: transparent black transparent transparent;

}



.tooltip:hover .tooltiptext {

  visibility: visible;

}



.black_overlay{

	display: none;

	position: absolute;

	top: 0%;

	left: 0%;

	width: 100%;

	height: 100%;

	background-color: gray;

	z-index:1001;

	-moz-opacity: 0.8;

	opacity:.80;

	filter: alpha(opacity=80);

}



.white_content {

	display: none;

	position: absolute;

	top: 5%;

	left: 10%;

	width: 60%;

	height: 60%;

	padding: 16px;

	border: 1px solid gray;

	background-color: white;

	z-index:1002;

	overflow: auto;

}



.new_search_tbl{

	border-collapse: collapse;

}

.new_search_tbl td, .new_search_tbl th{

	border: 1px solid #FFF;

	padding: 3px;

	font-size: 12px;

	font-family: Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif;

}

.new_search_tbl td a{

	font-size: 12px;

	font-family: Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif;

	font-weight: normal;

}

.image_icon{

	border: 1px solid #FFFFFF;

	  box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2), 0 3px 6px 0 rgba(0, 0, 0, 0.19);

}

.legend_sty{

	border: 1px solid #CBCBCB;

	border-collapse: collapse;

	font-size: 12px;

	font-family: Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif;

}

.legend_sty tr td{

	padding-right: 22px;

	padding-top:4px;

	padding-bottom:4px;

	color: #363636;

	font-size: 12px;

	font-family: Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif;

}

.legend_sty tr td:first-child{

	padding-left: 10px;

}

</style>



<link rel='stylesheet' type='text/css' href='css/ucb_common_style.css'>

<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,400;0,600;1,300;1,400&display=swap"

    rel="stylesheet">



<body>

<div id="light_todo" class="white_content"></div>

<div id="fade_todo" class="black_overlay"></div>



<?php 
	require_once "inc/header.php";
	?>

    <br>

    <div class="outer-container">

        <div class="container">

            <div class="dashboard_heading" style="float: left;margin: 20px 0;">

                <div style="float: left;">

                    Company records with missing industry value

                    <div class="tooltip"><i class="fa fa-info-circle" aria-hidden="true"></i>

                        <span class="tooltiptext">This report shows us all company records in the system that don't have an industry value (excluding inactive, out of business, or trash records).</span>

                    </div><br>

                </div>

            </div>

            <div class="content"  style="width: 1600px;">


			<?php
			include 'company_without_inc_one.php';
			?>



            <?php
			include 'company_without_inc_two.php';
			?>

            </div>

</body>



</html>