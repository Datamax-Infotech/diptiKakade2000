
<SCRIPT LANGUAGE="JavaScript" SRC="inc/general.js"></SCRIPT>


<script language="JavaScript">

    function formCheckInv()
    {

        if (validateEmail(document.frmselltoedit.selltoemail.value) == false)
        {
            alert('Please enter a valid email address.');
            return false;
        }
    }

    function formCheckInv_billto()
    {

        if (validateEmail(document.frmbilltoedit.billtoemail.value) == false)
        {
            alert('Please enter a valid email address.');
            return false;
        }
    }

    function validateEmail(email) {
        var regexva = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (email != '')
        {
            return regexva.test(email);
        }else{
            return true;
        }
    }


</script>
	<?php

	function viewCompany(
		string $company,
		string $industry,
		string $website,
		string $preparer,
		string $howHear,
		string $help,
		int $ID,
		string $overall_revenue_comp,
		int $noof_location,
		string $nickname,
		string $createddt
	): void 
	{
		$website = "http://" . $website;
		?>
			<table border="0" width="100%" cellspacing="1" cellpadding="1">
				<tr align="center">
					<td colspan="2" bgcolor="#C0CDDA">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">COMPANY INFO</font>
						<font face="Arial, Helvetica, sans-serif" size="1" color="#C0CDDA">
							<a href="viewCompany.php?ID=<?php echo $ID ?>&Edit=1">
								<img bgcolor="#C0CDDA" src="images/edit.jpg">
							</a>
						</font>
					</td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13" width="40%">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Company Name (Legal Name)</font>
					</td>
					<td align="left" width="60%" height="13">
						<font face="Arial, Helvetica, sans-serif" size="1"><?php echo $company ?></font>
					</td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">UCB Nickname ("Location – City, ST")</font>
					</td>
					<td align="left" height="13">
						<font face="Arial, Helvetica, sans-serif" size="1"><?php echo $nickname ?></font>
					</td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Industry</font>
					</td>
					<td align="left" height="13">
						<font face="Arial, Helvetica, sans-serif" size="1"><?php echo $industry ?></font>
					</td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Website</font>
					</td>
					<td align="left" height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
							<a href="<?php echo $website ?>" target="_blank"><?php echo $website ?></a>
						</font>
					</td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Overall Revenue of company (if published)</font>
					</td>
					<td align="left" height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $overall_revenue_comp ?></font>
					</td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Number of locations in the US</font>
					</td>
					<td align="left" height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $noof_location ?></font>
					</td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">UCB Qualifier</font>
					</td>
					<td align="left" height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $preparer ?></font>
					</td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">How did they hear about UCB?</font>
					</td>
					<td align="left" height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $howHear ?></font>
					</td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Reason For Contact</font>
					</td>
					<td align="left" height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $help ?></font>
					</td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Record Created on</font>
					</td>
					<td align="left" height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $createddt ?></font>
					</td>
				</tr>
			</table>
		<?php
	}



	function viewCompany_Sellto(
		string $contact,
		string $contactTitle,
		string $address,
		string $address2,
		string $city,
		string $state,
		string $zip,
		string $country,
		string $phone,
		string $mobileno,
		string $fax,
		string $email,
		int $ID,
		string $in_loops,
		string $loopurl
	): void 
	{
		?>
			<table border="0" width="100%" cellspacing="1" cellpadding="1">
				<tr align="center">
					<td colspan="2" bgcolor="#C0CDDA">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">SELL TO<br/>
						(the person who is authorized and agrees to purchase)</font>
						<font face="Arial, Helvetica, sans-serif" size="1" color="#C0CDDA">
							<?php 
								if ($in_loops == "yes") { 
							?>
								<a href="search_results.php?<?php echo $loopurl ?>&Edit_mode=sellto_edit">
							<?php 
								} else { 
							?>
								<a href="viewCompany.php?ID=<?php echo $ID ?>&Edit=12">
							<?php 
								}  
							?>
							<img bgcolor="#C0CDDA" src="images/edit.jpg"></a>
						</font>
					</td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13" width="40%">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Primary Contact Name </font>
					</td>
					<td align="left" width="60%" height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $contact ?></font>
					</td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="10">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Primary Contact Title </font>
					</td>
					<td align="left" height="10">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $contactTitle ?></font>
					</td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Address 1</font>
					</td>
					<td align="left" height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $address ?></font>
					</td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="19">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Address 2</font>
					</td>
					<td align="left" height="19">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $address2 ?></font>
					</td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">City</font>
					</td>
					<td align="left" height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $city ?></font>
					</td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">State/Province</font>
					</td>
					<td align="left" height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $state ?></font>
					</td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Zip</font>
					</td>
					<td align="left" height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $zip ?></font>
					</td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Country</font>
					</td>
					<td align="left" height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $country ?></font>
					</td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Phone</font>
					</td>
					<td align="left" height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $phone ?></font>
					</td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Mobile No</font>
					</td>
					<td align="left" height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $mobileno ?></font>
					</td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Reply To E-mail</font>
					</td>
					<td align="left" height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
							<a href="mailto:<?php echo $email ?>"><?php echo $email ?></a>
						</font>
					</td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Fax</font>
					</td>
					<td align="left" height="13">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $fax ?></font>
					</td>
				</tr>
			</table>
		<?php
	}
	


	function viewCompanyEdit(
		string $company,
		string $industry,
		string $website,
		string $preparer,
		string $howHear,
		string $help,
		int $ID,
		string $overall_revenue_comp,
		string $noof_location,
		string $nickname,
		string $createddt
	): void 
	{
		?>
			<form method="post" action="editTables.php">
				<table border="0" cellspacing="1" cellpadding="1">
					<tr align="center">
						<td colspan="2" bgcolor="#C0CDDA" height="13">
							<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">COMPANY INFO</font>
						</td>
					</tr>
					<tr bgcolor="#E4E4E4">
						<td height="13" width="40%">
							<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Company Name (Legal Name)</font>
						</td>
						<td align="left" width="60%" height="13">
							<font face="Arial, Helvetica, sans-serif" size="1">
								<input size="30" type="text" name="company" value="<?php echo $company ?>">
							</font>
						</td>
					</tr>
		
					<tr bgcolor="#E4E4E4">
						<td height="13">
							<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">UCB Nickname ("Location – City, ST")</font>
						</td>
						<td align="left" height="13">
							<font face="Arial, Helvetica, sans-serif" size="1">
								<input size="30" type="text" name="nickname" value="<?php echo $nickname ?>">
							</font>
						</td>
					</tr>
		
					<tr bgcolor="#E4E4E4">
						<td height="13">
							<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Industry</font>
						</td>
						<td align="left" height="13">
							<font face="Arial, Helvetica, sans-serif" size="1">
								<input size="30" type="text" name="industry" value="<?php echo $industry ?>">
							</font>
						</td>
					</tr>
					
					<tr bgcolor="#E4E4E4">
						<td height="13">
							<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Website</font>
						</td>
						<td align="left" height="13">
							<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
								<input size="30" type="text" name="website" value="<?php echo $website ?>">
							</font>
						</td>
					</tr>
					
					<tr bgcolor="#E4E4E4">
						<td height="13">
							<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Overall Revenue of company (if published)</font>
						</td>
						<td align="left" height="13">
							<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
								<input size="30" type="text" name="overall_revenue_comp" value="<?php echo $overall_revenue_comp ?>">
							</font>
						</td>
					</tr>
		
					<tr bgcolor="#E4E4E4">
						<td height="13">
							<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Number of locations in the US</font>
						</td>
						<td align="left" height="13">
							<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
								<input size="30" type="text" name="noof_location" value="<?php echo $noof_location ?>" >
							</font>
						</td>
					</tr>
					
					<tr bgcolor="#E4E4E4">
						<td height="13">
							<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">UCB Qualifier</font>
						</td>
						<td align="left" height="13">
							<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
								<input size="30" type="text" name="preparer" value="<?php echo $preparer ?>" >
							</font>
						</td>
					</tr>
					
					<tr bgcolor="#E4E4E4">
						<td height="13">
							<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">How did they hear about UCB?</font>
						</td>
						<td align="left" height="13">
							<select size="1" name="howHear">
								<option><?php echo $howHear ?></option>
								<?php
								

								$howH = "SELECT * FROM howHear";
								db_b2b();
								$dt_view_res2 = db_query($howH);

								while ($hh = array_shift($dt_view_res2)) {
									echo "<option";
									if ($hh["name"] == $howHear)
										echo " selected";
									echo ">" . $hh["name"] . "</option>";
								}

								?>
							</select>
						</td>
					</tr>
					
					<tr bgcolor="#E4E4E4">
						<td height="13">
							<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Reason for Contact</font>
						</td>
						<td align="left" height="13">
							<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
								<textarea rows="5" cols="22" name="help"><?php echo $help ?></textarea>
							</font>
						</td>
					</tr>
					
					<tr bgcolor="#E4E4E4">
						<td height="13">
							<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Record Created on</font>
						</td>
						<td align="left" height="13">
							<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
								<?php echo $createddt ?>
							</font>
						</td>
					</tr>
		
					<tr bgcolor="#E4E4E4">
						<td colspan="2">
							<p align="center">&nbsp;<input align="center" type="submit" value="Save">
							<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">&nbsp;<a href="viewCompany.php?ID=<?php echo $ID ?>">nevermind</a></font>
						</td>
					</tr>
				</table>
				<input type="hidden" name="editTable" value="company">
				<input type="hidden" name="id" value="<?php echo $ID ?>">
			</form>
		<?php
	}
	

	function viewCompany_SelltoEdit(
		string $contact,
		string $contactTitle,
		string $address,
		string $address2,
		string $city,
		string $state,
		string $zip,
		string $country,
		string $phone,
		string $mobileno,
		string $fax,
		string $email,
		int $ID,
		string $in_loops,
		string $loopurl
	): void 
	{
		?>
		<form method="post" action="editTables.php">
			<table border="0" width="100%" cellspacing="1" cellpadding="1">
				<tr align="center">
					<td colspan="2" bgcolor="#C0CDDA">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">SELL TO<br/>
						(the person who is authorized and agrees to purchase)</font>
					</td>
				</tr>
	
				<tr bgcolor="#E4E4E4">
					<td height="13" width="60%"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Primary Contact Name</font></td>
					<td align="left" width="40%" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
						<input size="30" type="text" name="contact" value="<?= htmlspecialchars($contact) ?>"></font></td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="10"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Primary Contact Title</font></td>
					<td align="left" height="10"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
						<input size="30" type="text" name="contactTitle" value="<?= htmlspecialchars($contactTitle) ?>"></font></td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Address 1</font></td>
					<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
						<input size="30" type="text" name="address" value="<?= htmlspecialchars($address) ?>"></font></td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="19"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Address 2</font></td>
					<td align="left" height="19"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
						<input size="30" type="text" name="address2" value="<?= htmlspecialchars($address2) ?>"></font></td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">City</font></td>
					<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
						<input size="30" type="text" name="city" value="<?= htmlspecialchars($city) ?>"></font></td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">State/Province</font></td>
					<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
						<select name="state">
							<?php
							
						
							$tableedit = "SELECT * FROM zones WHERE zone_country_id IN (223,38) ORDER BY zone_country_id, zone_code";
							db_b2b();
							$dt_view_res = db_query($tableedit);

							while ($row = array_shift($dt_view_res)) {
							?>
								<option <?php if ((trim($state) == trim($row["zone_code"])) || (trim($state) == trim($row["zone_name"]))) echo " selected "; ?> value="<?= htmlspecialchars(trim($row["zone_code"])) ?>">
									<?= htmlspecialchars($row["zone_name"]) ?>
									(<?= htmlspecialchars($row["zone_code"]) ?>)
								</option>
							<?php
							}

							?>
						</select>
					</font></td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Zip</font></td>
					<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
						<input size="30" type="text" name="zip" value="<?= htmlspecialchars($zip) ?>"></font></td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Country</font></td>
					<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
						<input size="30" type="text" name="country" value="<?= htmlspecialchars($country) ?>"></font></td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Phone</font></td>
					<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
						<input size="30" type="text" name="phone" value="<?= htmlspecialchars($phone) ?>"></font></td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Mobile No</font></td>
					<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
						<input size="30" type="text" name="mobileno" value="<?= htmlspecialchars($mobileno) ?>"></font></td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Reply To E-mail</font></td>
					<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
						<input size="30" type="text" name="email" onkeypress="return isSpace(event)" value="<?= htmlspecialchars($email) ?>"></font></td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Fax</font></td>
					<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
						<input size="30" type="text" name="fax" value="<?= htmlspecialchars($fax) ?>"></font></td>
				</tr>
	
				<tr bgcolor="#E4E4E4">
					<td colspan="2">
						<p align="center">&nbsp;<input align="center" type="submit" value="Save">
							<?php if ($in_loops == "yes") {
								$tmpstr = $loopurl;
								$tmpstr = str_replace("Edit_mode=sellto_edit", "", $tmpstr);?>
								<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">&nbsp;<a href="search_results.php?<?= htmlspecialchars($tmpstr) ?>">nevermind</a></font>
							<?php } else { ?>
								<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">&nbsp;<a href="viewCompany.php?ID=<?= htmlspecialchars(strval($ID)) ?>">nevermind</a></font>
							<?php } ?>
					</td>
				</tr>
			</table>
			<?php if ($in_loops == "yes") { ?>
				<input type="hidden" name="search_result_url" value="<?= htmlspecialchars($tmpstr) ?>">
			<?php } else { ?>
				<input type="hidden" name="search_result_url" value="no">
			<?php } ?>
	
			<input type="hidden" name="editTable" value="company_sellto">
			<input type="hidden" name="id" value="<?= htmlspecialchars(strval($ID)) ?>">
	
		</form>
		<?php
	}
	



	function viewShipping(
		string $shipContact,
		string $shipTitle,
		string $shipAddress,
		string $shipAddress2,
		string $shipCity,
		string $shipState,
		string $shipZip,
		string $shipPhone,
		string $shipMobileno,
		int $ID,
		string $in_loops,
		string $loopurl,
		string $shipemail
	): void 
	{
		?>
	
		<table width="100%" border="0" cellspacing="1" cellpadding="1" height="211">
			<tr align="center">
				<td colspan="2" bgcolor="#C0CDDA" height="13">
					<font face="Arial, Helvetica, sans-serif" size="1">SHIP TO <br/>
					(the person/location that will physically receive shipment)
					<?php if ($in_loops == "yes") { ?>
						<a href="search_results.php?<?= htmlspecialchars($loopurl) ?>&Edit_mode=shipto_edit">
					<?php } else { ?>
						<a href="viewCompany.php?ID=<?= htmlspecialchars(strval($ID)) ?>&Edit=2">
					<?php }  ?>
					<img bgcolor="#C0CDDA"  src="images/edit.jpg"></a></font>
				</td>
			</tr>
			<tr bgcolor="#E4E4E4">
				<td height="13" width="40%"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Contact Name </font></td>
				<td align="left" width="60%" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?= htmlspecialchars($shipContact) ?></font></td>
			</tr>
			<tr bgcolor="#E4E4E4">
				<td height="10"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Contact Title </font></td>
				<td align="left" height="10"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?= htmlspecialchars($shipTitle) ?></font></td>
			</tr>
			<tr bgcolor="#E4E4E4">
				<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Address 1</font></td>
				<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?= htmlspecialchars($shipAddress) ?></font></td>
			</tr>
			<tr bgcolor="#E4E4E4">
				<td height="19"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Address 2</font></td>
				<td align="left" height="19"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?= htmlspecialchars($shipAddress2) ?></font></td>
			</tr>
			<tr bgcolor="#E4E4E4">
				<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">City</font></td>
				<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?= htmlspecialchars($shipCity) ?></font></td>
			</tr>
			<tr bgcolor="#E4E4E4">
				<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">State/Province</font></td>
				<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?= htmlspecialchars($shipState) ?></font></td>
			</tr>
			<tr bgcolor="#E4E4E4">
				<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Zip</font></td>
				<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?= htmlspecialchars($shipZip) ?></font></td>
			</tr>
			<tr bgcolor="#E4E4E4">
				<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Phone</font></td>
				<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?= htmlspecialchars($shipPhone) ?></font></td>
			</tr>
			<tr bgcolor="#E4E4E4">
				<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Mobile No</font></td>
				<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?= htmlspecialchars($shipMobileno) ?></font></td>
			</tr>
			<tr bgcolor="#E4E4E4">
				<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Email</font></td>
				<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?= htmlspecialchars($shipemail) ?></font></td>
			</tr>
		</table>
	
		<?php
	}
	

	function viewShippingEdit(string $shipContact, string $shipTitle, string $shipAddress, string $shipAddress2, string $shipCity, string $shipState, string $shipZip, string $shipPhone, string $shipMobileno, int $ID, string $in_loops, string $loopurl, string $shipemail): void 
	{
		?>
		<form method="post" action="editTables.php">
			<table width="100%" border="0" cellspacing="1" cellpadding="1" height="211">
				<tr align="center">
					<td colspan="2" bgcolor="#C0CDDA" height="13">
						<font face="Arial, Helvetica, sans-serif" size="1">SHIP TO <br/>
						(the person/location that will physically receive shipment)</font>
					</td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13" width="40%"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Contact Name </font></td>
					<td align="left" width="60%" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><input name="shipContact" value="<?php echo $shipContact?>" size="20"></font></td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="10"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Contact Title </font></td>
					<td align="left" height="10"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><input name="shipTitle" value="<?php echo $shipTitle?>" size="20"></font></td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Address 1</font></td>
					<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><input name="shipAddress" value="<?php echo $shipAddress?>" size="20"></font></td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="19"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Address 2</font></td>
					<td align="left" height="19"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><input name="shipAddress2" value="<?php echo $shipAddress2?>" size="20"></font></td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">City</font></td>
					<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><input name="shipCity" value="<?php echo $shipCity?>" size="20"></font></td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">State/Province</font></td>
					<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
						<select name="shipState">
							<option value="" ></option>
							<?php
							$tableedit  = "SELECT * FROM zones where zone_country_id in (223,38) ORDER BY zone_country_id, zone_code";
							db_b2b();
							$dt_view_res = db_query($tableedit);
							while ($row = array_shift($dt_view_res)) {
							?>
							<option
							<?php
							if ((trim($shipState) == trim($row["zone_code"])) ||  (trim($shipState) == trim($row["zone_name"])))
								echo " selected ";
							?> value="<?php echo trim($row["zone_code"])?>">
								<?php echo $row["zone_name"]?>
								(<?php echo $row["zone_code"]?>)
							</option>
							<?php
							}

							

							?>
						</select>
					</td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Zip</font></td>
					<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><input name="shipZip" value="<?php echo $shipZip?>" size="20"></font></td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Phone</font></td>
					<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><input name="shipPhone" value="<?php echo $shipPhone?>" size="20"></font></td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Mobile No</font></td>
					<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><input name="shipMobileno" value="<?php echo $shipMobileno?>" size="20"></font></td>
				</tr>
				<tr bgcolor="#E4E4E4">
					<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Email</font></td>
					<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><input name="shipemail" value="<?php echo $shipemail?>" size="20"></font></td>
				</tr>

				<tr bgcolor="#E4E4E4">
					<td colspan=2>
						<p align="center">&nbsp;<input align="center" type="submit" value="Save">
						<?php if ($in_loops == "yes") {
							$tmpstr = $loopurl;
							$tmpstr = str_replace("Edit_mode=shipto_edit", "", $tmpstr);?>
							<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">&nbsp;<a href="search_results.php?<?php echo $tmpstr?>">nevermind</a></font>
						<?php } else { ?>
							<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">&nbsp;<a href="viewCompany.php?ID=<?php echo $ID?>">nevermind</a></font>
						<?php } ?>
					</td>
				</tr>
			</table>
			<?php if ($in_loops == "yes") { ?>
				<input type="hidden" name="search_result_url" value="<?php echo $tmpstr?>">
			<?php } else { ?>
				<input type="hidden" name="search_result_url" value="no">
			<?php } ?>
			<input type=hidden name="editTable" value="shipping">
			<input type=hidden name="id" value="<?php echo $ID?>">
		</form>
		<?php
	}
	




	function view_billTo(int $ID, string $in_loops, string $loopurl): void 
	{
		$qry = "Select * from b2bbillto where companyid = " . $ID . " order by billtoid";
		db_b2b();
		$dt_view= db_query($qry);
		if ( count($dt_view) > 0)
		{
			while ($objdb = array_shift($dt_view)) 
			{
				viewbillTodisplay($objdb["title"], $objdb["name"], $objdb["address"], $objdb["address2"], $objdb["city"], $objdb["state"], $objdb["zipcode"], $objdb["mainphone"], $objdb["directphone"], $objdb["cellphone"], $objdb["email"], $ID, $objdb["billtoid"], $objdb["fax"], $in_loops, $loopurl);
				?>
				<?php
			}
			?>
	
		<?php
		}else
		{
			viewbillTodisplay("", "", "", "", "", "", "", "" , "" , "" , "", $ID,0, "", $in_loops, $loopurl);
		}
	
		?>
	
	
	
		<form method="POST" action="editTables.php?action=billtoadd" id="addbilltofrm" name="addbilltofrm">
			<?php if ($in_loops == "yes") { ?>
				<input type="hidden" name="companyid" value="<?php echo $ID?>">
				<input type="hidden" name="search_result_url" value="<?php echo $loopurl?>">
			<?php } else { ?>
				<input type="hidden" name="id" value="<?php echo $ID?>">
				<input type="hidden" name="search_result_url" value="no">
			<?php } ?>
			<input type="submit" name="addbillto" value="Add another BILL TO">
		</form>
	
	   <?php
		  
	}
	


	function viewbillTodisplay(
		string $title,
		string $name,
		string $address,
		string $address2,
		string $city,
		string $state,
		string $zip,
		string $mainphone,
		string $directphone,
		string $cellphone,
		string $email,
		int $ID,
		int $billtoid,
		string $fax,
		string $in_loops,
		string $loopurl
	): void {
		?>
		<table width="100%" border="0" cellspacing="1" cellpadding="1" height="211">
			<tr align="center">
				<td colspan="2" bgcolor="#C0CDDA" height="13">
					<font face="Arial, Helvetica, sans-serif" size="1">BILL TO<br/>
					(the person/organization to whom we will invoice)
					<?php if ($in_loops == "yes") { ?>
						<a href="search_results.php?<?php echo $loopurl?>&Edit_mode=billto_edit&billtoid=<?php echo $billtoid?>">
					<?php } else { ?>
						<a href="viewCompany.php?ID=<?php echo $ID?>&Edit=4&billtoid=<?php echo $billtoid?>">
					<?php }  ?>
					<img bgcolor="#C0CDDA"  src="images/edit.jpg"></a></font>
					&nbsp;
					<?php if ($billtoid > 0 ) { if ($in_loops == "yes") { ?>
						<a href="delete_billto.php?<?php echo $loopurl?>&billtoid=<?php echo $billtoid?>" onclick="return confirm('Are you sure you want to delete this record?')">
					<?php } else { ?>
						<a href="delete_billto.php?ID=<?php echo $ID?>&billtoid=<?php echo $billtoid?>" onclick="return confirm('Are you sure you want to delete this record?')">
					<?php }  ?>
					<img bgcolor="#C0CDDA"  src="images/del_img.png"></a>
					<?php } ?>
				</td>
			</tr>
			<tr bgcolor="#E4E4E4">
				<td height="10" width="40%" ><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Name</font></td>
				<td align="left" width="60%" height="10"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
				<?php echo $name?></font></td>
			</tr>
			<tr bgcolor="#E4E4E4">
				<td height="13" ><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Title </font></td>
				<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
				<?php echo $title?></font></td>
			</tr>
			<tr bgcolor="#E4E4E4">
				<td height="13" ><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Address 1</font></td>
				<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
				<?php echo $address?></font></td>
			</tr>
			<tr bgcolor="#E4E4E4">
				<td height="19" ><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Address 2</font></td>
				<td align="left" height="19"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
				<?php echo $address2?></font></td>
			</tr>
			<tr bgcolor="#E4E4E4">
				<td height="13" ><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">City</font></td>
				<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
				<?php echo $city?></font></td>
			</tr>
			<tr bgcolor="#E4E4E4">
				<td height="13" ><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">State/Province</font></td>
				<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
				<?php echo $state?></font></td>
			</tr>
			<tr bgcolor="#E4E4E4">
				<td height="13" ><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Zip</font></td>
				<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
				<?php echo $zip?></font></td>
			</tr>
			<tr bgcolor="#E4E4E4">
				<td height="13" ><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Phone</font></td>
				<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
				<?php echo $mainphone?></font></td>
			</tr>
			<tr bgcolor="#E4E4E4">
				<td height="13" ><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Mobile No</font></td>
				<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
				<?php echo $cellphone?></font></td>
			</tr>
			<tr bgcolor="#E4E4E4">
				<td height="13" ><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Email</font></td>
				<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
				<?php echo $email?></font></td>
			</tr>
			<tr bgcolor="#E4E4E4">
				<td height="13" ><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Fax</font></td>
				<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
				<?php echo $fax?></font></td>
			</tr>
		</table>
		<br/>
		<?php
	}
	

	function viewbillToEdit(int $ID, int $billtoid, string $in_loops, string $loopurl): void
	{
		$qry = "SELECT * FROM b2bbillto WHERE companyid = $ID ORDER BY billtoid";
		db_b2b();
		$dt_view = db_query($qry);
		if (count($dt_view) > 0) {
			while ($objdb = array_shift($dt_view)) {
				if ($objdb["billtoid"] == $billtoid) {
					viewbillTodisplayedit(
						$objdb["title"],
						$objdb["name"],
						$objdb["address"],
						$objdb["address2"],
						$objdb["city"],
						$objdb["state"],
						$objdb["zipcode"],
						$objdb["mainphone"],
						$objdb["directphone"],
						$objdb["cellphone"],
						$objdb["email"],
						$ID,
						$billtoid,
						$objdb["fax"],
						$in_loops,
						$loopurl
					);
				} else {
					viewbillTodisplay(
						$objdb["title"],
						$objdb["name"],
						$objdb["address"],
						$objdb["address2"],
						$objdb["city"],
						$objdb["state"],
						$objdb["zipcode"],
						$objdb["mainphone"],
						$objdb["directphone"],
						$objdb["cellphone"],
						$objdb["email"],
						$ID,
						$objdb["billtoid"],
						$objdb["fax"],
						$in_loops,
						$loopurl
					);
				}
			}
		} else {
			viewbillTodisplayedit("", "", "", "", "", "", "", "", "", "", "", $ID, 0, "", $in_loops, $loopurl);
		}
	}


	function viewbillTodisplayedit(string $title, string $name, string $address, string $address2, string $city, string $state, string $zip, string $mainphone, string $directphone, string $cellphone, string $email, int $ID, int $billtoid, string $fax, string $in_loops, string $loopurl): void
	{
	?>
		<form method="post" action="editTables.php" name="frmbilltoedit" id="frmbilltoedit" onSubmit="return formCheckInv_billto()">

			<table width="100%" border="0" cellspacing="1" cellpadding="1" height="211">

				<tr align="center">

					<td colspan="2" bgcolor="#C0CDDA" height="13">

						<font face="Arial, Helvetica, sans-serif" size="1">BILL TO<br/>
							(the person/organization to whom we will invoice)</font>
					</td>

				</tr>

				<tr bgcolor="#E4E4E4">
					<td height="10" width="40%"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Name </font>
					</td>
					<td align="left" width="60%" height="10"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
							<input name="billtoname" value="<?php echo $name ?>" size="20"></font>
					</td>
				</tr>

				<tr bgcolor="#E4E4E4">
					<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Title
						</font>
					</td>
					<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
							<input name="billtotitle" value="<?php echo $title ?>" size="20"></font>
					</td>
				</tr>

				<tr bgcolor="#E4E4E4">
					<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Address 1</font>
					</td>
					<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
							<input name="billtoAddress" value="<?php echo $address ?>" size="20"></font>
					</td>
				</tr>

				<tr bgcolor="#E4E4E4">
					<td height="19"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Address 2</font>
					</td>
					<td align="left" height="19"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
							<input name="billtoAddress2" value="<?php echo $address2 ?>" size="20"></font>
					</td>
				</tr>

				<tr bgcolor="#E4E4E4">
					<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">City</font>
					</td>
					<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
							<input name="billtoCity" value="<?php echo $city ?>" size="20"></font>
					</td>
				</tr>

				<tr bgcolor="#E4E4E4">
					<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">State/Province</font>
					</td>
					<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">

							<select name="billtoState">
								<option value=""></option>
								<?php
								$tableedit = "SELECT * FROM zones where zone_country_id in (223,38) ORDER BY zone_country_id, zone_code";
								db_b2b();
								$dt_view_res = db_query($tableedit);
								while ($row = array_shift($dt_view_res)) {
									?>
									<option
										<?php
										if ((trim($state) == trim($row["zone_code"])) || (trim($state) == trim($row["zone_name"]))) {
											echo " selected ";
										} ?>
										value="<?php echo trim($row["zone_code"]) ?>">
										<?php echo $row["zone_name"] ?>
										(<?php echo $row["zone_code"] ?>)
									</option>
								<?php } ?>
							</select>

					</td>
				</tr>

				<tr bgcolor="#E4E4E4">
					<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Zip</font></td>
					<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
							<input name="billtoZip" value="<?php echo $zip ?>" size="20"></font></td>
				</tr>

				<tr bgcolor="#E4E4E4">
					<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Phone</font></td>
					<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
							<input name="mainphone" value="<?php echo $mainphone ?>" size="20"></font></td>
				</tr>

				<tr bgcolor="#E4E4E4">
					<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Mobile No</font></td>
					<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
							<input name="cellphone" value="<?php echo $cellphone ?>" size="20"></font></td>
				</tr>

				<tr bgcolor="#E4E4E4">
					<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Email</font></td>
					<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
							<input name="billtoemail" value="<?php echo $email ?>" size="20"></font></td>
				</tr>

				<tr bgcolor="#E4E4E4">
					<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Fax</font></td>
					<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
							<input name="mainfax" value="<?php echo $fax ?>" size="20"></font></td>
				</tr>

				<tr bgcolor="#E4E4E4">
					<td colspan=2>
						<p align="center">&nbsp;<input align="center" type="submit" value="Save">
							<?php if ($in_loops == "yes") {
								$tmpstr = $loopurl;
								$tmpstr = str_replace("Edit_mode=billto_edit", "", $tmpstr); ?>
								<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">&nbsp;<a
											href="search_results.php?<?php echo $tmpstr ?>">nevermind</a></font>
							<?php } else { ?>
								<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">&nbsp;<a
											href="viewCompany.php?ID=<?php echo $ID ?>">nevermind</a></font>
							<?php } ?>

					</td>

				</tr>

			</table>

			<?php if ($in_loops == "yes") { ?>
				<input type="hidden" name="search_result_url" value="<?php echo $tmpstr ?>">
			<?php } else { ?>
				<input type="hidden" name="search_result_url" value="no">
			<?php } ?>

			<input type=hidden name="editTable" value="billto">

			<input type=hidden name="id" value="<?php echo $ID ?>">
			<input type=hidden name="billtoid" value="<?php echo $billtoid ?>">

		</form>

	<?php
	}





	function viewSellTo(int $ID, string $in_loops, string $loopurl): void
	{
		$qry = "SELECT * FROM b2bsellto WHERE companyid = " . $ID . " ORDER BY selltoid";
		db_b2b();
		$dt_view = db_query($qry);
		if (count($dt_view) > 0) {
			while ($objdb = array_shift($dt_view)) {
				viewSellTodisplay($objdb["title"], $objdb["name"], $objdb["address"], $objdb["address2"], $objdb["city"], $objdb["state"], $objdb["zipcode"], $objdb["mainphone"], $objdb["directphone"], $objdb["cellphone"], $objdb["email"], $ID, $objdb["selltoid"], $objdb["fax"], $in_loops, $loopurl);
				?>
				<br/>
				<?php
			}
			?>

			<?php
		} else {
			
		}
		?>
		<form method="POST" action="editTables.php?action=selltoadd" id="addsaletofrm" name="addsaletofrm">

			<?php if ($in_loops == "yes") { ?>
				<input type="hidden" name="companyid" value="<?php echo $ID ?>">
				<input type="hidden" name="search_result_url" value="<?php echo $loopurl ?>">
			<?php } else { ?>
				<input type="hidden" name="id" value="<?php echo $ID ?>">
				<input type="hidden" name="search_result_url" value="no">
			<?php } ?>
			<input type="submit" name="addsaleto" value="Add another SELL TO">
		</form>
		<?php
	}



	function viewSellTodisplay(string $title, string $name, string $address, string $address2, string $city, string $state, string $zip, string $mainphone, string $directphone, string $cellphone, string $email, int $ID, int $selltoid, string $fax, string $in_loops, string $loopurl): void
	{
		?>
		<table width="100%" border="0" cellspacing="1" cellpadding="1" height="211">

			<tr align="center">

				<td colspan="2" bgcolor="#C0CDDA" height="13">

					<font face="Arial, Helvetica, sans-serif" size="1">SELL TO<br/>
					(the person who is authorized and agrees to purchase)
					<?php if ($in_loops == "yes") { ?>
						<a href="search_results.php?<?php echo $loopurl ?>&Edit_mode=newsellto_edit&selltoid=<?php echo $selltoid ?>">
					<?php } else { ?>
						<a href="viewCompany.php?ID=<?php echo $ID ?>&Edit=3&selltoid=<?php echo $selltoid ?>">
					<?php }  ?>
					<img bgcolor="#C0CDDA"  src="images/edit.jpg"></a>
					&nbsp;
					<?php if ($in_loops == "yes") { ?>
						<a href="delete_sellto.php?<?php echo $loopurl ?>&selltoid=<?php echo $selltoid ?>" onclick="return confirm('Are you sure you want to delete this record?')">
					<?php } else { ?>
						<a href="delete_sellto.php?ID=<?php echo $ID ?>&selltoid=<?php echo $selltoid ?>" onclick="return confirm('Are you sure you want to delete this record?')">
					<?php }  ?>
					<img bgcolor="#C0CDDA"  src="images/del_img.png"></a>

					</font>

				</td>
			</tr>

			<tr bgcolor="#E4E4E4">
				<td height="10" width="40%"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Name</font></td>
				<td align="left" width="60%" height="10"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
				<?php echo $name ?></font></td>
			</tr>
			<tr bgcolor="#E4E4E4">
				<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Title </font></td>
				<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
				<?php echo $title ?></font></td>
			</tr>

			<tr bgcolor="#E4E4E4">
				<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Address 1</font></td>
				<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
				<?php echo $address ?></font></td>
			</tr>

			<tr bgcolor="#E4E4E4">
				<td height="19"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Address 2</font></td>
				<td align="left" height="19"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
				<?php echo $address2 ?></font></td>
			</tr>

			<tr bgcolor="#E4E4E4">
				<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">City</font></td>
				<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
				<?php echo $city ?></font></td>
			</tr>

			<tr bgcolor="#E4E4E4">
				<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">State/Province</font></td>
				<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
				<?php echo $state ?>
				</font></td>
			</tr>

			<tr bgcolor="#E4E4E4">
				<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Zip</font></td>
				<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
				<?php echo $zip ?></font></td>
			</tr>

			<tr bgcolor="#E4E4E4">
				<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
				Phone</font></td>
				<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
				<?php echo $mainphone ?></font></td>
			</tr>

			<tr bgcolor="#E4E4E4">
				<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
				Mobile No</font></td>
				<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
				<?php echo $cellphone ?></font></td>
			</tr>

			<tr bgcolor="#E4E4E4">
				<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
				Email</font></td>
				<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
				<?php echo $email ?></font></td>
			</tr>
			<tr bgcolor="#E4E4E4">
				<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
				Fax</font></td>
				<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
				<?php echo $fax ?></font></td>
			</tr>

		</table>

	   <?php
	}


	function viewSellToEdit(int $ID, int $selltoid, string $in_loops, string $loopurl): void
	{
		$qry = "SELECT * FROM b2bsellto WHERE companyid = " . $ID . " ORDER BY selltoid";
		db_b2b();
		$dt_view= db_query($qry);
		if (count($dt_view) > 0)
		{
			while ($objdb = array_shift($dt_view)) {
				if ($objdb["selltoid"] == $selltoid)
				{
					viewSellTodisplayedit($objdb["title"], $objdb["name"], $objdb["address"], $objdb["address2"], $objdb["city"], $objdb["state"], $objdb["zipcode"], $objdb["mainphone"], $objdb["directphone"], $objdb["cellphone"], $objdb["email"], $ID, $selltoid, $objdb["fax"], $in_loops, $loopurl);
				}
				else
				{
					viewSellTodisplay($objdb["title"], $objdb["name"], $objdb["address"], $objdb["address2"], $objdb["city"], $objdb["state"], $objdb["zipcode"], $objdb["mainphone"], $objdb["directphone"], $objdb["cellphone"], $objdb["email"], $ID, $objdb["selltoid"], $objdb["fax"], $in_loops, $loopurl);
				}
			}
		}
		else
		{
			viewSellTodisplayedit("", "", "", "", "", "", "", "", "", "", "", $ID, 0, "", $in_loops, $loopurl);
		}
	}



	function viewSellTodisplayedit(string $title, string $name, string $address, string $address2, string $city, string $state, string $zip, string $mainphone, string $directphone, string $cellphone, string $email, int $ID, int $selltoid, string $fax, string $in_loops, string $loopurl): void
	{
		?>
		<form method="post" action="editTables.php" name="frmselltoedit" id="frmselltoedit" onSubmit="return formCheckInv()">

			<table width="100%" border="0" cellspacing="1" cellpadding="1" height="211">

				<tr align="center">
					<td colspan="2" bgcolor="#C0CDDA" height="13">
						<font face="Arial, Helvetica, sans-serif" size="1">SELL TO<br/>
							(the person who is authorized and agrees to purchase)</font>
					</td>
				</tr>

				<tr bgcolor="#E4E4E4">
					<td height="10" width="40%"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Name </font></td>
					<td align="left" width="60%" height="10"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
							<input name="selltoname" value="<?php echo $name?>" size="20"></font></td>
				</tr>

				<tr bgcolor="#E4E4E4">
					<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Title</font></td>
					<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
							<input name="selltotitle" value="<?php echo $title?>" size="20"></font></td>
				</tr>

				<tr bgcolor="#E4E4E4">
					<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Address 1</font></td>
					<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
							<input name="selltoAddress" value="<?php echo $address?>" size="20"></font></td>
				</tr>

				<tr bgcolor="#E4E4E4">
					<td height="19"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Address 2</font></td>
					<td align="left" height="19"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
							<input name="selltoAddress2" value="<?php echo $address2?>" size="20"></font></td>
				</tr>

				<tr bgcolor="#E4E4E4">
					<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">City</font></td>
					<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
							<input name="selltoCity" value="<?php echo $city?>" size="20"></font></td>
				</tr>

				<tr bgcolor="#E4E4E4">
					<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">State/Province</font></td>
					<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
							<select name="selltoState">
								<option value=""></option>
								<?php
								$tableedit  = "SELECT * FROM zones where zone_country_id in (223,38) ORDER BY zone_country_id, zone_code";
								db_b2b();
								$dt_view_res = db_query($tableedit);

								while ($row = array_shift($dt_view_res)) {
								?>
									<option
										<?php if ((trim($state) == trim($row["zone_code"])) ||  (trim($state) == trim($row["zone_name"]))) echo " selected "; ?>
										value="<?php echo trim($row["zone_code"])?>">
										<?php echo $row["zone_name"]?> (<?php echo $row["zone_code"]?>)
									</option>
								<?php
								}
								?>
							</select>
						</font>
					</td>
				</tr>

				<tr bgcolor="#E4E4E4">
					<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Zip</font></td>
					<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
							<input name="selltoZip" value="<?php echo $zip?>" size="20"></font></td>
				</tr>

				<tr bgcolor="#E4E4E4">
					<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Phone</font></td>
					<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
							<input name="mainphone" value="<?php echo $mainphone?>" size="20"></font></td>
				</tr>

				<tr bgcolor="#E4E4E4">
					<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Mobile No</font></td>
					<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
							<input name="cellphone" value="<?php echo $cellphone?>" size="20"></font></td>
				</tr>

				<tr bgcolor="#E4E4E4">
					<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Email</font></td>
					<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
							<input name="selltoemail" value="<?php echo $email?>" size="20"></font></td>
				</tr>

				<tr bgcolor="#E4E4E4">
					<td height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Fax</font></td>
					<td align="left" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
							<input name="mainfax" value="<?php echo $fax?>" size="20"></font></td>
				</tr>

				<tr bgcolor="#E4E4E4">
					<td colspan="2">
						<p align="center">
							<input align="center" type="submit" value="Save">
							<?php if ($in_loops == "yes") {
								$tmpstr = $loopurl;
								$tmpstr = str_replace("Edit_mode=newsellto_edit", "", $tmpstr);?>
								<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
									&nbsp;<a href="search_results.php?<?php echo $tmpstr?>">nevermind</a>
								</font>
							<?php } else { ?>
								<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
									&nbsp;<a href="viewCompany.php?ID=<?php echo $ID?>">nevermind</a>
								</font>
							<?php } ?>
					</td>
				</tr>
			</table>

			<?php if ($in_loops == "yes") { ?>
				<input type="hidden" name="search_result_url" value="<?php echo $tmpstr?>">
			<?php } else { ?>
				<input type="hidden" name="search_result_url" value="no">
			<?php } ?>

			<input type="hidden" name="editTable" value="sellto">
			<input type="hidden" name="id" value="<?php echo $ID?>">
			<input type="hidden" name="selltoid" value="<?php echo $selltoid?>">
		</form>

		<?php
	}






	function viewGaylordInfo(
		string $shape,
		string $shape_rect,
		string $shape_oct,
		string $wall,
		string $wall_2,
		string $wall_3,
		string $wall_4,
		string $wall_5,
		string $thetop,
		string $top_nolid,
		string $top_partial,
		string $top_full,
		string $top_hinged,
		string $top_remove,
		string $bottom,
		string $bottom_no,
		string $bottom_partial,
		string $bottom_partialsheet,
		string $bottom_fullflap,
		string $bottom_interlocking,
		string $bottom_tray,
		string $vents,
		string $vents_no,
		string $vents_yes,
		string $box_pallet,
		string $box_condition,
		string $quantity,
		string $frequency,
		string $previous_contents,
		string $largest_qty,
		string $loading,
		string $price_beat,
		string $delivery_date,
		int $ID,
		string $in_loopflg
	): void {
		?>
		<table width="100%" border="0" cellspacing="1" cellpadding="1">
			<?php
			$aa = "SELECT * FROM boxesGaylord WHERE companyID = " . $ID;
			db_b2b();
			$dt_view_res = db_query($aa);
			$gb = array_shift($dt_view_res);
			$d = array();
			if ($gb["type"] == "spbox_not") {
				$d["shape_rect"] = "Shape-Rectangular";
				$d["shape_oct"] = "Shape-Octagonal";
				$d["wall_2"] = "2-Wall";
				$d["wall_3"] = "3-Wall";
				$d["wall_4"] = "4-Wall";
				$d["wall_5"] = "5-Wall";
				$d["top_nolid"] = "No Lid";
				$d["top_partial"] = "Partial Lid";
				$d["top_full"] = "Full Lid";
				$d["top_hinged"] = "Hinged Lid";
				$d["top_remove"] = "Removable Lid";
				$d["bottom_no"] = "No Bottom";
				$d["bottom_partial"] = "Partial Bottom";
				$d["bottom_partialsheet"] = "Bottom with Slipsheet";
				$d["bottom_fullflap"] = "Full Flap Bottom";
				$d["bottom_interlocking"] = "Interlocking Bottom";
				$d["bottom_tray"] = "Tray Bottom";
				$d["vents_no"] = "No Vents";
				$d["vents_yes"] = "Yes Vents";
				$d["box_pallet"] = "Yes Pallets";
				$d["box_condition"] = "Use of Boxes";
				$d["quantity"] = "Quantity";
				$d["frequency"] = "Frequency";
				$d["largest_qty"] = "Holding Quantity";
				$d["price_beat"] = "Price to Beat";
				$d["delivery_date"] = "Delivery Date";
			}
			if ($gb["type"] == "box_cml") {
				$d["shape"] = "Entered Shape";
				$d["wall"] = "Entered Wall";
				$d["thetop"] = "Entered Top";
				$d["bottom"] = "Entered Bottom";
				$d["vents"] = "Entered Vents";
				$d["box_condition"] = "Condition";
				$d["quantity"] = "Quantity";
				$d["frequency"] = "Frequency";
				$d["previous_contents"] = "Previous Contents";
				$d["largest_qty"] = "Holding Quantity";
				$d["loading"] = "Loading Dock";
				$d["price_beat"] = "Price to Beat";
				$d["delivery_date"] = "Delivery Date";
			}
			?>
			<tr align="center">
				<td colspan="2" bgcolor="#C0CDDA">
					<font face="Arial, Helvetica, sans-serif" size="1">GAYLORD BOX INFORMATION
						<?php if ($in_loopflg == "yes") { ?>
							<a href="search_results.php?warehouse_id=<?echo $_GET["warehouse_id"];?>&rec_type=<?echo $_GET["rec_type"];?>&proc=<?echo $_GET["proc"];?>&searchcrit=<?echo $_GET["searchcrit"];?>&id=<?echo $_GET["id"];?>&rec_id=<?echo $_GET["rec_id"];?>&display=<?echo $_GET["display"];?>&bid=<?php echo $gb["ID"]?>&Edit=50&display_b2b=quote">
								<img bgcolor="#C0CDDA"  src="images/edit.jpg">
							</a>
						<?php } else { ?>
							<a href="viewCompany.php?ID=<?php echo $ID?>&bid=<?php echo $gb["ID"]?>&Edit=50">
								<img bgcolor="#C0CDDA"  src="images/edit.jpg">
							</a>
						<?php } ?>
					</font>
				</td>
			</tr>
			<?php
			foreach ($d as $key => $value) {
				?>
				<tr bgcolor="#E4E4E4">
					<td><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $value?></font></td>
					<td width="30%">
						<font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php
							if ($gb[$key] == "1" )
								echo "Yes";
							elseif ($gb[$key] == "0")
								echo "No";
							else
								echo $gb[$key];
						?></font>
					</td>
				</tr>
				<?php
			}
			?>
		</table>
		<?php
	}
	


	function viewGaylordEdit(
		string $shape,
		string $shape_rect,
		string $shape_oct,
		string $wall,
		string $wall_2,
		string $wall_3,
		string $wall_4,
		string $wall_5,
		string $thetop,
		string $top_nolid,
		string $top_partial,
		string $top_full,
		string $top_hinged,
		string $top_remove,
		string $bottom,
		string $bottom_no,
		string $bottom_partial,
		string $bottom_partialsheet,
		string $bottom_fullflap,
		string $bottom_interlocking,
		string $bottom_tray,
		string $vents,
		string $vents_no,
		string $vents_yes,
		string $box_pallet,
		string $box_condition,
		string $quantity,
		string $frequency,
		string $previous_contents,
		string $largest_qty,
		string $loading,
		string $price_beat,
		string $delivery_date,
		int $ID
	): void {
		$aa = "SELECT * FROM boxesGaylord WHERE companyID = " . $ID;
		db_b2b();
		$dt_view_res = db_query($aa);
		$gb = array_shift($dt_view_res);
		$d = array();
		if ($gb["type"] == "spbox_not") {
			?>
			<table width="100%" border="0" cellspacing="1" cellpadding="1">
				<form method="post" action="editTables.php">
					<tr align="center">
						<td colspan="2" bgcolor="#C0CDDA" height="13">
							<font face="Arial, Helvetica, sans-serif" size="1" color="#333333">GAYLORD BOX DETAILS - Buying</font>
						</td>
					</tr>
					<?php
					$b["box_condition"] = "Use of Boxes";
					$b["quantity"] = "Quantity";
					$b["frequency"] = "Frequency";
					$b["largest_qty"] = "Holding Quantity";
					$b["loading"] = "Loading Dock";
					$b["price_beat"] = "Price To Beat";
					$b["delivery_date"] = "Delivery Date";

					foreach ($b as $key => $value) {
						?>
						<tr bgcolor="#E4E4E4">
							<td><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $value?></font></td>
							<td width="30%"><input type="text" name="<?php echo $key?>" value="<?php echo $gb[$key]?>"></td>
						</tr>
						<?php
					}
					?>
					<?php
					$d["shape_rect"] = "Shape-Rectangular";
					$d["shape_oct"] = "Shape-Octagonal";
					$d["wall_2"] = "2-Wall";
					$d["wall_3"] = "3-Wall";
					$d["wall_4"] = "4-Wall";
					$d["wall_5"] = "5-Wall";
					$d["top_nolid"] = "No Lid";
					$d["top_partial"] = "Partial Lid";
					$d["top_full"] = "Full Lid";
					$d["top_hinged"] = "Hinged Lid";
					$d["top_remove"] = "Removable Lid";
					$d["bottom_no"] = "No Bottom";
					$d["bottom_partial"] = "Partial Bottom";
					$d["bottom_partialsheet"] = "Bottom with Slipsheet";
					$d["bottom_fullflap"] = "Full Flap Bottom";
					$d["bottom_interlocking"] = "Interlocking Bottom";
					$d["bottom_tray"] = "Tray Bottom";
					$d["vents_no"] = "No Vents";
					$d["vents_yes"] = "Yes Vents";
					$d["box_pallet"] = "Yes Pallets";
					foreach ($d as $key => $value) {
						?>
						<tr bgcolor="#E4E4E4">
							<td><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $value?></font></td>
							<td width="30%"><input type="checkbox" name="<?php echo $key?>" <?php if ($gb[$key] == "1" ) echo "CHECKED"; ?> ></td>
						</tr>
						<?php
					}
					?>
					<input type=hidden name="editTable" value="boxesGaylord">
					<input type=hidden name="id" value="<?php echo $ID?>">
					<input type=hidden name="bid" value="<?php echo $_REQUEST["bid"]?>">
					<tr bgcolor="#E4E4E4">
						<td width="100%" colspan="2" align="center"><input type="submit" value="Submit" name="B1"></td>
					</tr>
				</form>
			</table>
			<?php
		}
		?>
		<?php
		if ($gb["type"] == "box_cml") {
		?>
			<table width="100%" border="0" cellspacing="1" cellpadding="1">
				<form method="post" action="editTables.php">
					<tr align="center">
						<td colspan="2" bgcolor="#C0CDDA" height="13"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">GAYLORD BOX DETAILS - Selling</font>
						</td>
					</tr>
					<?php
					$d["shape"] = "Entered Shape";
					$d["wall"] = "Entered Wall";
					$d["thetop"] = "Entered Top";
					$d["bottom"] = "Entered Bottom";
					$d["vents"] = "Entered Vents";
					$d["box_condition"] = "Condition";
					$d["quantity"] = "Frequency";
					$d["frequency"] = "Entered Vents";
					$d["previous_contents"] = "Previous Contents";
					$d["largest_qty"] = "Holding Quantity";
					$d["loading"] = "Loading Dock";
					$d["price_beat"] = "Price to Beat";
					$d["delivery_date"] = "Delivery Date";

					foreach ($d as $key => $value) {
						?>
						<tr bgcolor="#E4E4E4">
							<td><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $value?></font>
							</td>
							<td width="30%"><input type="text" name="<?php echo $key?>" value="<?php echo $gb[$key]?>"></td>
						</tr>
						<?php
					}
					?>
					<input type=hidden name="editTable" value="boxesGaylord">
					<input type=hidden name="id" value="<?php echo $ID?>">
					<tr bgcolor="#E4E4E4">
						<td width="100%" colspan="2" align="center"><input type="submit" value="Submit" name="B1"></td>
					</tr>
				</form>
			</table>
		<?php
		}
	}
	




	function viewBoxRequest($box1,$box2,$box3,$box4,$q1,$q2,$q3,$q4,$q5,$q6,$q7,$q8,$q9,$q10,$notes,$ID)


	{

		//dim strQuery, rsD, d, ak, ai, rsDP
		db_b2b();
		$strQuery = db_query("SELECT * FROM companyInfo WHERE ID ='$ID'");

		$rsd=array_shift($strQuery)

		?>
		<table width="100%" border="0" cellspacing="1" cellpadding="1">
			<?php
			if ($rsd['req_type'] == "box_cml")
			{
				db_b2b();
				$strquery=db_query("SELECT * FROM boxesForPickup WHERE companyID =''$ID'");
				while($redp=array_shift($strquery))
				{
					$z = array();
					//strQuery = "SELECT * FROM boxesForPickup WHERE companyID = " & ID
					//Set rsDP = objConn.Execute(strQuery)
					//Set d=Server.CreateObject("Scripting.Dictionary")
					$z['gbox']="Gaylord Boxes";
					$z['if_gaylords']="If Gaylords";
					$z['no_of_rescue']="Estimated total number of boxes in this rescue";
					$z['list_dimensions']="I can’t list the dimensions, the boxes are all different";
					$z['length_lside']="Length (longest side)";
					$z['widthInch']="Width (shortest side)";
					$z['depthInch']="Depth (height excluding flaps)";
					$z['thick']="Wall Thickness";
					$z['color']="Color";
					$z['printing']="Printing";
					$z['labels']="Mailing Labels";
					$z['comments']="Comments";
					$z['box_condition']="Condition";
					$z['priceGetting']="Price Getting";
					$z['req_another_box']="Request another box";

				}

				?>

					<tr align="center">
						<td colspan="2" bgcolor="#C0CDDA"><font face="Arial, Helvetica, sans-serif" size="1">BOX REQUEST INFORMATION <a href="viewCompany.php?ID=<?php echo $ID;?>&bid=<?php echo $redp['ID']; ?>&Edit=3"><img bgcolor="#C0CDDA"  src="images/edit.jpg"></a></font></td>
					</tr>


				<form method="post" action="editTables.php">
					<?php
						foreach ($z as $key => $value) 
						{
							?>

							<tr bgcolor="#E4E4E4">
								<td><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $value; ?></font></td>
								<td width="30%"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $key; ?></font></td>
							</tr>

								<?php
						}
					?>
				</form>
				<?php

			} 
			else if ($rsd['req_type']=="spbox_not")
			{
			db_b2b();
			$strQuery=db_query("SELECT * FROM boxesrequested WHERE companyID = '$ID'");
			while($rsdp=array_shift($strQuery))
			{
				$z = array();
				//strQuery = "SELECT * FROM boxesrequested WHERE companyID = '" & ID & "'"
				//Set rsDP = objConn.Execute(strQuery)
				//Set d=Server.CreateObject("Scripting.Dictionary");
				$z['preferred_delivery_date']="Preferred Delivery Date";
				$z['receiving_dock_info']="Receiving Dock Info";
				$z['receiving_dock_info_other']="Receiving Dock Info Other";
				$z['gbox']="I need gaylord boxes (pallet boxes measuring approximately 42 x 48 x 36)";
				$z['if_gaylords']="If Gaylords";
				$z['cubic_order']="Specify Dimensions";
				$z['cubicFeet']="Approx. cubic feet";
				$z['lengthInch']="Length (longest side)";
				$z['lengthFraction']="Can be";
				$z['widthInch']="Width (shortest side)";
				$z['widthFraction']="Can be";
				$z['depthInch']="Depth (height excluding flaps)";
				$z['depthFraction']="Can be";
				$z['wall_thickness']="Wall thickness";
				$z['color']="Color";
				$z['printing']="Printing";
				$z['unc_printing']="Unnacceptable printing";
				$z['dimension_stamp']="Dimension Stamp";
				$z['qty_for_box']="Quantity for this box";
				$z['qty_for_month']="Quanitity used each month";
				$z['recurring']="Recurring";
				$z['price']="Price currently paid (help us be competitive)";
				$z['current_vendor']="Current Vendor";
				$z['what_this_box_used_for']="What this box is used for";
				$z['comments']="Comments";
				$z['req_another_box']="Request another box";

			}

			?>
			<tr align="center">
				<td colspan="2" bgcolor="#C0CDDA"><font face="Arial, Helvetica, sans-serif" size="1">BOX REQUEST</font><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">INFORMATION <a href="viewCompany.php?ID=<?php echo $ID; ?>&bid=<?php echo $redp['ID']; ?>&Edit=3"><img bgcolor="#C0CDDA"  src="images/edit.jpg"></a></font></td>
			</tr>
			<form method="post" action="editTables.php">
				<?php
					foreach ($z as $key => $value)
					{
							?>
						<tr bgcolor="#E4E4E4">
							<td><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $value;?></font>
							</td>
							<td width="30%"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $key; ?></font>
							</td>
						</tr>
						<?php
					}

				?>
			</form>
			<tr align="center">
				<td colspan="2" bgcolor="#C0CDDA"><font face="Arial, Helvetica, sans-serif" size="1">BOX REQUEST INFORMATION</font> <a href="viewCompany.asp?ID=<%=ID%>&Edit=3"><img bgcolor="#C0CDDA"  src="images/edit.jpg"></a>
				</td>
			</tr>
			<?php

			db_b2b();
			$X=db_query("Select * From boxesrequested Where CompanyID = '$ID'");
			while($fetchboxes=array_shift($X))
			{
				?>
				<tr bgcolor="#E4E4E4">
					<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><a href="editBoxesRequested.php?ID=
					<?php echo $fetchboxes['ID']; ?>"><?php echo $fetchboxes['ID']; ?></a></font>
					</td>
					<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
						<?php
								echo $fetchboxes['lengthInch']." ".$fetchboxes['lengthFraction']. "x";
								echo $fetchboxes['widthInch']." ".$fetchboxes['widthFraction']. "x";
								echo $fetchboxes['depthInch']." ".$fetchboxes['depthFraction']. "x";
								echo "(" . $fetchboxes['cubicFeet']." cf) ";
								echo $fetchboxes['newUsed']." " . $fetchboxes['printing'] . " " . $fetchboxes['labels']." ".$fetchboxes['writing']." ". 	        $fetchboxes['burst'];
								echo "<br>U-line: " . $fetchboxes['ulineDollar'].$fetchboxes['ulineCents'];
								echo " Cost: " .$fetchboxes['costDollar'].$fetchboxes['costCents'];
								echo " Quantity: ".$fetchboxes['quantity'];
								echo "<BR>".$fetchboxes['description'];



						?>
					</font>
					</td>
				</tr>
				<?php
			}
			?>


			<tr bgcolor="#E4E4E4">
				<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Box #1</font>
				</td>
				<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
				<?php
				if ($box1[0] <> 0)
				{
					echo $box1[0];
					if ($box1[1] <> 0)
					{
						echo " " . $box1[1]. "/" . $box1[2] . " x ";
					}
					else
					{
						echo " x ";

					}

					echo $box1[3];
					if ($box1[4] <> 0)
					{
						echo " " & $box1[4]. "/" . $box1[5] . " x ";
					}
					else
					{
						echo " x ";
					}
					echo $box1[6];
					if ($box1[7] <> 0)
					{
						echo " " . $box1[7] . "/" . $box1[8] . " (";
					}
					else
					{
						echo " (";
					}

					if ($box1[2] == 0)
					{
						$box1[2] = 1;
					}

					if ($box1[5] == 0)
					{
						$box1[5] = 1;
					}

					if ($box1[8] == 0)
					{
						$box1[8] = 1;

					}

					/*echo round(($box1[0] + $box1[1] /$box1[2]) * ($box1[3] + $box1[4] / $box1[5]) * ($box1[6] + $box1[7] / $box1[8] / 1728,2);
					echo $box1[9] . " " . $box1[10] . " " . $box1[11] . " " . $box1[12];*/


				}

				?></font>
				</td>
			</tr>
			<tr bgcolor="#E4E4E4">
			<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Box #2</font>
			</td>
				<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
					<?php
					if ($box2[0] <> 0)
					{
						echo $box2[0];
						if ($box2[1] <> 0)
						{
							echo " " . $box2[1] . "/" .$box2[2] . " x ";
						}
						else
						{
							echo " x ";
						}

						echo $box2[3];
						if ($box2[4] <> 0)
						{
							echo " " . $box2[4] . "/" . $box2[5] . " x ";
						}
						else
						{
							echo " x ";
						}
						echo $box2[6];
						if ($box2[7] <> 0){
							echo " " . $box2[7] . "/" . $box2[8] . " (";
						}
						else
						{
							echo " (";
						}

						if ($box2[2] == 0)
						{
							$box2[2] = 1;
						}

						if ($box2[5] == 0)
						{
							$box2[5] = 1;
						}

						if ($box2[8] == 0)
						{
							$box2[8] = 1;
						}
						echo round(($box2[0] + $box2[1] / $box2[2]) * ($box2[3] + $box2[4] / $box2[5]) * ($box2[6] + $box2[7] / $box2[8]) / 1728, 2). "cf) ";
						echo $box2[9] . " " . $box2[10] . " " . $box2[11] . " " . $box2[12];

					}
					?>

					</font>
				</td>
			</tr>
			<tr bgcolor="#E4E4E4">
				<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Box #3</font>
				</td>
				<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
				<?php
				if ($box3[0] <> 0)
				{
					echo $box3[0];
					if ($box3[1] <> 0)
					{
						echo " " . $box3[1] . "/" . $box3[2] . " x ";
					}
					else
					{
						echo " x ";
					}
					echo $box3[3];
					if ($box3[4] <> 0)
					{
						echo " " . $box3[4] . "/" . $box3[5] . " x ";
					}
					else
					{
						echo " x ";
					}
					echo $box3[6];
					if ($box3[7] <> 0)
					{
						echo " " . $box3[7] . "/" . $box3[8] & " x ";
					}
					else
					{
						echo " x ";
					}

					if($box3[2] == 0)
					{
						$box3[2] = 1;
					}

					if ($box3[5] == 0)
					{
						$box3[5] = 1;
					}

					if ($box3[8] == 0)
					{
						$box3[8] = 1;
					}
					echo round(($box3[0] + $box3[1] / $box3[2]) * ($box3[3] + $box3[4] / $box3[5]) * ($box3[6] + $box3[7] / $box3[8]) / 1728, 2). "cf) ";
					echo $box3[9] . " " . $box3[10] . " " . $box3[11] . " " . $box3[12];

				}
				?></font>
				</td>
			</tr>
			<tr bgcolor="#E4E4E4">
				<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Box #4</font>
				</td>
				<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
				<?php
				if ($box4[0] <> 0)
				{
					echo $box4[0];

					if ($box4[1] <> 0)
					{
						echo " " . $box4[1] . "/" . $box4[2] . " x ";
					}
					else
					{
						echo " x ";
					}
					echo $box4[3];
					if ($box4[4] <> 0)
					{
						echo " " . $box4[4] . "/" . $box4[5] . " x ";
					}
					else
					{
						echo " x ";
					}
					echo $box4[6];
					if ($box4[7] <> 0)
					{
						echo " " . $box4[7] . "/" . $box4[8] . " x (";
					}
					else
					{
						echo " x (";
					}

					if ($box4[2] == 0)
					{
						$box4[2] = 1;
					}

					if ($box4[5] == 0)
					{
						$box4[5] = 1;
					}

					if ($box4[8] = 0 )
					{
						$box4[8] = 1;
					}

					echo round(($box4[0] + $box4[1] / $box4[2]) * ($box4[3] + $box4[4] / $box4[5]) * ($box4[6] + $box4[7] / $box4(8)) / 1728, 2). "cf) ";
					echo $box4[9] . " " . $box4[10] . " " . $box4[11] . " " . $box4[12];
				}


				?></font>
				</td>
			</tr>
			<tr bgcolor="#E4E4E4">
				<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">How will the boxes be
				used?</font>
				</td>
				<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
				<?php echo $q1; ?></font>
				</td>
			</tr>
			<tr bgcolor="#E4E4E4">
			<td width="160"><font face="Arial, Helvetica, sans-serif" size="1">When do you
			need the boxes?</font>
			</td>
			<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
			<?php echo $q2; ?></font></td>
			</tr>
			<tr bgcolor="#E4E4E4">
			<td width="160"><font face="Arial, Helvetica, sans-serif" size="1">Delivered or
			pickup?</font></td>
			<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
			<?php echo $q3; ?></font></td>
			</tr>
			<tr bgcolor="#E4E4E4">
			<td width="160"><font face="Arial, Helvetica, sans-serif" size="1">Can boxes be
			larger?</font></td>
			<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
			<?php echo $q4; ?></font></td>
			</tr>
			<tr bgcolor="#E4E4E4">
			<td width="160"><font face="Arial, Helvetica, sans-serif" size="1">Can boxes be
			smaller?</font></td>
			<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
			<?php echo $q5; ?></font></td>
			</tr>
			<tr>
			<td bgcolor="#E4E4E4" width="160">
			<font face="Arial, Helvetica, sans-serif" size="1">Can there be markings?</font></td>
			<td bgcolor="#E4E4E4" align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
			<?php echo $q6; ?></font></td>
			</tr>
			<tr>
			<td bgcolor="#E4E4E4" width="160">
			<font face="Arial, Helvetica, sans-serif" size="1">Can the boxes have other
			names?</font></td>
			<td bgcolor="#E4E4E4" align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
			<?php echo $q7; ?></font></td>
			</tr>
			<tr>
			<td bgcolor="#E4E4E4" width="160">
			<font face="Arial, Helvetica, sans-serif" size="1">Can the boxes have labels or stickers?</font></td>
			<td bgcolor="#E4E4E4" align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
			<?php echo $q8; ?></font></td>
			</tr>
			<tr>
			<td bgcolor="#E4E4E4" width="160">
			<font face="Arial, Helvetica, sans-serif" size="1">Pricing for new or used
			boxes?</font></td>
			<td bgcolor="#E4E4E4" align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
			<?php echo $q9; ?></font></td>
			</tr>
			<tr>
			<td bgcolor="#E4E4E4" width="160">
			<font face="Arial, Helvetica, sans-serif" size="1">One time or recurring order?</font></td>
			<td bgcolor="#E4E4E4" align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
			<?php echo $q10; ?></font></td>
			</tr>
			<tr>
			<td bgcolor="#E4E4E4" width="160">
			<font face="Arial, Helvetica, sans-serif" size="1">Notes</font></td>
			<td bgcolor="#E4E4E4" align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
			<?php echo $notes; ?></font></td>
			</tr>
		</table>
		<?php
		}
	}




	function newViewBoxRequest(int $ID): void
	{
		?>
		<table>
			<tr align="center">
				<td colspan="2" bgcolor="#C0CDDA"><font face="Arial, Helvetica, sans-serif" size="1">BOX REQUEST INFORMATION</font> &nbsp;
				<font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><a href="boxesrequested_edit.php?addnew=yes&companyID=<?php echo $ID; ?>">Add New</a></font></td>
			</tr>
			<?php
			$q="Select * From boxesrequested Where companyID = '".$ID."'";
			db_b2b();
			$X=db_query($q);
			while($fetchboxes=array_shift($X))
			{
				?>
					<tr bgcolor="#E4E4E4">
						<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
						<?php
								echo $fetchboxes['lengthInch']." ".$fetchboxes['lengthFraction']. " x ";
								echo $fetchboxes['widthInch']." ".$fetchboxes['widthFraction']. " x ";
								echo $fetchboxes['depthInch']." ".$fetchboxes['depthFraction'] . "&nbsp;&nbsp;";
								echo "<a href='boxesrequested_edit.php?companyID=" . $ID . "&ID=" . $fetchboxes['ID'] . "'><img bgcolor='#C0CDDA'  src='images/edit.jpg'></a> <br/>";
								echo $fetchboxes['thick']."<br>";
								echo "Quantity: ".$fetchboxes['quantity'];
								echo "<BR>".$fetchboxes['recurring'];
								echo "<BR>Delivery Date: ".$fetchboxes['preferred_delivery_date'];

						?>
						</font>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				<?php
			}
			?>
		</table>

		<?php

	}


	function viewRescue(int $ID): void
	{
		?>
		<table>
			<tr align="center">
				<td colspan="2" bgcolor="#C0CDDA"><font face="Arial, Helvetica, sans-serif" size="1">BOX RESCUE INFORMATION</font> </td>
			</tr>
			<?php
			$q="Select * From boxesForPickup Where companyID = '".$ID."'";
			db_b2b();
			$X=db_query($q);
			while($fetchboxes=array_shift($X))
			{
				if ($fetchboxes["gbox"] == 'Y')
				{
					?>
					<tr bgcolor="#E4E4E4">
					<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Type</font></td>
					<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Gaylord Boxes</font></td>
					</tr>
					<tr bgcolor="#E4E4E4">
					<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Shape</font></td>
					<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $fetchboxes["shape"];?></font></td>
					</tr>
					<tr bgcolor="#E4E4E4">
					<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Top</font></td>
					<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $fetchboxes["top"];?></font></td>
					</tr>
					<tr bgcolor="#E4E4E4">
					<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Bottom</font></td>
					<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $fetchboxes["bottom"];?></font></td>
					</tr>
					<tr bgcolor="#E4E4E4">
					<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Vents</font></td>
					<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $fetchboxes["vents"];?></font></td>
					</tr>
					<tr bgcolor="#E4E4E4">
					<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Wall</font></td>
					<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $fetchboxes["thick"];?></font></td>
					</tr>
					<tr bgcolor="#E4E4E4">
					<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Contents</font></td>
					<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $fetchboxes["previous_contents"];?></font></td>
					</tr>
					<tr bgcolor="#E4E4E4">
					<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Condition</font></td>
					<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $fetchboxes["box_condition"];?></font></td>
					</tr>
					<tr bgcolor="#E4E4E4">
					<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Frequency</font></td>
					<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $fetchboxes["frequency"];?></font></td>
					</tr>
					<tr bgcolor="#E4E4E4">
					<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Quantity</font></td>
					<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $fetchboxes["no_of_rescue"];?></font></td>
					</tr>
					<?php
				} else 
				{
					?>
					<tr bgcolor="#E4E4E4">
					<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Type</font></td>
					<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Shipping Boxes</font></td>
					</tr>
					<tr bgcolor="#E4E4E4">
					<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Dimensions</font></td>
					<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $fetchboxes["length_lside"] . " x " . $fetchboxes["widthInch"] . " x " . $fetchboxes["depthInch"];?></font></td>
					</tr>
					<tr bgcolor="#E4E4E4">
					<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Wall</font></td>
					<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $fetchboxes["thick"];?></font></td>
					</tr>
					<tr bgcolor="#E4E4E4">
					<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">New/Used</font></td>
					<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $fetchboxes["box_condition"];?></font></td>
					</tr>
					<tr bgcolor="#E4E4E4">
					<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Multiple Boxes</font></td>
					<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php if ($fetchboxes["req_another_box"]==1) {echo "Y";} else {echo "N";}?></font></td>
					</tr>
					<tr bgcolor="#E4E4E4">
					<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Frequency</font></td>
					<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $fetchboxes["frequency"];?></font></td>
					</tr>
					<tr bgcolor="#E4E4E4">
					<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Quantity</font></td>
					<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $fetchboxes["no_of_rescue"];?></font></td>
					</tr>
					<?php
				}
			}
			?>
		</table>

		<?php

	}



	function newviewRescue(int $ID): void
	{
		?>
		<table>
		<tr align="center">
			<td colspan="2" bgcolor="#C0CDDA"><font face="Arial, Helvetica, sans-serif" size="1">BOX RESCUE INFORMATION</font> &nbsp;
			<font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><a href="boxesrescue_edit.php?addnew=yes&companyID=<?php echo $ID; ?>">Add New</a></font></td>
		</tr>
		<?php
		$q="Select * From boxesForPickup Where companyID = $ID";
		db_b2b();
		$X=db_query($q);
		while($fetchboxes=array_shift($X))
		{
			if ($fetchboxes["gbox"] == 'Y')
			{
				?>

				<tr bgcolor="#E4E4E4">
				<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Type</font></td>
				<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Gaylord Boxes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "<a href='boxesrescue_edit.php?companyID=" . $ID . "&ID=" . $fetchboxes['ID'] . "'><img bgcolor='#C0CDDA'  src='images/edit.jpg'></a>";?></font></td>
				</tr>
				<tr bgcolor="#E4E4E4">
				<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Shape</font></td>
				<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $fetchboxes["shape"];?></font></td>
				</tr>
				<tr bgcolor="#E4E4E4">
				<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Top</font></td>
				<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $fetchboxes["top"];?></font></td>
				</tr>
				<tr bgcolor="#E4E4E4">
				<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Bottom</font></td>
				<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $fetchboxes["bottom"];?></font></td>
				</tr>
				<tr bgcolor="#E4E4E4">
				<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Vents</font></td>
				<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $fetchboxes["vents"];?></font></td>
				</tr>
				<tr bgcolor="#E4E4E4">
				<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Wall</font></td>
				<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $fetchboxes["thick"];?></font></td>
				</tr>
				<tr bgcolor="#E4E4E4">
				<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Contents</font></td>
				<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $fetchboxes["previous_contents"];?></font></td>
				</tr>
				<tr bgcolor="#E4E4E4">
				<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Condition</font></td>
				<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $fetchboxes["box_condition"];?></font></td>
				</tr>
				<tr bgcolor="#E4E4E4">
				<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Frequency</font></td>
				<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $fetchboxes["frequency"];?></font></td>
				</tr>
				<tr bgcolor="#E4E4E4">
				<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Quantity</font></td>
				<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $fetchboxes["no_of_rescue"];?></font></td>
				</tr>
				<?php
			} else
			{
				?>
				<tr bgcolor="#E4E4E4">
				<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Type</font></td>
				<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Shipping Boxes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "<a href='boxesrescue_edit.php?companyID=" . $ID . "&ID=" . $fetchboxes['ID'] . "'><img bgcolor='#C0CDDA'  src='images/edit.jpg'></a>";?></font></td>
				</tr>
				<tr bgcolor="#E4E4E4">
				<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Dimensions</font></td>
				<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $fetchboxes["length_lside"] . " x " . $fetchboxes["widthInch"] . " x " . $fetchboxes["depthInch"];?></font></td>
				</tr>
				<tr bgcolor="#E4E4E4">
				<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Wall</font></td>
				<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $fetchboxes["thick"];?></font></td>
				</tr>
				<tr bgcolor="#E4E4E4">
				<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">New/Used</font></td>
				<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $fetchboxes["box_condition"];?></font></td>
				</tr>
				<tr bgcolor="#E4E4E4">
				<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Multiple Boxes</font></td>
				<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php if ($fetchboxes["req_another_box"]==1) {echo "Y";} else {echo "N";}?></font></td>
				</tr>
				<tr bgcolor="#E4E4E4">
				<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Frequency</font></td>
				<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $fetchboxes["frequency"];?></font></td>
				</tr>
				<tr bgcolor="#E4E4E4">
				<td width="160"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Quantity</font></td>
				<td align="left" width="376"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $fetchboxes["no_of_rescue"];?></font></td>
				</tr>
				<?php
			} 
			?>

			<tr><td colspan='2'>&nbsp;</td></tr>
		<?php 
		}
		?>
		</table>

		<?php

	}

	function clientdashboard(int $ID): void
	{
		?>
		<table border="0" bgcolor="#F6F8E5" style="font-family:Arial, Helvetica, sans-serif; font-size:10;">
			<tr align="center">
				<td colspan="5" width="320px" bgcolor="#E8EEA8"><strong>Customer Dashboard Setup</strong></font></td>
			</tr>
			<form method="post" name="clientdash_adduser" action="clientdashboard_adduser.php">
				<input type="hidden" name="hidden_companyid" value="<?php echo $ID; ?>" />

				<tr align="center">
					<td colspan="5" width="320px" align="left" bgcolor="#C1C1C1">Add new user for Customer</td>
				</tr>
				<tr align="center">
					<td width="80px" >User name: </td>
					<td colspan="4" width="320px" align="left"><input type="text" name="clientdash_username" id="clientdash_username" value="" /></td>
				</tr>
				<tr align="center">
					<td width="80px" >Password: </td>
					<td colspan="4" width="320px" align="left"><input type="password" name="clientdash_pwd" id="clientdash_pwd" value="" /></td>
				</tr>
				<tr align="center">
					<td width="80px" >&nbsp;</td>
					<td colspan="4" width="320px" align="left"><input type="button" name="clientdash_adduser" value="Add" onclick="clientdash_chkfrm()" /></td>
				</tr>
			</form>

			<form method="post" name="clientdash_edituser" action="clientdashboard_edituser.php">
			<tr align="center">
				<td colspan="5" width="320px" align="left" bgcolor="#C1C1C1">Customer user list</td>
			</tr>
			<tr align="center">
				<td width="80px" >User name</td>
				<td width="80px" align="left">Password</td>
				<td width="100px" align="left">Activate/Deactivate</td>
				<td width="40px" align="left">Edit</td>
				<td width="100px" align="left">Delete</td>
			</tr>
			<?php
			$qry ="Select * From clientdashboard_usermaster Where companyid = $ID";
			db();
			$res = db_query($qry);
			while($fetch_data=array_shift($res))
			{
			?>
				<input type="hidden" name="loginid" id="loginid" value="<?php echo $fetch_data["loginid"]; ?>" />
				<tr align="center">
					<td width="80px" ><input type="text" name="clientdash_username_edit" id="clientdash_username_edit" value="<?php echo $fetch_data["user_name"];?>" /></td>
					<td width="80px" align="left"><input type="password" name="clientdash_pwd_edit" id="clientdash_pwd_edit" value="<?php echo $fetch_data["password"];?>" /></td>
					<td width="100px" align="left"><input type="checkbox" name="clientdash_flg" id="clientdash_flg" <?php if ($fetch_data["activate_deactivate"] == 1) { echo " checked "; }?> /></td>
					<td width="40px" align="left"><input type="button" value="Update" onclick="clientdash_edit()" /></td>
					<td width="100px" align="left"><input type="button" value="Delete" onclick="clientdash_dele(<?php echo $fetch_data["loginid"];?>, <?php echo $ID;?>)" /></td>
				</tr>
			<?php
			}
			?>
			</form>

			<tr align="center">
				<td colspan="5" width="320px" align="left" >&nbsp;</td>
			</tr>
			<form method="post" name="clientdash_edituser_sec" action="clientdashboard_edit_sec.php">
			<tr align="center">
				<td colspan="5" width="320px" align="left" bgcolor="#C1C1C1">Section list</td>
			</tr>
			<tr align="center">
				<td colspan="2" width="180px" align="left" >Section name</td>
				<td width="100px" align="left">Activate/Deactivate</td>
				<td width="40px" align="left">Edit</td>
				<td width="80px" align="left">Delete</td>
			</tr>
			<?php
			$qry ="Select * From clientdashboard_section_details inner join clientdashboard_section_master on clientdashboard_section_master.section_id = clientdashboard_section_details.section_id where companyid = $ID";
			db();
			$res = db_query($qry);
			while($fetch_data=array_shift($res))
			{
			?>
				<input type="hidden" name="section_id" id="section_id" value="<?php echo $fetch_data["section_id"]; ?>" />
				<input type="hidden" name="companyid_sec" id="companyid_sec" value="<?php echo $ID; ?>" />

				<tr align="center">
					<td colspan="2" width="180px" align="left"><?php echo $fetch_data["section_name"];?></td>
					<td width="100px" align="left"><input type="checkbox" name="clientdash_sec_flg" id="clientdash_sec_flg" <?php if ($fetch_data["activate_deactivate"] == 1) { echo " checked "; }?> /></td>
					<td width="40px" align="left"><input type="button" value="Update" onclick="clientdash_sec_edit(<?php echo $fetch_data["section_id"];?>, <?php echo $ID;?>)" /></td>
					<td width="80px" align="left"><input type="button" value="Delete" onclick="clientdash_sec_dele(<?php echo $fetch_data["section_id"];?>, <?php echo $ID;?>)" /></td>
				</tr>
			<?php
			}
			?>
			</form>

			<?php	
			db();
			$res = db_query("Select * from clientdashboard_section_master where section_id not in (select section_id from clientdashboard_section_details where companyid = $ID) order by section_name");
				if (count($res) > 0) {
			?>
			<form method="post" name="clientdash_edituser_sec_add" action="clientdashboard_add_sec.php">
				<input type="hidden" name="hidden_companyid_secadd" id="hidden_companyid_secadd" value="<?php echo $ID; ?>" />
				<tr align="center">
					<td colspan="2" width="180px" align="left" ><select name="clientdash_section" id="clientdash_section" >
					<?php

						while($fetch_data=array_shift($res))
						{
							echo "<option value='" . $fetch_data["section_id"] . "'>" . $fetch_data["section_name"] ." </option>";
						}
					?></select>
					</td>
					<td width="100px" align="left">&nbsp;</td>
					<td colspan="2" width="120px" align="left"><input type="submit" value="Add" /></td>
				</tr>
			</form>
			<?php } ?>

		</table>
		<br/>
		<?php
	}

	function addBoxRequested(int $ID): void
	{
		$strQuery = "SELECT * FROM companyInfo WHERE ID = " . $ID;
		db_b2b();
		$dt_view_res3 = db_query($strQuery);
		while ($co = array_shift($dt_view_res3)) {
		echo $co["req_type"];
		?>
		<table width="100%" border="0" cellspacing="1" cellpadding="1">
		<tr align="center">
		<td colspan="2" bgcolor="#C0CDDA"><font face="Arial, Helvetica, sans-serif" size="1">ADD A REQUESTED BOX</font></td>
		</tr>
		<?php
		if ($co["req_type"] == "box_cml" ) {
			$strQuery = "SELECT * FROM boxesForPickup WHERE companyID = " . $ID;
			$dt_view_res3 = db_query($strQuery,db_b2b() );
			$bo = array_shift($dt_view_res3);

			$d["gbox"] = "Gaylord Boxes";
			$d["if_gaylords"] = "If Gaylords";
			$d["no_of_rescue"] = "Estimated total number of boxes in this rescue";
			$d["list_dimensions"] = "I can’t list the dimensions, the boxes are all different";
			$d["length_lside"] = "Length (longest side)";
			$d["widthInch"] = "Width (shortest side)";
			$d["depthInch"] = "Depth (height excluding flaps)";
			$d["thick"] = "Wall Thickness";
			$d["color"] = "Color";
			$d["printing"] = "Printing";
			$d["labels"] = "Mailing Labels";
			$d["comments"] = "Comments";
			$d["box_condition"] = "Condition";
			$d["priceGetting"] = "Price Getting";
			$d["req_another_box"] = "Request another box";
		?>
		<form method="post" action="editTables.php">
		<?php
			foreach ($d as $key => $value) {
		?>
		<tr bgcolor="#E4E4E4">
			<td><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $value?></font></td>
			<td width="30%"><input type="text" name="<?php echo $key?>"></td>
		</tr>
		<?php
			}
		?>
		<input type=hidden name="editTable" value="AddboxesForPickup">
		<input type=hidden name="id" value="<%=ID%>">
		<tr bgcolor="#E4E4E4">
			<td width="100%" colspan="2" align="center"><input type="submit" value="Submit" name="B1"></td>
		</tr>
		</form>
		<?php
		} elseif ($co["req_type"] == "spbox_not") {
			$strQuery = "SELECT * FROM boxesrequested WHERE companyID LIKE '" . $ID . "'" ;
			echo $strQuery;
			db_b2b();
			$dt_view_res3 = db_query($strQuery);
		?>
		<form method=post action="editTables.php">
		<?php
			while ($bo = array_shift($dt_view_res3)) {
			$d = array();
			$d["preferred_delivery_date"] = "Preferred Delivery Date";
			$d["receiving_dock_info_other"] = "Receiving Dock Info";
			$d["gbox"] = "I need gaylord boxes (pallet boxes measuring approximately 42 x 48 x 36)";
			$d["if_gaylords"] = "If Gaylords";
			$d["cubic_order"] = "Specify Dimensions";
			$d["cubicFeet"] = "Approx. cubic feet";
			$d["lengthInch"] = "Length (longest side)";
			$d["lengthFraction"] = "Can be";
			$d["widthInch"] = "Width (shortest side)";
			$d["widthFraction"] = "Can be";
			$d["depthInch"] = "Depth (height excluding flaps)";
			$d["depthFraction"] = "Can be";
			$d["wall_thickness"] = "Wall thickness";
			$d["color"] = "Color";
			$d["printing"] = "Printing";
			$d["unc_printing"] = "Unnacceptable printing";
			$d["dimension_stamp"] = "Dimension Stamp";
			$d["qty_for_box"] = "Quantity for this box";
			$d["qty_for_month"] = "Quanitity used each month";
			$d["price"] = "Price currently paid (help us be competitive)";
			$d["what_this_box_used_for"] = "What this box is used for";
			$d["comments"] = "Comments";
			$d["req_another_box"] = "Request another box";
		?>

		<?php
			foreach ($d as $key => $value) {
		?>
		<tr bgcolor="#E4E4E4">
			<td><font face="Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo $value?></font></td>
			<td width="30%"><input type="text" name="<?php echo $key;?>"></td>
		</tr>
		<?php
			}
			}
		?>
		<input type=hidden name="editTable" value="AddboxesRequested">
		<input type=hidden name="id" value="<%=ID%>">
		<tr bgcolor="#E4E4E4">
			<td width="100%" colspan="2" align="center"><input type="submit" value="Submit" name="B1"></td>
		</tr>
		</form>
		<?php
		} else { ; }
		?>
		</table>
		<?php

		} 

	}

	function remove_non_numeric(string $string): string {
		return preg_replace('/\D/', '', $string);
	}

	function right(string $string, int $chars): string
	{
		$vright = substr($string, strlen($string)-$chars,$chars);
		return $vright;
	}

	// function make_insert_query($table_name, $arr_data)
	// {
	// 	$fieldname = "";
	// 	$fieldvalue = "";
	// 	foreach($arr_data as $fldname => $fldval)
	// 	{
	// 		$fieldname = ($fieldname == "")?$fldname:$fieldname.','.$fldname;
	// 		$fieldvalue = ($fieldvalue == "")?"'".formatdata($fldval)."'":$fieldvalue.",'".formatdata($fldval)."'";
	// 	}
	// 	$query1 = "INSERT INTO ".$table_name." ($fieldname) VALUES($fieldvalue)";
	// 	return $query1;
	// }

	// function formatdata($data)
	// {
	// 	return addslashes(trim($data));
	// }

	function putEmployee(string $data): void
	{
		?>
		<select size="1" name="<?php echo $data?>" id="<?php echo $data?>">
		<option value="">Please select</option>
		<?php

		db_b2b();
		$res = db_query("SELECT * FROM employees WHERE status LIKE 'Active'" );
		while ($objEmp = array_shift($res)) {
		$selected = "";
			If ($_COOKIE["b2b_id"] == $objEmp["employeeID"] ) {
				$selected = " selected ";
			} Else {
				$selected = "";
		}
		?>
		<option value="<?php echo $objEmp["employeeID"]?>"<?php echo $selected?>><?php echo $objEmp["name"]?></option>
		<?php
		}
		?>
		</select>
		<?php

	}

	function get_initials_from_id_new(int $id): string
	{
		$dt_so = "SELECT * FROM loop_employees WHERE id = " . $id;
		db();
		$dt_res_so = db_query($dt_so);

		while ($so_row = array_shift($dt_res_so)) {
			return $so_row["initials"];
		}
		return "";
	}

	function timestamp_to_datetime_new(string $d): string
	{

		$da = explode(" ",$d);
		$dp = explode("-", $da[0]);
		$dh = explode(":", $da[1]);

		$x = $dp[1] . "/" . $dp[2] . "/" . $dp[0];


		if ((int)$dh[0] - 2 > 12) {
		$x = $x . " " . ((int)$dh[0] - 12) . ":" . $dh[1] . "PM CT";
		} else {
		$x = $x . " " . ($dh[0] ) . ":" . $dh[1] . "AM CT";
		}

		return $x;
	}


?>