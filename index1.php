<?php
include ("validations.php");
require_once("./PDO.DB.class.php");
$db= new DB();

//
if(!empty($_SESSION['loggedIn'])){
     header("location: first.php");
     exit();
 }
	if(isset($_POST['submit'])){
		$first = isset($_POST['fname']) ? trim($_POST['fname']) : '';
		$psw = isset($_POST['psw']) ? trim($_POST['psw']) : '';
    $psw= hash('sha256',$psw);
    $role = $_POST['radio'];
    
		if(alphabetic($first) || strlen($first) < 30 ) {
      $data=$db->check($first,$psw,$role);
     
      if($data>0){
       // echo $data["idattendee"];

        //Setting Cookie
        session_name("user");
        session_start();
        $expire = time()+600;
        $domain = "solace.ist.rit.edu";
        $secure=false;
        $user_id =  $data["idattendee"]; 
        setcookie("loggin",$user_id,$expire,$domain,$secure);
        session_name("user");
        session_start();
        $expire = time()+600;
        $domain = "solace.ist.rit.edu";
        $secure=false;
        $user_id =  $data["role"]; 
        setcookie("loggin2",$user_id,$expire,$domain,$secure);

        $_SESSION['loggedIn'] = true;  
        if($user_id==1){
      header("location: admin/admin.php");}
      elseif($user_id==2){
        header("location: ./manager/manager.php");
      }
      else{
        header("location: first.php");
      }
  		}
    }
      else{
            echo "<br />Enter valid Name :| <br />";
  		}
  			
  	
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/index1.css">
  </head>
  <body>
    <form  action = "<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <h1>SIGN UP</h1>
      <div class="icon">
        <i class="fas fa-user-circle"></i>
      </div>
      <div class="formcontainer">
      <div class="container">
        <label for="fname"><bold>Username</bold></label>
        <input type="text" placeholder="Enter Username" name="fname" required>
        <label for="psw"><bold>Password</bold></label>
        <input type="password" placeholder="Enter Password" name="psw" required>
      </div>
      <div>
      <label>
        <input type="radio" name="radio" value="1">Admin
    </label>
    <label>
        <input type="radio" name="radio" value="2">Manager
    </label>
    <label>
        <input type="radio" name="radio" value="3">User
    </label>
  </div>
  <div>
      <button  type="submit" name="submit" value="submit"><bold>SIGN UP</bold></button>
    </form>
  </body>
</html>