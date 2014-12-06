<?php

session_start();

  // Clear the error message
$error_msg = "";
  

include 'includelocaldb.php';


$user_username = $_POST['usname'];
$user_password = $_POST['pword'];

$reshapw = sha1($user_password);

//echo $user_username;
//echo $user_password;
//echo $reshapw;

	

$query = "Select `username` from `members` where `members`.`username` = '{$user_username}' and `upword` = '{$reshapw}'"; 
$data = mysql_query($query);
$Pan_Date_Result =  mysql_result($data,0,0);



		

	
if (mysql_num_rows($data) == 1) {
	 $_SESSION['thisusername'] = $user_username;
	 echo "You Have Successfully Logged in as " .$user_username;    	
    header('Location: dateselectlandingmem.php');    
    }
     
else {
    // The username/password are incorrect so send the authentication headers
        exit('<h2>Mismatch</h2>Sorry, you must enter a valid username and password to log in and access this page. If you ' .
    'aren\'t a registered member, please contact indrakshiguild@gmail.com');
  }
  
 
  
?>


