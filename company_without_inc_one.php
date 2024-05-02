<script>

				

	function f_getPosition (e_elemRef, s_coord) {

		var n_pos = 0, n_offset,

			e_elem = e_elemRef;



		while (e_elem) {

			n_offset = e_elem["offset" + s_coord];

			n_pos += n_offset;

			e_elem = e_elem.offsetParent;

		}



		e_elem = e_elemRef;

		while (e_elem != document.body) {

			n_offset = e_elem["scroll" + s_coord];

			if (n_offset && e_elem.style.overflow == 'scroll')

				n_pos -= n_offset;

			e_elem = e_elem.parentNode;

		}

		return n_pos;

	}



	function openCompPopup(compid)

	{ 

		selectobject = document.getElementById("compid" + compid);

		n_left = f_getPosition(selectobject, 'Left');

		n_top  = f_getPosition(selectobject, 'Top');

	  

		document.getElementById("light_todo").innerHTML = document.getElementById("showCompDt" + compid).innerHTML;

		document.getElementById('light_todo').style.display='block';



		document.getElementById('light_todo').style.left= (n_left + 50) + 'px';

		document.getElementById('light_todo').style.top=n_top + 40 + 'px';

		document.getElementById('light_todo').style.width= 550 + 'px';

		document.getElementById('light_todo').style.height= 200 + 'px';

	}	

		

	function showcontact_details(compid, search_keyword){

		if (window.XMLHttpRequest){

		  xmlhttp=new XMLHttpRequest();

		}else{

		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

		}

		 xmlhttp.onreadystatechange=function(){

			if (xmlhttp.readyState==4 && xmlhttp.status==200){

				selectobject = document.getElementById("com_contact"+compid);

				n_left = f_getPosition(selectobject, 'Left');

				n_top  = f_getPosition(selectobject, 'Top');

			

				document.getElementById("light_todo").innerHTML = "<a href='javascript:void(0)' onclick=document.getElementById('light_todo').style.display='none';document.getElementById('fade_todo').style.display='none'>Close</a> &nbsp;<center></center><br/>" + xmlhttp.responseText;

				document.getElementById('light_todo').style.display='block';

				

				document.getElementById('light_todo').style.left= (n_left + 50) + 'px';

				document.getElementById('light_todo').style.top=n_top - 40 + 'px';

				document.getElementById('light_todo').style.width= 400 + 'px';

			}

		}

		

		xmlhttp.open("GET","dashboard-search-contact.php?compid="+compid + "&search_keyword=" + encodeURIComponent(search_keyword) ,true);

		xmlhttp.send();		

	}

</script>



			

<?php  

	$_REQUEST["show"] = "search";

	



	function highlightSearchKeywords($text, $keyword) {  

		$wordsAry = explode(" ", $keyword);

		$wordsCount = count($wordsAry);



		$actual_data_Ary = explode(" ", trim($text));

		$actual_data_cnt = count($actual_data_Ary);

		

		$new_str = "";

		for($cnt_1=0;$cnt_1 < $actual_data_cnt;$cnt_1++) {

			$char_match_flg = "no";

			for ($i=0; $i<$wordsCount; $i++) {

				

				
				

				if (strlen($wordsAry[$i]) > 1){

					$pos = strpos(strtolower($actual_data_Ary[$cnt_1]), strtolower($wordsAry[$i]));

					if ($pos !== false && strlen($actual_data_Ary[$cnt_1]) > 0){

						$char_match_flg = "yes";

						$new_str .=  "<span style='font-weight:bold; background:#FFFE63;'>" . $actual_data_Ary[$cnt_1] . "</span>" . " ";

					}	

				}	

			}

			if ($char_match_flg == "no")

			{

				$new_str .= $actual_data_Ary[$cnt_1] . " ";

			}			

		}

		

	



		return trim($new_str);

	}

?>