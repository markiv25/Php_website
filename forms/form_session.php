<?php
include ("./nav.php");
require_once"../PDO.DB.class.php";
$db = new DB();

$id=$_COOKIE["loggin"];
if(empty($_SESSION['loggedIn'])){
    header("location: index1.php");
  } 
  if($_COOKIE["loggin"]!=2){
    header("location: index1.php");
  }  
if(isset($_POST['submit'])){
    $name=$_POST['name'];
    $start=$_POST['srt'];
    $end=$_POST['end'];
    $num=$_POST['num'];
    $id= $_POST['id'];
    $event=$_POST['event'];
    $db->add_admin_session($id,$name,$start,$end,$num,$event);
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Add Sessions</title>
    <link rel="stylesheet" href="../css/table.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <style>
      html, body {
      min-height: 100%;
      padding: 0;
      margin: 0;
      font-family: Roboto, Arial, sans-serif;
      font-size: 14px;
      color: #666;
      }
      h1 {
      margin: 0 0 20px;
      font-weight: 400;
      color: #1c87c9;
      }
      p {
      margin: 0 0 5px;
      }
      .main-block {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      }
      form {
      padding: 25px;
      margin: 25px;
      box-shadow: 0 2px 5px #f5f5f5; 
      background: #f5f5f5; 
      }
      .fas {
      margin: 25px 10px 0;
      font-size: 72px;
      color: #fff;
      }
      .fa-envelope {
      transform: rotate(-20deg);
      }
      .fa-at , .fa-mail-bulk{
      transform: rotate(10deg);
      }
      input, textarea {
      width: calc(100% - 18px);
      padding: 8px;
      margin-bottom: 20px;
      border: 1px solid #1c87c9;
      outline: none;
      }
      input::placeholder {
      color: #666;
      }
      button {
      width: 100%;
      padding: 10px;
      border: none;
      background: #1c87c9; 
      font-size: 16px;
      font-weight: 400;
      color: #fff;
      }
      button:hover {
      background: #2371a0;
      }    
      @media (min-width: 568px) {
      .main-block {
      flex-direction: row;
      }
      .left-part, form {
      width: 20%;
      }
      .fa-envelope {
      margin-top: 0;
      margin-left: 20%;
      }
      .fa-at {
      margin-top: -10%;
      margin-left: 65%;
      }
      .fa-mail-bulk {
      margin-top: 2%;
      margin-left: 28%;
      }
      }
    </style>     
</head>
  <body>
    <div class="main-block">
      
    <form  action = "<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <h1>ADD SESSIONS</h1>
        <div class="info">
          <input class="fname" type="text" name="id" placeholder="idsession">
          <input type="text" name="name" placeholder="name">
          <input type="text" name="num" placeholder="numberallowed">
          <select id="event" name="event" style="width:235px;margin-bottom:15px">
    <?php
	$data = $db->get_event_manager($id);
	
	if(count($data)>0){

			$bigString="";

			foreach ($data as $row) {
				$bigString.= "<option value={$row['idevent']}>{$row['name']}</option>\n";
			}
			$bigString .= "</table>\n";
            echo $bigString;
		}?>


          <input class="fname" type="text" name="srt" placeholder="startdate">
          <input type="text" name="end" placeholder="enddate">
        </div>
        <div>
        </div>
        <button type="submit" name='submit'>Submit</button>
      </form>
    </div>
  </body>
</html>