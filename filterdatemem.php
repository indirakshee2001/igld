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

}

echo " and you are a " . $Member_Type_Result;

if($Member_Type_Result == "master") {
			echo " - you have no limitations on the use of this software";
			$validtill = "None";
			}
		
if($Member_Type_Result == "") {
			exit('<h2>Mismatch</h2>Sorry, you must enter a valid username and password to log in and access this page. If you ' .
    'aren\'t a registered member, please <a href="joinmailing.html">sign up</a>. To Log in please <a href="subslogin.html">click here</a>');

			}
			
if($Member_Type_Result == "array()") {
			echo " - you have no limitations on the use of this software";
			$validtill = "None";
			}
			
if($Member_Type_Result == "Member") {
			exit('<h2>Mismatch</h2>Sorry, you do not have access to this section'); 
		}
		
		if($Member_Type_Result == "subscriber") {
			exit('<h2>Mismatch</h2>Sorry, you do not have access to this section'); 
		}		
if($Member_Type_Result != "master" and $Member_Type_Result != "guildmember" ) {
	
		exit('<h2>Mismatch</h2>Sorry, you cannot access this session');
} else {
				if($Member_Type_Result == "guildmember"){
			$Member_Valid_sql = "Select `validto` from `members` where `members`.`username` = '{$This_User}'"; 
			$Member_Valid_query = mysql_query($Member_Valid_sql);
			$Member_Valid_Result =  mysql_result($Member_Valid_query,0,0);
			echo " - you can use this software till ". $Member_Valid_Result;
			
				$thisisnowdate = date('d');
				$thisisnowmonth = date('M');
				$thisisnowyear = date('y');
				$thisisthenow = $thisisnowyear."-".$thisisnowmonth."-".$thisisnowdate;
			
					if ($Member_Valid_Result <  date('Y-m-d')) {
						exit('Sorry, you have run out of validity to access the software. please contact indrakshiguild@gmail.com');
					}
				}
	}

$_SESSION['goahead7']	 = "Yes";	
$_SESSION['goahead30']	 = "Yes";
$_SESSION['goahead60']	 = "Yes";
$_SESSION['goaheadyear']	 = "Yes";
$_SESSION['goahead7good']	 = "Yes";
$_SESSION['goahead30good']	 = "Yes";
$_SESSION['goahead60good']	 = "Yes";
$_SESSION['goaheadyeargood']	 = "Yes";
$_SESSION['goahead7rg']	 = "Yes";	
$_SESSION['goahead30rg']	 = "Yes";
$_SESSION['goahead60rg']	 = "Yes";	
$_SESSION['goaheadyearrg']	 = "Yes";
$_SESSION['goaheadbusiness']	 = "Yes";
$_SESSION['goaheadjv']	 = "Yes";
$_SESSION['goaheadharvest']	 = "Yes";
$_SESSION['goaheadbank']	 = "Yes";
$_SESSION['goaheadlegal']	 = "Yes";
$_SESSION['goaheadprop']	 = "Yes";
$_SESSION['goaheadground']	 = "Yes";	
$_SESSION['goaheadcons']	 = "Yes";
$_SESSION['goaheadreno']	 = "Yes";
$_SESSION['goaheadwell']	 = "Yes";
$_SESSION['goaheaddemo']	 = "Yes";	
$_SESSION['goaheadwarm']	 = "Yes";	
$_SESSION['goaheadrem']	 = "Yes";
$_SESSION['goaheadbed']	 = "Yes";	
$_SESSION['goaheadmarry']	 = "Yes";
$_SESSION['goaheadtravel']	 = "Yes";
$_SESSION['goaheadmedi']	 = "Yes";	
$_SESSION['goaheadstudy'] ="yes";
$_SESSION['goaheadnoble']	 = "Yes";	
$_SESSION['goaheadask']	 = "Yes";
$_SESSION['goaheadimpt']	 = "Yes";	
$_SESSION['goaheadbegin']	 = "Yes";	
$_SESSION['goaheadlongshort']	 = "Yes";		
	
	echo "<br>";
?>

<link type="text/css" rel="stylesheet" href="dateselectionstyle.css" />
<head>
<h3>Date Selection Filters</h3>
<a href="dateselectlandingmem.php" class="logoutpan"> Back</a> &nbsp <a href="memlogout.php" class="logoutpan"> Log Out</a> &nbsp (Avoid Refreshing or Going Back, you may be logged out)
<script type = 'text/javascript'>
document.onkeydown = function() {    
    switch (event.keyCode) { 
        case 116 : //F5 button
				window.close();
         	window.open('memlogout.php', '_blank');            
            event.returnValue = false;
            event.keyCode = 0;
            return false;
             
			
        case 82 : //R button
            if (event.ctrlKey) { 
					 window.close();
         		 window.open('memlogout.php', '_blank');	                
                event.returnValue = false; 
                event.keyCode = 0;  
                return false; 
            }    
         case 8:
         window.close();
         window.open('memlogout.php', '_blank');
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
window.open('memlogout.php', '_blank'); 

}


</script>


</head>
<br>
<br>
<p class="Ordday">All Days at a Glance (Good and Bad)</p>
<a href="days7mem.php" class="logoutpan">Week</a>
<a href="days30mem.php" class="logoutpan">Month</a>
<a href="dates60mem.php" class="logoutpan">Bi-Monthly</a>
<a href="yearallmem.php" class="logoutpan">Year</a>
<br>


<p class="Ordday">Good Days (For Less Important Work)</p>
<a href="gooddays7mem.php" class="logoutpan">Week</a>
<a href="gooddays30mem.php" class="logoutpan">Month</a>
<a href="gooddays60mem.php" class="logoutpan">Bi-Monthly</a>
<a href="goodyearmem.php" class="logoutpan">Year</a>
<br>

<p class="Ordday">Really Good Days (For Very Important work or Major Undertakings)</p>
<a href="reallygooddays7mem.php" class="logoutpan">Week</a>
<a href="reallygooddays30mem.php" class="logoutpan">Month</a>
<a href="reallygooddays60mem.php" class="logoutpan">Bi-Monthly</a>
<a href="reallygoodyearmem.php" class="logoutpan">Year</a>
<br>
<br>
<br>
<p class="Ordday">Advanced Filters(Bi-Monthly)</p>

<p class="Ordday">Business / Commercial </p>
<a href="businessdaysmem.php" class="logoutpan"> Business / Commercial / Trading </a> &nbsp
<br>
<br>
<a href="jvnegodaysmem.php" class="logoutpan"> Joint Ventures / Negotiations </a>
<br>
<br>
<a href="harvestdaysmem.php" class="logoutpan">Harvest</a>

<p class="Ordday">Banking / Legal / Property</p>
<a href="bankdaysmem.php" class="logoutpan">Important Banking</a> &nbsp
<br>
<br>
<a href="legaldaysmem.php" class="logoutpan"> Legal / Documents / Contracts </a> &nbsp
<br>
<br>
<a href="propertydaysmem.php" class="logoutpan">Property Matters</a>

<p class="Ordday">Construction / Renovation </p>
<a href="grounddaysmem.php" class="logoutpan"> Ground Breaking / Excavation / Clearing </a> &nbsp
<br>
<br>
<a href="consdaysmem.php" class="logoutpan"> Beginning Construction / Columns / Frames / Doors</a> &nbsp 
<br>
<br>
<a href="rennodaysmem.php" class="logoutpan"> Renovation </a>
<br>
<br>
<a href="welldaysmem.php" class="logoutpan">Digging Wells / Water Tanks</a>
<br>
<br>
<a href="demodaysmem.php" class="logoutpan">Demolish / Close / Remove</a>


<p class="Ordday">Home / FS Related </p>
<a href="housewarmdaysmem.php" class="logoutpan">House Warming / Prayers</a>
<br>
<br>
<a href="rempraydaysmem.php" class="logoutpan"> Remedies / Prayers</a>
<br>
<br>
<a href="bedmovedaysmem.php" class="logoutpan">Moving Bed / Desk</a>

<p class="Ordday">Personal</p>
<a href="marriagefamdaysmem.php" class="logoutpan">Marriage / Family</a>
<br>
<br>
<a href="traveldaysmem.php" class="logoutpan">Travel</a>

<br>
<br>
<a href="medidaysmem.php" class="logoutpan">Medical</a>
<br>
<br>
<a href="studydaysmem.php" class="logoutpan"> Study / Academics </a>
<p class="Ordday">Nobleman / Asking</p>
<a href="nobledaysmem.php" class="logoutpan">Nobleman Related</a>
<br>
<br>
<a href="askdaysmem.php" class="logoutpan">Asking Favours / Debt Collection</a>

<p class="Ordday">Important Work</p>
<a href="imptdaysmem.php" class="logoutpan">Important Days</a>
<br>
<br>
<a href="begindaysmem.php" class="logoutpan"> New Beginnings /  Expansion</a>
<br>
<br>
<a href="longshortdaysmem.php" class="logoutpan"> Long / Short Term Activities </a>





