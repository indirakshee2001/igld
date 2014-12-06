<?php
session_start();

if(!isset($_SESSION['thisusername'])) {

exit('<h2>Mismatch</h2>Sorry, you must enter a valid username and password to log in and access this page. If you ' .
   'aren\'t a registered member, please contact indrakshiguild@gmail.com - To Log in please <a href="memlogin.html">click here</a>');

} else {
	
	echo "You have Successfully Logged in as - " . 	$_SESSION['thisusername'];
		
	$This_User = trim($_SESSION['thisusername']);
	
	include 'includelocaldb.php';
	
	$userdbconnect = mysql_connect($host,$name,$password);
	$userdatabase = mysql_select_db($databasename, $userdbconnect);

	$Member_Type_sql = "Select `clienttype` from `members` where `members`.`username` = '{$This_User}'"; 
	$Member_Type_query = mysql_query($Member_Type_sql);
	$Member_Type_Result =  mysql_result($Member_Type_query,0,0);
	}
	//if($Member_Type_Result == "subscriber") {
						
						
		//	$Member_Credit_sql = "Select `creditbal` from `members` where `members`.`username` = '{$This_User}'"; 
			//$Member_Credit_query = mysql_query($Member_Credit_sql);
			//$Member_Credit_Result =  mysql_result($Member_Credit_query,0,0);
			//echo " - and your credit balance is ". $Member_Credit_Result;
			
			//$newcredit = $Member_Credit_Result + 1 ;  
			//$Member_NowCredit_sql = "update `members` set `creditbal`= '{$newcredit}'where `members`.`username` = '{$This_User}'"; 
			//$Member_NowCredit_query = mysql_query($Member_NowCredit_sql);			
			 
		//} 
		
	
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
			
		if($Member_Type_Result == "member") {
			exit('<h2>Mismatch</h2>Sorry, you cannot access this section.');
		} 
		
		if($Member_Type_Result == "subscriber") {
			exit('<h2>Mismatch</h2>Sorry, you cannot access this section.'); 
		}		
		
		if($Member_Type_Result == "guildmember") {
			$Member_Valid_sql = "Select `validto` from `members` where `members`.`username` = '{$This_User}'"; 
			$Member_Valid_query = mysql_query($Member_Valid_sql);
			$Member_Valid_Result =  mysql_result($Member_Valid_query,0,0);
			echo " - you can use this software till ". $Member_Valid_Result;
			$_SESSION['guildmember']='Yes';			
			 
		} 
	
	
	echo "<br>";

//global $actualcreditscore;

//$actualcreditscore = $Member_Credit_Result;
//echo $actualcreditscore;
?>

<html>

<script type = 'text/javascript'>
document.onkeydown = function() {    
    switch (event.keyCode) { 
             
         case 37: 
         if (event.altKey)  {   
			window.close();
         window.open('memlogout.php', '_blank');	         
         //event.returnValue = false; 
         //event.keyCode = 0;  
         return false; 
         }
         
          case 39: 
         if (event.altKey)  {   
			window.close();
         window.open('memlogout.php', '_blank');	         
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
<link type="text/css" rel="stylesheet" href="dateselectionstyle.css" />
<br>
<a href="memlogin.html" class="logoutpan"> Back</a> &nbsp <a href="memlogout.php" class="logoutpan"> Log Out</a> &nbsp (Avoid Refreshing or Going Back, you may be logged out)
<br>
<br>
<br>
<a href="filterdatemem.php" class="logoutpan">Date Selection Filters</a>
<br>
<br>
<br>
<a href="dateselectpersonalmem.php" class="logoutpan">How does a day affect you personally?</a>

</html>
