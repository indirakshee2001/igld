<?php

session_start();



if(!isset($_SESSION['thisusername'])) {

exit('<h2>Mismatch</h2>Sorry, you must enter a valid username and password to log in and access this page. If you ' .
    'aren\'t a registered member, please contact indrakshiguild@gmail.com. To Log in please <a href="memlogin.html">click here</a>');

} else {

	echo "You have Successfully Logged in as - " . 	$_SESSION['thisusername'];
	$This_User = trim($_SESSION['thisusername']);
	
	include 'includelocaldb.php';
	
	$userdbconnect = mysql_connect($host,$name,$password);
	$userdatabase = mysql_select_db($databasename, $userdbconnect);
   $Member_Type_sql = "Select `clienttype` from `members` where `members`.`username` = '{$This_User}'"; 
	$Member_Type_query = mysql_query($Member_Type_sql);
	$Member_Type_Result =  mysql_result($Member_Type_query,0,0);

	$Member_Credit_sql = "Select `creditbal` from `members` where `members`.`username` = '{$This_User}'"; 
	$Member_Credit_query = mysql_query($Member_Credit_sql);
	$Member_Credit_Result =  mysql_result($Member_Credit_query,0,0);

  $session_tree_new = md5(uniqid(rand(), true));

  if(isset($_SESSION['session_tree'])) {
  	$session_tree_old = $_SESSION['session_tree'];
  } else {
  	$_SESSION['session_tree'] = $session_tree_new;
  }

	if($Member_Type_Result == "subscriber" && isset($_POST['Calculate_QMDJ']) && isset($session_tree_old) && $session_tree_old == $_POST['session_tree']){
		$Member_Credit_Result = $Member_Credit_Result + 1;  
		$Member_NowCredit_sql = "update `members` set `creditbal`= '{$Member_Credit_Result}'where `members`.`username` = '{$This_User}'"; 
		$Member_NowCredit_query = mysql_query($Member_NowCredit_sql);
		// see this here later
		//$Member_NowCredit_Result =  mysql_result($Member_NowCredit_query,0,0);
		//once the form is processed, the "header" below redirects to the same page,
		//which will load via 'GET' request and hence refresh will not affect the page flow
		//header('Location: QMDJ_Pan_Sel_DDate.php');
		//$_POST['Calculate QMDJ'] = array();
		$_SESSION['session_tree'] = $session_tree_new;
	}
	
		//echo "<br>";
		//echo "<br>";
		//echo "<br>";
		//echo "<br>";
		//echo  "This is the NOW CRedit result - - - ----". $Member_NowCredit_Result;
	
	//echo $This_User;
	//echo $Member_Type_Result;
	//$memdbc = mysqli_connect($host,$name,$password,$databasename) or die("Error");

	//$usertypequery = "Select clienttype from members where username = '{$thisuser}'"; 
	//$usertypedata = mysqli_query($memdbc, $usertypequery); 
	echo " and you are a " . $Member_Type_Result;	
	
	
		if($Member_Type_Result == "master") {
			echo " - you have no limitations on the use of this software";
			$validtill = "None";
			}
		
		if($Member_Type_Result == "") {
			exit('<h2>Mismatch</h2>Sorry, you must enter a valid username and password to log in and access this page. If you ' .
    'aren\'t a registered member. To Log in please <a href="memberlogin.html">click here</a>');

			}
			
		if($Member_Type_Result == "array()") {
			echo " - you have no limitations on the use of this software";
			$validtill = "None";
			}
			
		if($Member_Type_Result == "guildmember") {
			$Member_Valid_sql = "Select `validto` from `members` where `members`.`username` = '{$This_User}'"; 
			$Member_Valid_query = mysql_query($Member_Valid_sql);
			$Member_Valid_Result =  mysql_result($Member_Valid_query,0,0);
			echo " - and can use this software till ". $Member_Valid_Result;
			
				$thisisnowdate = date('d');
				$thisisnowmonth = date('M');
				$thisisnowyear = date('y');
				$thisisthenow = $thisisnowyear."-".$thisisnowmonth."-".$thisisnowdate;
			
					if ($Member_Valid_Result <  date('Y-m-d')) {
						exit('Sorry, you have run out of validity to access the software. please contact indrakshiguild@gmail.com');
					}	
			
		} 
		
		if($Member_Type_Result == "Member") {
			exit('<h2>Mismatch</h2>Sorry, you do not have access to this section'); 
		}
		
		if($Member_Type_Result == "subscriber") {
			exit('<h2>Mismatch</h2>Sorry, you do not have access to this section'); 
		} 
	}
	
	echo "<br>";
	
	?>
<br>
<a href="dateselectlandingmem.php" class="logoutpan"> Back</a> &nbsp <a href="memlogout.php" class="logoutpan"> Log Out</a> &nbsp (Avoid Refreshing or Going Back, you may be logged out)
<link type="text/css" rel="stylesheet" href="dateselectionstyle.css" />

<script type = 'text/javascript'>
document.onkeydown = function() {    
    switch (event.keyCode) { 
        case 116 : //F5 button
				window.close();
         	window.open('logout.php', '_blank');            
            event.returnValue = false;
            event.keyCode = 0;
            return false;
             
			
        case 82 : //R button
            if (event.ctrlKey) { 
					 window.close();
         		 window.open('logout.php', '_blank');	                
                event.returnValue = false; 
                event.keyCode = 0;  
                return false; 
            }    
         case 8:
         window.close();
         window.open('logout.php', '_blank');
         //event.returnValue = false;
			        
         //event.keyCode = 0;
			       
         return false; 
         
			       
         case 37: 
         if (event.altKey)  {   
			window.close();
         window.open('logout.php', '_blank');	         
         //event.returnValue = false; 
         //event.keyCode = 0;  
         return false; 
         }
             
    }
    
}

//window.onbeforeunload = function1(){ window.location.href = "logout.php"; return;}
 //document.unload = function1()
 //{ window.unload = function1 () { window.open('logout.php', '_blank'); };}
</script>	

<script type="text/javascript" >

window.onunload = function1(){ 
window.close();
window.open('logout.php', '_blank'); 

}


</script>


</head>

<body>

<p>


<form action="<?php $_PHP_SELF ?>" method="POST">
<input type="hidden" name="session_tree" value="<?php echo $session_tree_new ?>"/>
<!--
<input type="text" name="inpthigh"  />
<input type="text" name="inptlow"  />
<input type="text" name="inptclose"  />


<br>
<br>
<br>

<input type="text" name="inpthighY"  />
<input type="text" name="inptlowY"  />
<input type="text" name="inptcloseY"  />



-->
<?php

if (date('d') == '01'){$is1 = 'selected';}else {$is1 = '';}
if (date('d') == '02'){$is2 = 'selected';}else {$is2 = '';}
if (date('d') == '03'){$is3 = 'selected';}else {$is3 = '';}
if (date('d') == '04'){$is4 = 'selected';}else {$is4 = '';}
if (date('d') == '05'){$is5 = 'selected';}else {$is5 = '';}
if (date('d') == '06'){$is6 = 'selected';}else {$is6 = '';}
if (date('d') == '07'){$is7 = 'selected';}else {$is7 = '';}
if (date('d') == '08'){$is8 = 'selected';}else {$is8 = '';}
if (date('d') == '09'){$is9 = 'selected';}else {$is9 = '';}
if (date('d') == '10'){$is10 = 'selected';}else {$is10 = '';}
if (date('d') == '11'){$is11 = 'selected';}else {$is11 = '';}
if (date('d') == '12'){$is12 = 'selected';}else {$is12 = '';}
if (date('d') == '13'){$is13 = 'selected';}else {$is13 = '';}
if (date('d') == '14'){$is14 = 'selected';}else {$is14 = '';}
if (date('d') == '15'){$is15 = 'selected';}else {$is15 = '';}
if (date('d') == '16'){$is16 = 'selected';}else {$is16 = '';}
if (date('d') == '17'){$is17 = 'selected';}else {$is17 = '';}
if (date('d') == '18'){$is18 = 'selected';}else {$is18 = '';}
if (date('d') == '19'){$is19 = 'selected';}else {$is19 = '';}
if (date('d') == '20'){$is20 = 'selected';}else {$is20 = '';}
if (date('d') == '21'){$is21 = 'selected';}else {$is21 = '';}
if (date('d') == '22'){$is22 = 'selected';}else {$is22 = '';}
if (date('d') == '23'){$is23 = 'selected';}else {$is23 = '';}
if (date('d') == '24'){$is24 = 'selected';}else {$is24 = '';}
if (date('d') == '25'){$is25 = 'selected';}else {$is25 = '';}
if (date('d') == '26'){$is26 = 'selected';}else {$is26 = '';}
if (date('d') == '27'){$is27 = 'selected';}else {$is27 = '';}
if (date('d') == '28'){$is28 = 'selected';}else {$is28 = '';}
if (date('d') == '29'){$is29 = 'selected';}else {$is29 = '';}
if (date('d') == '30'){$is30 = 'selected';}else {$is30 = '';}
if (date('d') == '31'){$is31 = 'selected';}else {$is31 = '';}

if (date('M') == 'Jan'){$isjan = 'selected';}else {$isjan = '';}
if (date('M') == 'Feb'){$isfeb = 'selected';}else {$isfeb = '';}
if (date('M') == 'Mar'){$ismar = 'selected';}else {$ismar = '';}
if (date('M') == 'Apr'){$isapr = 'selected';}else {$isapr = '';}
if (date('M') == 'May'){$ismay = 'selected';}else {$ismay = '';}
if (date('M') == 'Jun'){$isjun = 'selected';}else {$isjun = '';}
if (date('M') == 'Jul'){$isjul = 'selected';}else {$isjul = '';}
if (date('M') == 'Aug'){$isaug = 'selected';}else {$isaug = '';}
if (date('M') == 'Sep'){$issep = 'selected';}else {$issep = '';}
if (date('M') == 'Oct'){$isoct = 'selected';}else {$isoct = '';}
if (date('M') == 'Nov'){$isnov = 'selected';}else {$isnov = '';}
if (date('M') == 'Dec'){$isdec = 'selected';}else {$isdec = '';}

if (date('Y') == '2014'){$is2014 = 'selected';}else {$is2014 = '';}
if (date('Y') == '2015'){$is2015 = 'selected';}else {$is2015 = '';}
if (date('Y') == '2016'){$is2016 = 'selected';}else {$is2016 = '';}
if (date('Y') == '2017'){$is2017 = 'selected';}else {$is2017 = '';}
if (date('Y') == '2018'){$is2018 = 'selected';}else {$is2018 = '';}
if (date('Y') == '2019'){$is2019 = 'selected';}else {$is2019 = '';}
if (date('Y') == '2020'){$is2020 = 'selected';}else {$is2020 = '';}
if (date('Y') == '2021'){$is2021 = 'selected';}else {$is2021 = '';}

//$_POST['must'] = array();
//$_POST['Calculate QMDJ'] = array();

?>



<select name="SelectedDay">
	<option value="1" <?php echo $is11;?>>1</option>
	<option value="2" <?php echo $is2;?>>2</option>
	<option value="3" <?php echo $is3;?>>3</option>
	<option value= "4" <?php echo $is4;?>>4</option>
	<option value="5" <?php echo $is5;?>>5</option>
	<option value="6" <?php echo $is6;?>>6</option>
	<option value="7" <?php echo $is7;?>>7</option>
	<option value="8" <?php echo $is9;?>>8</option>
	<option value="9" <?php echo $is9;?>>9</option>
	<option value="10" <?php echo $is10;?>>10</option>
	<option value="11" <?php echo $is11;?>>11</option>
	<option value="12" <?php echo $is12;?>>12</option>
	<option value="13" <?php echo $is13;?>>13</option>
	<option value="14" <?php echo $is14;?>>14</option>
	<option value="15" <?php echo $is15;?>>15</option>
	<option value="16" <?php echo $is16;?>>16</option>
	<option value="17" <?php echo $is17;?>>17</option>
	<option value="18" <?php echo $is18;?>>18</option>
	<option value="19" <?php echo $is19;?>>19</option>
	<option value="20" <?php echo $is20;?>>20</option>
	<option value="21" <?php echo $is21;?>>21</option>
	<option value="22" <?php echo $is22;?>>22</option>
	<option value="23" <?php echo $is23;?>>23</option>
	<option value="24" <?php echo $is24;?>>24</option>
	<option value="25" <?php echo $is25;?>>25</option>
	<option value="26" <?php echo $is26;?>>26</option>
	<option value="27" <?php echo $is27;?>>27</option>
	<option value="28" <?php echo $is28;?>>28</option>
	<option value="29" <?php echo $is29;?>>29</option>
	<option value="30" <?php echo $is30;?>>30</option>
	<option value="31" <?php echo $is31;?>>31</option>
</select>

<select name="SelectsMonth">
	<option value="Jan" <?php echo $isjan;?>>Jan</option>
	<option value="Feb" <?php echo $isfeb;?>>Feb</option>
	<option value="Mar" <?php echo $ismar;?>>Mar</option>
	<option value="Apr" <?php echo $isapr;?>>Apr</option>
	<option value="May" <?php echo $ismay;?>>May</option>
	<option value="Jun" <?php echo $isjun;?>>Jun</option>
	<option value="Jul" <?php echo $isjul;?>>Jul</option>
	<option value="Aug" <?php echo $isaug;?>>Aug</option>
	<option value="Sep" <?php echo $issep;?>>Sep</option>
	<option value= "Oct" <?php echo $isoct;?>>Oct</option>	
	<option value="Nov" <?php echo $isnov;?>> Nov</option>
	<option value="Dec" <?php echo $isdec;?>>Dec</option>
</select>


<select name="SelectsYear">
<option value="2014" <?php echo $is2014;?>>2014</option>
<option value="2015" <?php echo $is2015;?>>2015</option>
<option value="2016" <?php echo $is2016;?>>2016</option>
<option value="2017" <?php echo $is2017;?>>2017</option>
<option value="2018" <?php echo $is2018;?>>2018</option>
<option value="2019" <?php echo $is2019;?>>2019</option>
<option value="2020" <?php echo $is2020;?>>2020</option>
<option value="2021" <?php echo $is2021;?>>2021</option>
</select>

<select name="SelectHour">
<option value="5 to 7" >5 to 7</option>
<option value="7 to 9">7 to 9</option>
<option value="9 to 11">9 to 11</option>
<option value="11 to 13">11 to 13</option>
<option value="13 to 15">13 to 15</option>
<option value="15 to 17">15 to 17</option>
<option value="17 to 19">17 to 19</option>
<option value="19 to 21">19 to 21</option>
<option value="21 to 23" >21 to 23</option>
<input type="submit" value="Calculate" name="Calculate_QMDJ" />
</select>
</form>



<?php

if($Member_Type_Result == "subscriber" or $Member_Type_Result == "trial" or $Member_Type_Result == "member" or $Member_Type_Result == "specialmember") {
		$thisisnowdate = date('d');
		$thisisnowmonth = date('M');
		$thisisnowyear = date('y');
		$thisisthenow = $thisisnowyear."-".$thisisnowmonth."-".$thisisnowdate;
			
			if ($Member_Valid_Result <  date('Y-m-d')) {
				exit('Sorry, you have run out of validity to access the software. please contact indrakshiguild@gmail.com');
			}
}


if($Member_Type_Result == "subscriber") {
		if($Member_Credit_Result > 150) {
				exit('Sorry, you have used up your Credit, please contact indrakshiguild@gmail.com.');
   		}			
	} 


error_reporting(E_ALL ^ E_WARNING);
error_reporting(0);

$selected_hour = $_POST['SelectHour'];

$selected_day = $_POST['SelectedDay'];
$selected_month = $_POST['SelectsMonth'];
$selected_year = $_POST['SelectsYear'];

switch($selected_day):

	case ("1"):
		$day_num_date_sel = "01";
	break;
	case ("2"):
		$day_num_date_sel = "02";
	break;
	case ("3"):
		$day_num_date_sel = "03";
	break;
	case ("4"):
		$day_num_date_sel = "04";
	break;
	case ("5"):
		$day_num_date_sel = "05";
	break;
	case ("6"):
		$day_num_date_sel = "06";
	break;
case ("7"):
		$day_num_date_sel = "07";
	break;
	case ("8"):
		$day_num_date_sel = "08";
	break;
case ("9"):
		$day_num_date_sel = "09";
	break;
	case ("10"):
		$day_num_date_sel = "10";
	break;
	case ("11"):
		$day_num_date_sel = "11";
	break;
	case ("12"):
		$day_num_date_sel = "12";
	break;
case ("13"):
		$day_num_date_sel = "13";
	break;
case ("14"):
		$day_num_date_sel = "14";
	break;
case ("15"):
		$day_num_date_sel = "15";
	break;
case ("16"):
		$day_num_date_sel = "16";
	break;
case ("17"):
		$day_num_date_sel = "17";
	break;
case ("18"):
		$day_num_date_sel = "18";
	break;
case ("19"):
		$day_num_date_sel = "19";
	break;
case ("20"):
		$day_num_date_sel = "20";
	break;
	case ("21"):
		$day_num_date_sel = "21";
	break;
	case ("22"):
		$day_num_date_sel = "22";
	break;
case ("23"):
		$day_num_date_sel = "23";
	break;
	case ("24"):
		$day_num_date_sel = "24";
	break;
case ("25"):
		$day_num_date_sel = "25";
	break;
	case ("26"):
		$day_num_date_sel = "26";
	break;
case ("27"):
		$day_num_date_sel = "27";
	break;
	case ("28"):
		$day_num_date_sel = "28";
	break;
case ("29"):
		$day_num_date_sel = "29";
	break;
case ("30"):
		$day_num_date_sel = "30";
	break;
	case ("31"):
		$day_num_date_sel = "31";
	break;
endswitch;
	


switch($selected_year):

	case ("2014"):
		$year_num_date_sel = "2014";
	break;
	case ("2015"):
		$year_num_date_sel = "2015";
	break;
	case ("2016"):
		$year_num_date_sel = "2016";
	break;
case ("2017"):
		$year_num_date_sel = "2017";
	break;
case ("2018"):
		$year_num_date_sel = "2018";
	break;
	case ("2019"):
		$year_num_date_sel = "2019";
	break;
case ("2020"):
		$year_num_date_sel = "2020";
	break;
case ("2021"):
		$year_num_date_sel = "2021";
	break;
endswitch;

	

switch($selected_month):

	case ("Jan"):
		$month_num_date_sel = "01";
	break;
	case ("Feb"):
		$month_num_date_sel = "02";
	break;
	case ("Mar"):
		$month_num_date_sel = "03";
	break;
	case ("Apr"):
		$month_num_date_sel = "04";
	break;
	case ("May"):
		$month_num_date_sel = "05";
	break;
case ("Jun"):
		$month_num_date_sel = "06";
	break;
case ("Jul"):
		$month_num_date_sel = "07";
	break;
case ("Aug"):
		$month_num_date_sel = "08";
	break;
case ("Sep"):
		$month_num_date_sel = "09";
	break;
	case ("Oct"):
		$month_num_date_sel = "10";
	break;
case ("Nov"):
		$month_num_date_sel = "11";
	break;
	case ("Dec"):
		$month_num_date_sel = "12";
	break;

endswitch;

if($selected_hour == '5 to 7') {
		$jumkul = '5 to 7';
		}

if($selected_hour == '7 to 9') {
		$jumkul = '7 to 9';
		}

if($selected_hour == '9 to 11') {
		$jumkul = '9 to 11';
		}

if($selected_hour == '11 to 13') {
		$jumkul = '11 to 13';
		}

if($selected_hour == '13 to 15') {
		$jumkul = '13 to 15';
		}

if($selected_hour == '15 to 17') {
		$jumkul = '15 to 17';
		}

if($selected_hour == '17 to 19') {
		$jumkul = '17 to 19';
		}

if($selected_hour == '19 to 21') {
		$jumkul = '19 to 21';
		}

if($selected_hour == '21 to 23') {
		$jumkul = '21 to 23';
		}

$Selected_patchup_date = $year_num_date_sel."-".$month_num_date_sel."-".$day_num_date_sel;


	
	

include 'includelocaldb.php';
$personalscore = 0;
include 'personalfilter.php';



$dbconnect = mysql_connect($host,$name,$password);
$database = mysql_select_db($databasename, $dbconnect);

$Pan_Date_sql = "SELECT `DSDate` FROM `dateselectionrudi` where `dateselectionrudi`.`DSDate` = '{$Selected_patchup_date}'"; // + interval 3 day";
$Pan_Date_query = mysql_query($Pan_Date_sql);
$Pan_Date_Result =  mysql_result($Pan_Date_query,0,0);


$Pan_DongGong_sql = "SELECT `DongGongDay` FROM `dateselectionrudi` where `dateselectionrudi`.`DSDate` = '{$Selected_patchup_date}' "; // + interval 3 day";
$Pan_DongGong_query = mysql_query($Pan_DongGong_sql);
$Pan_DongGong_Result =  mysql_result($Pan_DongGong_query,0,0);

$Pan_DongGongDesc_sql = "SELECT `DongGongDesc` FROM `dateselectionrudi` where `dateselectionrudi`.`DSDate` = '{$Selected_patchup_date}' "; // + interval 3 day";
$Pan_DongGongDesc_query = mysql_query($Pan_DongGongDesc_sql);
$Pan_DongGongDesc_Result =  mysql_result($Pan_DongGongDesc_query,0,0);


$Pan_DayOfficer_sql = "SELECT `DayOfficer` FROM `dateselectionrudi` where `dateselectionrudi`.`DSDate` = '{$Selected_patchup_date}' "; // + interval 3 day";
$Pan_DayOfficer_query = mysql_query($Pan_DayOfficer_sql);
$Pan_DayOfficer_Result =  mysql_result($Pan_DayOfficer_query,0,0);

$Pan_DayOfficerFlavour_sql = "SELECT `DayOfficerFlavour` FROM `dateselectionrudi` where `dateselectionrudi`.`DSDate` = '{$Selected_patchup_date}' "; // + interval 3 day";
$Pan_DayOfficerFlavour_query = mysql_query($Pan_DayOfficerFlavour_sql);
$Pan_DayOfficerFlavour_Result =  mysql_result($Pan_DayOfficerFlavour_query,0,0);

$Pan_DayOfficerDesc_sql = "SELECT `DayOfficerDesc` FROM `dateselectionrudi` where `dateselectionrudi`.`DSDate` = '{$Selected_patchup_date}' "; // + interval 3 day";
$Pan_DayOfficerDesc_query = mysql_query($Pan_DayOfficerDesc_sql);
$Pan_DayOfficerDesc_Result =  mysql_result($Pan_DayOfficerDesc_query,0,0);


$Pan_DayConstell_sql = "SELECT `Constellation` FROM `dateselectionrudi` where `dateselectionrudi`.`DSDate` = '{$Selected_patchup_date}' "; // + interval 3 day";
$Pan_DayConstell_query = mysql_query($Pan_DayConstell_sql);
$Pan_DayConstell_Result =  mysql_result($Pan_DayConstell_query,0,0);

$Pan_DayConstellFlavour_sql = "SELECT `ConstellFlavour` FROM `dateselectionrudi` where `dateselectionrudi`.`DSDate` = '{$Selected_patchup_date}' "; // + interval 3 day";
$Pan_DayConstellFlavour_query = mysql_query($Pan_DayConstellFlavour_sql);
$Pan_DayConstellFlavour_Result =  mysql_result($Pan_DayConstellFlavour_query,0,0);

$Pan_DayConstellDesc_sql = "SELECT `ConstellationDesc` FROM `dateselectionrudi` where `dateselectionrudi`.`DSDate` = '{$Selected_patchup_date}' "; // + interval 3 day";
$Pan_DayConstellDesc_query = mysql_query($Pan_DayConstellDesc_sql);
$Pan_DayConstellDesc_Result =  mysql_result($Pan_DayConstellDesc_query,0,0);

$Pan_DayStem_sql = "SELECT `DayStem` FROM `dateselectionrudi` where `dateselectionrudi`.`DSDate` = '{$Selected_patchup_date}' "; // + interval 3 day";
$Pan_DayStem_query = mysql_query($Pan_DayStem_sql);
$Pan_DayStem_Result =  mysql_result($Pan_DayStem_query,0,0);

$Pan_DayBranch_sql = "SELECT `DayBranch` FROM `dateselectionrudi` where `dateselectionrudi`.`DSDate` = '{$Selected_patchup_date}' "; // + interval 3 day";
$Pan_DayBranch_query = mysql_query($Pan_DayBranch_sql);
$Pan_DayBranch_Result =  mysql_result($Pan_DayBranch_query,0,0);

$Pan_HourStem_sql = "SELECT `QMHourStem` FROM `qmdjpan` where `qmdjpan`.`QMDate` = '{$Selected_patchup_date}'  and `qmdjpan`.`QMTime` = '{$jumkul}'"; // + interval 3 Hour";
$Pan_HourStem_query = mysql_query($Pan_HourStem_sql);
$Pan_HourStem_Result =  mysql_result($Pan_HourStem_query,0,0);

$Pan_HourBranch_sql = "SELECT `QMHourBranch` FROM `qmdjpan` where `qmdjpan`.`QMDate` = '{$Selected_patchup_date}'  and `qmdjpan`.`QMTime` = '{$jumkul}'"; // + interval 3 Hour";
$Pan_HourBranch_query = mysql_query($Pan_HourBranch_sql);
$Pan_HourBranch_Result =  mysql_result($Pan_HourBranch_query,0,0);

// This is for the Monthly Data - different table

$Pan_MonthStem_sql = "SELECT `MonthStem` FROM `dateselectionrudi` where `dateselectionrudi`.`DSDate` = '{$Selected_patchup_date}' "; // + interval 3 Month";
$Pan_MonthStem_query = mysql_query($Pan_MonthStem_sql);
$Pan_MonthStem_Result =  mysql_result($Pan_MonthStem_query,0,0);

$Pan_MonthBranch_sql = "SELECT `MonthBranch` FROM `dateselectionrudi` where `dateselectionrudi`.`DSDate` = '{$Selected_patchup_date}' "; // + interval 3 Month";
$Pan_MonthBranch_query = mysql_query($Pan_MonthBranch_sql);
$Pan_MonthBranch_Result =  mysql_result($Pan_MonthBranch_query,0,0);

// This is for the Yearly Data - different table

$Pan_YearStem_sql = "SELECT `YearStem` FROM `dateselectionrudi` where `dateselectionrudi`.`DSDate` = '{$Selected_patchup_date}' "; // + interval 3 Year";
$Pan_YearStem_query = mysql_query($Pan_YearStem_sql);
$Pan_YearStem_Result =  mysql_result($Pan_YearStem_query,0,0);

$Pan_YearBranch_sql = "SELECT `YearBranch` FROM `dateselectionrudi` where `dateselectionrudi`.`DSDate` = '{$Selected_patchup_date}' "; // + interval 3 Year";
$Pan_YearBranch_query = mysql_query($Pan_YearBranch_sql);
$Pan_YearBranch_Result =  mysql_result($Pan_YearBranch_query,0,0);

$Readable_Date = date("d-M-Y",strtotime($Pan_Date_Result));

$Pan_YearBreakerDesc_sql = "SELECT `YearBreakerDesc` FROM `dateselectionrudi` where `dateselectionrudi`.`DSDate` = '{$Selected_patchup_date}' "; // + interval 3 Year";
$Pan_YearBreakerDesc_query = mysql_query($Pan_YearBreakerDesc_sql);
$Pan_YearBreakerDesc_Result =  mysql_result($Pan_YearBreakerDesc_query,0,0);

$Pan_YearRobDesc_sql = "SELECT `YearRobDesc` FROM `dateselectionrudi` where `dateselectionrudi`.`DSDate` = '{$Selected_patchup_date}' "; // + interval 3 Year";
$Pan_YearRobDesc_query = mysql_query($Pan_YearRobDesc_sql);
$Pan_YearRobDesc_Result =  mysql_result($Pan_YearRobDesc_query,0,0);

$Pan_YearCalSharDesc_sql = "SELECT `YearCalSharDesc` FROM `dateselectionrudi` where `dateselectionrudi`.`DSDate` = '{$Selected_patchup_date}' "; // + interval 3 Year";
$Pan_YearCalSharDesc_query = mysql_query($Pan_YearCalSharDesc_sql);
$Pan_YearCalSharDesc_Result =  mysql_result($Pan_YearCalSharDesc_query,0,0);

$Pan_AnnShaDesc_sql = "SELECT `AnnShaDesc` FROM `dateselectionrudi` where `dateselectionrudi`.`DSDate` = '{$Selected_patchup_date}' "; // + interval 3 Year";
$Pan_AnnShaDesc_query = mysql_query($Pan_AnnShaDesc_sql);
$Pan_AnnShaDesc_Result =  mysql_result($Pan_AnnShaDesc_query,0,0);

$Pan_MonthRobDesc_sql = "SELECT `MonthRobDesc` FROM `dateselectionrudi` where `dateselectionrudi`.`DSDate` = '{$Selected_patchup_date}' "; // + interval 3 Month";
$Pan_MonthRobDesc_query = mysql_query($Pan_MonthRobDesc_sql);
$Pan_MonthRobDesc_Result =  mysql_result($Pan_MonthRobDesc_query,0,0);

$Pan_MonthCalSharDesc_sql = "SELECT `MonthCalSharDesc` FROM `dateselectionrudi` where `dateselectionrudi`.`DSDate` = '{$Selected_patchup_date}' "; // + interval 3 Month";
$Pan_MonthCalSharDesc_query = mysql_query($Pan_MonthCalSharDesc_sql);
$Pan_MonthCalSharDesc_Result =  mysql_result($Pan_MonthCalSharDesc_query,0,0);

$Pan_MonthShaDesc_sql = "SELECT `MonthShaDesc` FROM `dateselectionrudi` where `dateselectionrudi`.`DSDate` = '{$Selected_patchup_date}' "; // + interval 3 Year";
$Pan_MonthShaDesc_query = mysql_query($Pan_MonthShaDesc_sql);
$Pan_MonthShaDesc_Result =  mysql_result($Pan_MonthShaDesc_query,0,0);

$Pan_YearlyAssetDescription_sql = "SELECT `YearlyAssetDescription` FROM `dateselectionrudi` where `dateselectionrudi`.`DSDate` = '{$Selected_patchup_date}' "; // + interval 3 Year";
$Pan_YearlyAssetDescription_query = mysql_query($Pan_YearlyAssetDescription_sql);
$Pan_YearlyAssetDescription_Result =  mysql_result($Pan_YearlyAssetDescription_query,0,0);

$Pan_YearlyProsperityDesc_sql = "SELECT `YearlyProsperityDesc` FROM `dateselectionrudi` where `dateselectionrudi`.`DSDate` = '{$Selected_patchup_date}' "; // + interval 3 Year";
$Pan_YearlyProsperityDesc_query = mysql_query($Pan_YearlyProsperityDesc_sql);
$Pan_YearlyProsperityDesc_Result =  mysql_result($Pan_YearlyProsperityDesc_query,0,0);

$Pan_MonthlyAssetDescription_sql = "SELECT `MonthlyAssetDescription` FROM `dateselectionrudi` where `dateselectionrudi`.`DSDate` = '{$Selected_patchup_date}' "; // + interval 3 Year";
$Pan_MonthlyAssetDescription_query = mysql_query($Pan_MonthlyAssetDescription_sql);
$Pan_MonthlyAssetDescription_Result =  mysql_result($Pan_MonthlyAssetDescription_query,0,0);

$Pan_AuspPoint_sql = "SELECT `Ausp` FROM `dateselectionrudi` where `dateselectionrudi`.`DSDate` = '{$Selected_patchup_date}' "; // + interval 3 Year";
$Pan_AuspPoint_query = mysql_query($Pan_AuspPoint_sql);
$Pan_AuspPoint_Result =  mysql_result($Pan_AuspPoint_query,0,0);

$Pan_ImportantPoint_sql = "SELECT `Important` FROM `dateselectionrudi` where `dateselectionrudi`.`DSDate` = '{$Selected_patchup_date}' "; // + interval 3 Year";
$Pan_ImportantPoint_query = mysql_query($Pan_ImportantPoint_sql);
$Pan_ImportantPoint_Result =  mysql_result($Pan_ImportantPoint_query,0,0);

$thisdaytosee = $Pan_DayStem_Result;
$thisdaytoseebranch = $Pan_DayBranch_Result;
		 	
		 	 	
		 	if($thisdaytosee==$personal_daystem_clash1_result) {
		 		$personalscore = $personalscore - 2;
		 		$pstemclash1 = "This Day Clashes with you, exercize caution, even if the overall day is good. Be even more careful in carrying out important activities if the day score is bad"; 
		 			 		} elseif($thisdaytosee==$personal_daystem_clash2_result) {
		 		$personalscore = $personalscore - 1; 
		 		$pstemclash2 = "This Day Clashes with you - exercize caution. Even if the overall day is good. Be even more careful in carrying out important activities - if the day score is bad";
		 			 		} else{$personalscore = 0 ; 
		 			 		}		 	
			
			if($thisdaytoseebranch==$personal_daybranch_clash_result) {
		 		$personalscore = $personalscore - 2;
		 		$pbranchclash = "This is a total clash day, avoid for all important actvities - even if the general day score is good. Be even more careful in carrying out important activities if the day score is bad"; 
		 			 		}
		 	
		 	if($thisdaytoseebranch==$personal_daybranch_combo_result) {
		 		$personalscore = $personalscore + 2; 
		 		$pstemcombo = "Personally, this is a good day, and if there are no negative stars - and the overall day score is good, use this day to your advantage.";
		 			 		}
		 	
		 	if($thisdaytosee==$personal_daystem_combo_result) {
		 		$personalscore = $personalscore + 2;
		 		$pbranchcombo = "Personally, this is a good day, and if there are no negative stars - and the overall day score is good, use this day to your advantage."; 
		 			 		}
		 	if($thisdaytoseebranch==$personal_nobleman_result) {
		 		$personalscore = $personalscore + 2;
		 		$pnobleman = "This is a good day. If there are less negative stars and the day score is good, use this to seek favours from important people, or carry our important activities. If the day score is bad or if there many negative stars - this day would minimize personal negatives."; 
		 			 		}
		 	if($thisdaytoseebranch==$personal_noble1_result) {
		 		$personalscore = $personalscore + 2;
		 		$pnoble1 = "This is a nobleman day. If there are less negative stars and the day score is good, use this to seek favours from important people, or carry our important activities. If the day score is bad or if there many negative stars - this day would minimize personal negatives."; 
		 			 		}
		 	if($thisdaytoseebranch==$personal_noble2_result) {
		 		$personalscore = $personalscore + 2;
		 		$pnoble2 = "This is a nobleman day. If there are less negative stars and the day score is good, use this to seek favours from important people, or carry our important activities. If the day score is bad or if there many negative stars - this day would minimize personal negatives."; 
		 			 		}
		 	if($thisdaytosee==$personal_egain_result) {
		 		$personalscore = $personalscore + 1;
		 		$pegain = "This is a good day, especially for banking, money, gains, purchases, investments etc. However - if there are negative stars present or the day score is not supportive, use it only for minor activities."; 
		 			 		}
		 	if($thisdaytosee==$personal_uegain1_result) {
		 		$personalscore = $personalscore + 1; 
		 		$puegain1 = "This is a good day, with unexpected benefits, especially for banking, money, gains, purchases, investments etc. However - if there are negative stars present or the day score is not supportive, use it only for minor activities.";
		 			 		}
		 	if($thisdaytosee==$personal_uegain2_result) {
		 		$personalscore = $personalscore + 1; 
		 		$puegain2 = "This is a good day, with unexpected benefits, especially for banking, money, gains, purchases, investments etc. However - if there are negative stars present or the day score is not supportive, use it only for minor activities.";
		 			 		}
	 		if($thisdaytosee==$personal_uhelp1_result) {
		 		$personalscore = $personalscore + 1; 
		 		$phelp1 = "This is a good day, to approach important people, asking for favours, or for receiving help from people. If you have personal good stars and the day rating is positive - look for unexpected benefits. Use with caution - if the day score is not good or you have more personal negative stars.";
		 			 		}
		 	if($thisdaytosee==$personal_uhelp2_result) {
		 		$personalscore = $personalscore + 1;
		 		$phelp2 = "This is a good day, to approach important people, asking for favours, or for receiving help from people. If you have personal good stars and the day rating is positive - look for unexpected benefits. Use with caution - if the day score is not good or you have more personal negative stars."; 
		 			 		}
		 	if($thisdaytosee==$personal_sevenk_result) {
		 		$personalscore = $personalscore - 1;
		 		 $psk = "Chances of Stress or Injury are indicated, if the day is good or you have good positive stars - it may not be something to worry about. However, if you have other negative stars or the day score is bad - it would be best to be careful";
		 			 		}
		 	if($thisdaytoseebranch==$personal_bknife_result) {
		 		$personalscore = $personalscore - 1;
		 		$pbk = "Chances of Stress or Injury are indicated, if the day is good or you have good positive stars - it may not be something to worry about. However, if you have other negative stars or the day score is bad - it would be best to be careful"; 
		 			 		}
		 	if($thisdaytoseebranch==$personal_illness_result) {
		 		$personalscore = $personalscore - 1;
		 		$pill = "Avoid Seeking Medical Appointments or undertaking a medical procedure or medicines on this day. If the Day score is bad or you have more negative stars, it is better to avoid this day altogeather."; 
		 			 		}
		 	if($thisdaytoseebranch==$personal_doctor_result) {
		 		$personalscore = $personalscore + 1; 
		 		$pdoc = "This is a good day for seeking medical treatment, startinng new medicines or for health related activities. If the day score is negative - or you have more negative stars, avoid using this day.";
		 			 		}
		 			 		
		 	if($thisdaytosee==$personal_daystem_result) {
		 	$personalscore = $personalscore + 1; 
		 	$psame1 = "This day lends to you a lot of strength, especially if there are more personal stars or the day score is good.";
		 	 		}
		 		 		
		 	if($thisdaytoseebranch==$personal_daybranch_result) {
		 		$personalscore = $personalscore + 1;
		 		$psame2 = "This day lends to you a lot of strength, especially if there are more personal stars or the day score is good."; 
	 			 		}


mysql_close($dbconnect);

?>

<div id="">

<table border="2" style="width:400px">
	<tr>
		<th > <?php echo "Date"; ?></th>
		<th > <?php echo "Time"; ?></th>
		<!--		
		<th ><?php echo "Hour"; ?></th>
		<th ><?php echo "Day"; ?></th>
		<th ><?php echo "Month"; ?></th>
		<th ><?php echo "Year"; ?></th>
		-->
		<th ><?php echo "Day Score"; ?></th>
		<th ><?php echo "Personal Score"; ?></th>
		
			
	</tr>
	<tr>
		<td  rowspan="2"> <?php echo $Readable_Date; ?> </td>
		<td  rowspan="2"> <?php echo $jumkul; ?> </td>
		<!--		
		<td ><?php echo $Pan_HourStem_Result; ?> </td>
		<td ><?php echo $Pan_DayStem_Result; ?> </td>
		<td ><?php echo $Pan_MonthStem_Result; ?> </td>
		<td ><?php echo $Pan_YearStem_Result; ?> </td>
		-->
		<td  rowspan="2"><?php echo $Pan_ImportantPoint_Result; ?> </td>
		<td  rowspan="2"><?php echo $personalscore; ?> </td>				
	</tr>			
	<!--
	<tr>	
		<td ><?php echo $Pan_HourBranch_Result; ?> </td>		
		<td ><?php echo $Pan_DayBranch_Result; ?> </td>
		<td ><?php echo $Pan_MonthBranch_Result; ?> </td>
		<td ><?php echo $Pan_YearBranch_Result; ?> </td>
		-->	
		
	</tr>
</table>

</div>

<br>
<div id="">
<table border="1" style="width:900px">
	<tr>
		<th rowspan="13"> <?php echo "Personal - Positives"; ?></th>
		<td > <?php echo $pstemcombo; ?></th>		
	</tr>
	<tr>	
		<td > <?php echo $branchcombo; ?></th>		
	</tr>
	<tr>
		<td > <?php echo $pnobleman; ?></th>		
	</tr>
	<tr>
		<td > <?php echo $noble1; ?></th>		
	</tr>
	<tr>
		<td > <?php echo $pnoble2; ?></th>		
	</tr>
	<tr>
		<td > <?php echo $pegain; ?></th>		
	</tr>
	<tr>
		<td > <?php echo $upegain1; ?></th>		
	</tr>
	<tr>
		<td > <?php echo $upegain2; ?></th>		
	</tr>
	<tr>
		<td > <?php echo $phelp1; ?></th>		
	</tr>
	<tr>
		<td > <?php echo $phelp2; ?></th>		
	</tr>
	<tr>
		<td > <?php echo $pdoc; ?></th>		
	</tr>
	<tr>
		<td > <?php echo $same1; ?></th>		
	</tr>
	<tr>
		<td > <?php echo $psame2; ?></th>		
	</tr>

</table>


</div>


<br>
<div id="">
<table border="1" style="width:900px">
	<tr>
		<th rowspan="6"> <?php echo "Personal -  Negatives"; ?></th>
		<td > <?php echo $pstemclash1; ?></th>		
	</tr>
	<tr>	
		<td > <?php echo $pstemclash2; ?></th>		
	</tr>
	<tr>
		<td > <?php echo $pbranchclash; ?></th>		
	</tr>
	<tr>
		<td > <?php echo $psk; ?></th>		
	</tr>
	<tr>
		<td > <?php echo $pbk; ?></th>		
	</tr>
	<tr>
		<td > <?php echo $pill; ?></th>		
	</tr>

</table>


</div>


<br>
<!--
<div id="">
<table border="1" style="width:900px">
	<tr>
		<th > <?php echo "Dong Gong Rating"; ?></th>
		<td > <?php echo $Pan_DongGong_Result; ?></th>		
	</tr>
	
	<tr>
		<th > <?php echo "Description"; ?></th>
		<td > <?php echo $Pan_DongGongDesc_Result; ?></th>
		
	</tr>
	

</table>


</div>
<br>
<div id="">
<table border="1" style="width:900px">
	<tr>
		<th > <?php echo "Day Officer"; ?></th>
		<td > <?php echo $Pan_DayOfficer_Result; ?></th>		
	</tr>
	
	<tr>
		<th > <?php echo "Outlook"; ?></th>
		<td > <?php echo $Pan_DayOfficerFlavour_Result; ?></th>
		
	</tr>
	
	<tr>
		<th > <?php echo "Description"; ?></th>
		<td > <?php echo $Pan_DayOfficerDesc_Result; ?></th>
		
	</tr>

</table>


</div>

<br>

<div id="">
<table border="1" style="width:900px">
	<tr>
		<th > <?php echo "Constellation"; ?></th>
		<td > <?php echo $Pan_DayConstell_Result; ?></th>		
	</tr>
	
	<tr>
		<th > <?php echo "Outlook"; ?></th>
		<td > <?php echo $Pan_DayConstellFlavour_Result; ?></th>
		
	</tr>
	
	<tr>
		<th > <?php echo "Description"; ?></th>
		<td > <?php echo $Pan_DayConstellDesc_Result; ?></th>
		
	</tr>

</table>


</div>
<br>
-->
<div id="">
<table border="1" style="width:900px">
	<tr>
		<th > <?php echo "Day Negatives"; ?></th>				
	</tr>
	<tr>		
		<td > <?php echo $Pan_YearBreakerDesc_Result; ?></th>				
	</tr>
	<tr>		
		<td > <?php echo $Pan_YearRobDesc_Result; ?></th>		
	</tr>
	<tr>		
		<td > <?php echo $Pan_YearCalSharDesc_Result; ?></th>		
	</tr>
	<tr>		
		<td > <?php echo $Pan_AnnShaDesc_Result; ?></th>		
	</tr>
	<tr>		
		<td > <?php echo $Pan_MonthRobDesc_Result; ?></th>		
	</tr>
	<tr>		
		<td > <?php echo $Pan_MonthCalSharDesc_Result; ?></th>		
	</tr>
	<tr>		
		<td > <?php echo $Pan_MonthShaDesc_Result; ?></th>		
	</tr>
	
</table>


</div>

<br>

<div id="">
<table border="1" style="width:900px">
	<tr>
		<th > <?php echo "Day Positives"; ?></th>				
	</tr>	
	<tr>		
		<td > <?php echo $Pan_YearlyAssetDescription_Result; ?></th>		
	</tr>
		<tr>		
		<td > <?php echo $Pan_YearlyProsperityDesc_Result; ?></th>		
	</tr>

	<tr>		
		<td > <?php echo $Pan_MonthlyAssetDescription_Result; ?></th>		
	</tr>
</table>


</div>


<br>
