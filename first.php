<?php
require_once"./PDO.DB.class.php";
$db = new DB();
$data = $db->getAllEvents();
session_name("user");
session_start();
if(isset($_SESSION['loggedIn'])){
    if(empty($_SESSION['loggedIn'])){
    header("location: index1.php");}
}   
/* if(isset($_COOKIE['loggin2'])){
    if($_COOKIE["loggin2"]!=2){
    header("location: index1.php");
  } } */
if(isset($_POST['logout'])) {

    session_unset();
               session_destroy();
               header("location: index1.php");
}

if(isset($_POST['delete'])){
    $id=$_COOKIE["loggin"];
   $session= $_POST['delete'];
 $db->delete_usr($id,$session);
   

}
if(isset($_POST['reg_user'])){
    $id=$_COOKIE["loggin"];
    $ses=$_POST['reg_user'];
    $usr_reg_event=$_POST['evnt_id_reg'];
  $db->reg_usr($id,$usr_reg_event,$ses);


}

if(isset($_POST['update'])){
if(isset($_POST['select1'])){
    $old_value=$_POST['update'];
    $id=$_COOKIE["loggin"];
    $value=$_POST['select1'];

 $db->update_session_user($id,$value,$old_value,);
 }
}
?>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/file.css">
    <link rel="stylesheet" href="./css/first.css">

   <link rel="apple-touch-icon" type="image/png" href="https://cpwebassets.codepen.io/assets/favicon/apple-touch-icon-5ae1a0698dcc2402e9712f7d01ed509a57814f994c660df9f7a952f3060705ee.png">
<meta name="apple-mobile-web-app-title" content="CodePen">

<link rel="shortcut icon" type="image/x-icon" href="https://cpwebassets.codepen.io/assets/favicon/favicon-aec34940fbc1a6e787974dcd360f2c6b63348d4b1f4e06c77743096d55480f33.ico">

<link rel="mask-icon" type="image/x-icon" href="https://cpwebassets.codepen.io/assets/favicon/logo-pin-8f3771b1072e3c38bd662872f6b673a722f4b3ca2421637d5596661b4e2132cc.svg" color="#111">


  <title>CodePen - Nav Tab</title>
  
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  

    <script>
    window.console = window.console || function(t) {};
    </script>



    <script>
    if (document.location.search.match(/type=embed/gi)) {
        window.parent.postMessage("resize", "*");
    }
    </script>
</head>

<body translate="no" data-new-gr-c-s-check-loaded="14.1052.0" data-gr-ext-installed="">
    <div class="content">
        <form method="post">
            <button type="submit" class='bttn' name="logout" value="logout"> Logout </button> 
        </form>
        <!-- Nav pills -->
        <ul class="nav nav-pills" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#login">Events</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#regis">Register</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div id="login" class="container tab-pane active">
                <ul>
                    <?php  $Stringdata="";

foreach($data as $i){
    $Stringdata= $i->whoAmI();
   
    
  $img=$Stringdata["name"].'.jpg';  
  $ses_data=$db->getsess($Stringdata["idevent"]);
  
  
    echo"
  
    <li class='booking-card'
            style='background-image: url(./assets/$img)'> 
            <div class='book-container'>
                <div class='content'>
                ";
                    foreach($ses_data as $j){
                        $Sata= $j->sess();
                   echo"<form action='' method='post'><button class='btn' type='submit' name='reg_user' value='$Sata[idsession]'>  $Sata[name]</button>
                   <input type='hidden' name='evnt_id_reg' value='$Stringdata[idevent]'>
                   </form>";                  
                 }
            echo"</div>
            </div>
            <div class='informations-container'>
                <h2 class='title' name='usr_reg_event'>$Stringdata[name]</h2>
                <p class='sub-title'>Hover here to view more Details</p>
                <h5 class='price'><svg class='icon' style='width:24px;height:24px' viewBox='0 0 24 24'>
                        <path fill='currentColor'
                            d='M3,6H21V18H3V6M12,9A3,3 0 0,1 15,12A3,3 0 0,1 12,15A3,3 0 0,1 9,12A3,3 0 0,1 12,9M7,8A2,2 0 0,1 5,10V14A2,2 0 0,1 7,16H17A2,2 0 0,1 19,14V10A2,2 0 0,1 17,8H7Z'>
                        </path>
                    </svg>Venue : $Stringdata[venue_name]</h5>
                <div class='more-information'>
                    <div class='info-and-date-container'>
                        <div class='box info'>
                            <svg class='icon' style='width:24px;height:24px' viewBox='0 0 24 24'>
                                <path fill='currentColor'
                                    d='M11,9H13V7H11M12,20C7.59,20 4,16.41 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20,12C20,16.41 16.41,20 12,20M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M11,17H13V11H11V17Z'>
                                </path>
                            </svg>
                            <p>People Allowed :$Stringdata[numberallowed]</p>
                        </div>
                        <div class='box date'>
                            <svg class='icon' style='width:24px;height:24px' viewBox='0 0 24 24'>
                                <path fill='currentColor'
                                    d='M19,19H5V8H19M16,1V3H8V1H6V3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3H18V1M17,12H12V17H17V12Z'>
                                </path>
                            </svg>
                            <p>$Stringdata[datestart]</p>
                        </div>
                    </div>";
                    foreach($ses_data as $j){
                        $Sata= $j->sess();
                   echo" <p class='disclaimer'>$Sata[name] </p>";
                   
                }
                echo"
                </div>
            </div>
        </li>
     
        ";
        
}    
?>
                </ul>
            </div>
            <?php
          


$user_id=$_COOKIE["loggin"];


        
      echo"<div id='regis' class='container tab-pane fade'>";
      $getuserReg=$db->getuserReg($user_id);
           foreach ($getuserReg as $k) {

        $event=$k['event_id'];
        $data_name=$db->update_session($event);
               echo"
           <ul>
           <li class='reg_list'>
           <div class='temp_list' >
           <div class='title_li'>
           <p  >Event : $k[name]</p>
           </div>
           <form action=''  method='post'>
           <select type='submit' name='select1' >
           <option >$k[session_name]</option>";
           foreach ($data_name as $l){

               echo"<option value='$l[1]'>$l[0]</option>";
           }
          
           echo"
           </select>
           ";
          
       
             //
         echo"
           <p>Venue :$k[venue]</p> 
           <p>Start date :$k[startdate]</p> 
           <p>End date :$k[enddate]</p>
          
           <button  id='delete' class='bttn' type='submit' name='delete' value='$k[id]'>DELETE</button>
           <button id='update' class='bttn' type='submit' name='update' value='$k[id]' >UPDATE </button>
       </form>
       ";
    echo"
    </div>
        </li>
           </ul>";
    }
          echo"</div>";
          
          
       
        

?>


        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>