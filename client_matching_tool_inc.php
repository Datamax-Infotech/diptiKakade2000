<form action="client_matching_tool.php" method="POST" onsubmit="return frm_check();">
					<table width="100%">
						<tr>
							<td bgcolor="#E3E3F3" align="left" width="30%" valign="top">
								<table class="tbl_address" width="100%">
									<tr>
										<td colspan="2" align="center">&nbsp;</td>
									</tr>
									<tr>
										<td>Zip Code:</td>
										<td><input name="zipcode" id="zipcode" value="<?php echo $_REQUEST['zipcode']; ?>" type="text">
										</td>
									</tr>
									<tr>
										<td>Price:</td>
										<td>
											<input name="txtprice_from" style="width:100px;" id="txtprice_from" value="<?php echo $_REQUEST['txtprice_from']; ?>" type="text">
											-
											<input name="txtprice_to" style="width:100px;" id="txtprice_to" value="<?php echo $_REQUEST['txtprice_to']; ?>" type="text">
										</td>
									</tr>
									<tr>
										<td>Timing:</td>
										<td>
											<select name="timing_fltr" id="timing_fltr">
												<option value="2" <?php echo (($_REQUEST['timing_fltr'] == 2) ? "Selected" : ""); ?>>FTL Rdy Now ONLY</option>
												<option value="1" <?php echo (($_REQUEST['timing_fltr'] == 1) ? "Selected" : ""); ?>>Rdy Now + Presell</option>
												<option value="3" <?php echo (($_REQUEST['timing_fltr'] == 3) ? "Selected" : ""); ?>>Rdy < 3mo</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Can Ship LTL?</td>
										<td>
											<input type="checkbox" name="can_ship_ltl" id="can_ship_ltl" value="Yes" <?php if ($_REQUEST['can_ship_ltl'] == "Yes") {echo "Checked";}?>>
										</td>
									</tr>
									<tr>
										<td>Customer Pickup Allowed?:</td>
										<td>
											<input type="checkbox" name="can_pickup_allowed" id="can_pickup_allowed" value="Yes" <?php if ($_REQUEST['can_pickup_allowed'] == "Yes") {echo "Checked";}?>>
										</td>
									</tr>

									<tr>
										<td>Item Type: </td>
										<td>
											<select name="itype" id="itype" onChange="show_options_tbl(this.value);">
												<option value="0">Select</option>
												<option value="1" <?php echo (($_REQUEST['itype'] == 1) ? "Selected" : ""); ?>>Gaylords</option>
												<option value="2" <?php echo (($_REQUEST['itype'] == 2) ? "Selected" : ""); ?>>Shipping Boxes</option>
												<option value="3" <?php echo (($_REQUEST['itype'] == 3) ? "Selected" : ""); ?>>Pallets</option>
												<option value="4" <?php echo (($_REQUEST['itype'] == 4) ? "Selected" : ""); ?>>Supersacks</option>
											</select>
										</td>
									</tr>


									<tr>
										<td colspan="2" align="center">

											<table width="100%" id="1" class="table item" cellpadding="3" cellspacing="1">

												<tr>
													<td>
													  Height Flexibility </td>
													<td><span class="label_txt">Min</span> <br>
													  <input type="text" name="g_item_min_height" id="g_item_min_height" value="<?php if (isset($_REQUEST['g_item_min_height'])) {echo $_REQUEST['g_item_min_height'];} else {echo "0";}?>" size="5" onKeyPress="return isNumberKey(event)"></td>
													<td align="center">-</td>
													<td colspan="3"><span class="label_txt">Max</span>
													  <input type="text" name="g_item_max_height" id="g_item_max_height" value="<?php if (isset($_REQUEST['g_item_max_height'])) {echo $_REQUEST['g_item_max_height'];} else {echo "99";}?>" size="5" onKeyPress="return isNumberKey(event)"></td>
												</tr>
												<tr>
													<td> Shape </td>
													<td> Rectangular </td>
													<td><input type="checkbox" name="g_shape_rectangular" id="g_shape_rectangular" value="Yes" <?php if ($_REQUEST['g_shape_rectangular'] == "Yes") {echo "Checked";}?> <?php if (!isset($_REQUEST['g_shape_rectangular'])) {echo "Checked";}?>></td>
													<td> Octagonal </td>
													<td colspan="2"><input type="checkbox" name="g_shape_octagonal" id="g_shape_octagonal" value="Yes" <?php if (!isset($_REQUEST['g_shape_octagonal'])) {echo "Checked";}?> <?php if ($_REQUEST['g_shape_octagonal'] == "Yes") {echo "Checked";}?>></td>
												</tr>
												<tr>
													<td rowspan="5"> # of Walls </td>
													<td> 1ply </td>
													<td><input type="checkbox" name="g_wall_1" id="g_wall_1" value="Yes" <?php if (!isset($_REQUEST['g_wall_1'])) {echo " Checked ";}?> <?php if ($_REQUEST['g_wall_1'] == "Yes") {echo " Checked ";}?>></td>
													<td> 6ply </td>
													<td colspan="2"><input type="checkbox" name="g_wall_6" id="g_wall_6" value="Yes" <?php if (!isset($_REQUEST['g_wall_6'])) {echo "Checked";}?> <?php if ($_REQUEST['g_wall_6'] == "Yes") {echo "Checked";}?>></td>
												</tr>
												<tr>
													<td> 2ply </td>
													<td><input type="checkbox" name="g_wall_2" id="g_wall_2" value="Yes" <?php if (!isset($_REQUEST['g_wall_2'])) {echo "Checked";}?> <?php if ($_REQUEST['g_wall_2'] == "Yes") {echo "Checked";}?>></td>
													<td> 7ply </td>
													<td colspan="2"><input type="checkbox" name="g_wall_7" id="g_wall_7" value="Yes" <?php if (!isset($_REQUEST['g_wall_7'])) {echo "Checked";}?> <?php if ($_REQUEST['g_wall_7'] == "Yes") {echo "Checked";}?>></td>
												</tr>
													<tr style="background-color:red">

													<td> 3ply </td>
													<td><input type="checkbox" name="g_wall_3" id="g_wall_3" value="Yes" <?php if (!isset($_REQUEST['g_wall_3'])) {echo "Checked";}?> <?php if ($_REQUEST['g_wall_3'] == "Yes") {echo "Checked";}?>></td>
													<td> 8ply </td>
													<td colspan="2"><input type="checkbox" name="g_wall_8" id="g_wall_8" value="Yes" <?php if (!isset($_REQUEST['g_wall_8'])) {echo "Checked";}?>  <?php if ($_REQUEST['g_wall_8'] == "Yes") {echo "Checked";}?>></td>
												</tr>
												<tr>
													<td> 4ply </td>
													<td><input type="checkbox" name="g_wall_4" id="g_wall_4" value="Yes" <?php if (!isset($_REQUEST['g_wall_4'])) {echo "Checked";}?> <?php if ($_REQUEST['g_wall_4'] == "Yes") {echo "Checked";}?>></td>
													<td> 9ply </td>
													<td colspan="2"><input type="checkbox" name="g_wall_9" id="g_wall_9" value="Yes" <?php if (!isset($_REQUEST['g_wall_9'])) {echo "Checked";}?>  <?php if ($_REQUEST['g_wall_9'] == "Yes") {echo "Checked";}?>></td>
												</tr>
												<tr>
													<td> 5ply </td>
													<td><input type="checkbox" name="g_wall_5" id="g_wall_5" value="Yes" <?php if (!isset($_REQUEST['g_wall_5'])) {echo "Checked";}?> <?php if ($_REQUEST['g_wall_5'] == "Yes") {echo "Checked";}?>></td>
													<td> 10ply </td>
													<td colspan="2"><input type="checkbox" name="g_wall_10" id="g_wall_10" value="Yes" <?php if (!isset($_REQUEST['g_wall_10'])) {echo "Checked";}?> <?php if ($_REQUEST['g_wall_10'] == "Yes") {echo "Checked";}?>></td>
												</tr>
												<tr>
													<td rowspan="2"> Top Config </td>
													<td> No Top </td>
													<td><input name="g_no_top" type="checkbox" id="g_no_top" value="Yes" <?php if (!isset($_REQUEST['g_no_top'])) {echo "Checked";}?> <?php if ($_REQUEST['g_no_top'] == "Yes") {echo "Checked";}?>></td>
													<td> Lid Top </td>
													<td colspan="2"><input name="g_lid_top" type="checkbox" id="g_lid_top" value="Yes" <?php if (!isset($_REQUEST['g_lid_top'])) {echo "Checked";}?> <?php if ($_REQUEST['g_lid_top'] == "Yes") {echo "Checked";}?>></td>
												</tr>
												<tr>
													<td> Partial Flap Top </td>
													<td><input name="g_partial_flap_top" type="checkbox" id="g_partial_flap_top" value="Yes" <?php if (!isset($_REQUEST['g_partial_flap_top'])) {echo "Checked";}?> <?php if ($_REQUEST['g_partial_flap_top'] == "Yes") {echo "Checked";}?>></td>
													<td> Full Flap Top </td>
													<td colspan="2"><input name="g_full_flap_top" type="checkbox" id="g_full_flap_top" value="Yes" <?php if (!isset($_REQUEST['g_full_flap_top'])) {echo "Checked";}?> <?php if ($_REQUEST['g_full_flap_top'] == "Yes") {echo "Checked";}?>></td>
												</tr>
												<tr>
													<td rowspan="3"> Bottom Config </td>
													<td> No Bottom </td>
													<td><input name="g_no_bottom_config" type="checkbox" id="g_no_bottom_config" value="Yes" <?php if (!isset($_REQUEST['g_no_bottom_config'])) {echo "Checked";}?> <?php if ($_REQUEST['g_no_bottom_config'] == "Yes") {echo "Checked";}?>></td>
													<td> Partial Flap w/ Slipsheet </td>
													<td colspan="2"><input name="g_partial_flap_w" type="checkbox" id="g_partial_flap_w" value="Yes" <?php if (!isset($_REQUEST['g_partial_flap_w'])) {echo "Checked";}?> <?php if ($_REQUEST['g_partial_flap_w'] == "Yes") {echo "Checked";}?>></td>
												</tr>
												<tr>
													<td> Tray Bottom </td>
													<td><input name="g_tray_bottom" type="checkbox" id="g_tray_bottom" value="Yes"  <?php if (!isset($_REQUEST['g_tray_bottom'])) {echo "Checked";}?> <?php if ($_REQUEST['g_tray_bottom'] == "Yes") {echo "Checked";}?>></td>
													<td> Full Flap Bottom </td>
													<td colspan="2"><input name="g_full_flap_bottom" type="checkbox" id="g_full_flap_bottom" value="Yes"  <?php if (!isset($_REQUEST['g_full_flap_bottom'])) {echo "Checked";}?> <?php if ($_REQUEST['g_full_flap_bottom'] == "Yes") {echo "Checked";}?>></td>
												</tr>
												<tr>
													<td> Partial Flap w/o SlipSheet </td>
													<td colspan="4"><input name="g_partial_flap_wo" type="checkbox" id="g_partial_flap_wo" value="Yes"  <?php if (!isset($_REQUEST['g_partial_flap_wo'])) {echo "Checked";}?> <?php if ($_REQUEST['g_partial_flap_wo'] == "Yes") {echo "Checked";}?>></td>
												</tr>
												<tr>
													<td> Vents Okay? </td>
													<td colspan=5><input name="g_vents_okay" type="checkbox" id="g_vents_okay" value="Yes"  <?php if (!isset($_REQUEST['g_vents_okay'])) {echo "Checked";}?> <?php if ($_REQUEST['g_vents_okay'] == "Yes") {echo "Checked";}?>></td>
												</tr>
											</table>

											<table width="100%" id="2" class="table item" cellpadding="3" cellspacing="1">

												<tr>
													<td colspan="6"><strong>Size Flexibility</strong></td>
												</tr>
												<tr>
													<td>Length </td>
													<td><span class="label_txt">Min</span> <br>
														<input type="text" name="sb_item_min_length" id="sb_item_min_length" value="<?php if (isset($_REQUEST['sb_item_min_length'])) {echo $_REQUEST['sb_item_min_length'];} else {echo "0";}?>" size="5" onKeyPress="return isNumberKey(event)">
													</td>
													<td align="center">-</td>
													<td colspan="3"><span class="label_txt">Max</span>
														<input type="text" name="sb_item_max_length" id="sb_item_max_length" value="<?php if (isset($_REQUEST['sb_item_max_length'])) {echo $_REQUEST['sb_item_max_length'];} else {echo "99";}?>" size="5" onKeyPress="return isNumberKey(event)">
													</td>
												</tr>
												<tr>
													<td>Width </td>
													<td><span class="label_txt">Min</span> <br>
														<input type="text" name="sb_item_min_width" id="sb_item_min_width" value="<?php if (isset($_REQUEST['sb_item_min_width'])) {echo $_REQUEST['sb_item_min_width'];} else {echo "0";}?>" size="5" onKeyPress="return isNumberKey(event)">
													</td>
													<td align="center">-</td>
													<td colspan="3"><span class="label_txt">Max</span>
														<input type="text" name="sb_item_max_width" id="sb_item_max_width" value="<?php if (isset($_REQUEST['sb_item_max_width'])) {echo $_REQUEST['sb_item_max_width'];} else {echo "99";}?>" size="5" onKeyPress="return isNumberKey(event)">
													</td>
												</tr>
												<tr>
													<td>Height </td>
													<td><span class="label_txt">Min</span> <br>
														<input type="text" name="sb_item_min_height" id="sb_item_min_height" value="<?php if (isset($_REQUEST['sb_item_min_height'])) {echo $_REQUEST['sb_item_min_height'];} else {echo "0";}?>" size="5" onKeyPress="return isNumberKey(event)">
													</td>
													<td align="center">-</td>
													<td colspan="3"><span class="label_txt">Max</span>
														<input type="text" name="sb_item_max_height" id="sb_item_max_height" value="<?php if (isset($_REQUEST['sb_item_max_height'])) {echo $_REQUEST['sb_item_max_height'];} else {echo "99";}?>" size="5" onKeyPress="return isNumberKey(event)">
													</td>
												</tr>
												<tr>
													<td>Cubic Footage </td>
													<td><span class="label_txt">Min</span> <br>
														<input type="text" name="sb_cubic_footage_min" id="sb_cubic_footage_min" value="<?php if (isset($_REQUEST['sb_cubic_footage_min'])) {echo $_REQUEST['sb_cubic_footage_min'];} else {echo "0";}?>" size="5" onKeyPress="return isNumberKey(event)">
													</td>
													<td align="center">-</td>
													<td colspan="3"><span class="label_txt">Max</span>
														<input type="text" name="sb_cubic_footage_max" id="sb_cubic_footage_max" value="<?php if (isset($_REQUEST['sb_cubic_footage_max'])) {echo $_REQUEST['sb_cubic_footage_max'];} else {echo "99";}?>" size="5" onKeyPress="return isNumberKey(event)">
													</td>
												</tr>
												<tr>
													<td> # of Walls </td>
													<td> 1ply </td>
													<td><input type="checkbox" name="sb_wall_1" id="sb_wall_1" value="Yes"  <?php if (!isset($_REQUEST['sb_wall_1'])) {echo "Checked";}?>  <?php if ($_REQUEST['sb_wall_1'] == "Yes") {echo "Checked";}?>></td>
													<td> 2ply </td>
													<td colspan="2"><input type="checkbox" name="sb_wall_2" id="sb_wall_2" value="Yes"  <?php if (!isset($_REQUEST['sb_wall_2'])) {echo "Checked";}?>  <?php if ($_REQUEST['sb_wall_2'] == "Yes") {echo "Checked";}?>></td>
												</tr>
												<tr>
													<td> Top Config </td>
													<td> No Top </td>
													<td><input name="sb_no_top" type="checkbox" id="sb_no_top" value="Yes" <?php if (!isset($_REQUEST['sb_no_top'])) {echo "Checked";}?>  <?php if ($_REQUEST['sb_no_top'] == "Yes") {echo "Checked";}?>></td>
													<td> Full Flap Top </td>
													<td colspan="2">
														<input name="sb_full_flap_top" type="checkbox" id="sb_full_flap_top" value="Yes"  <?php if (!isset($_REQUEST['sb_full_flap_top'])) {echo "Checked";}?>  <?php if ($_REQUEST['sb_full_flap_top'] == "Yes") {echo "Checked";}?>>
													</td>
												</tr>
												<tr>
													<td>&nbsp;</td>
													<td> Partial Flap Top </td>
													<td><input name="sb_partial_flap_top" type="checkbox" id="sb_partial_flap_top" value="Yes"  <?php if (!isset($_REQUEST['sb_partial_flap_top'])) {echo "Checked";}?>  <?php if ($_REQUEST['sb_partial_flap_top'] == "Yes") {echo "Checked";}?>></td>
													<td>&nbsp;</td>
													<td colspan="2">&nbsp;</td>
												</tr>
												<tr>
													<td> Bottom Config </td>
													<td> No Bottom </td>
													<td><input name="sb_no_bottom" type="checkbox" id="sb_no_bottom" value="Yes"  <?php if (!isset($_REQUEST['sb_no_bottom'])) {echo "Checked";}?> <?php if ($_REQUEST['sb_no_bottom'] == "Yes") {echo "Checked";}?>></td>
													<td> Full Flap Bottom </td>
													<td colspan="2">
														<input name="sb_full_flap_bottom" type="checkbox" id="sb_full_flap_bottom" value="Yes"  <?php if (!isset($_REQUEST['sb_full_flap_bottom'])) {echo "Checked";}?> <?php if ($_REQUEST['sb_full_flap_bottom'] == "Yes") {echo "Checked";}?>>
													</td>
												</tr>
												<tr>
													<td>&nbsp;</td>
													<td> Partial Flap Bottom </td>
													<td><input name="sb_partial_flap_bottom" type="checkbox" id="sb_partial_flap_bottom" value="Yes"  <?php if (!isset($_REQUEST['sb_partial_flap_bottom'])) {echo "Checked";}?> <?php if ($_REQUEST['sb_partial_flap_bottom'] == "Yes") {echo "Checked";}?>></td>
													<td>&nbsp;</td>
													<td colspan="2">&nbsp;</td>
												</tr>
												<tr>
													<td> Vents Okay? </td>
													<td colspan=5><input name="sb_vents_okay" type="checkbox" id="sb_vents_okay" value="Yes"  <?php if (!isset($_REQUEST['sb_vents_okay'])) {echo "Checked";}?>  <?php if ($_REQUEST['sb_vents_okay'] == "Yes") {echo "Checked";}?>></td>
												</tr>
											</table>

											<!--    Shipping Boxes Table options End    -->

											<!--    Pallets Table options Start    -->
											<table width="100%" id="3" class="table item" cellpadding="3" cellspacing="1">
											</table>
											<!--    Pallets Table options End    -->

											<!--    Supersacks Table options Start    -->
											<table width="100%" id="4" class="table item" cellpadding="3" cellspacing="1">
											</table>
											<!--    Supersacks Table options End    -->

										</td>
									</tr>
									<tr>
										<td colspan="2" align="center" style="height:0.5">&nbsp;</td>
									</tr>
									<tr>
										<td colspan="2" align="center">
											<input type="submit" name="submit" value="Search">
										</td>
									</tr>
									<tr>
										<td colspan="2" align="center">&nbsp;</td>
									</tr>
									</form>
								</table>
							</td>
							<td align="left" width="70%" valign="top">
								<div id="div_element" style="min-height:800px;">
									<?php
										if (isset($_REQUEST["itype"]) && $_REQUEST["itype"] != 0) {
											echo "<script>show_options_tbl(" . $_REQUEST["itype"] . ");</script>";
										}

										if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
											include_once "client_matching_tool_table.php";
										}

										?>
								</div>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
					</table>