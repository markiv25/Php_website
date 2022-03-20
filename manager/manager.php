<?php
include ("./nav.php");
require_once"../PDO.DB.class.php";
$db = new DB();
$id=$_COOKIE["loggin"];
$data = $db->get_users_manager($id);
//echo(var_dump($data));
session_name("user");
session_start();
if(empty($_SESSION['loggedIn'])){
    header("location: index1.php");
  } 
  if($_COOKIE["loggin"]!=2){
    header("location: index1.php");
  }    

if(isset($_POST['delete'])){
   
   $id= $_POST['delete'];
 $db->delete_admin($id);
}
if(isset($_POST['update'])){
  $name=$_POST['name'];
  $role=$_POST['role_id'];
  $id= $_POST['id'];
//echo $id,$name,$role;
  $db->update_admin_user($id,$name,$role);
}
if(isset($_POST['add'])){
    header("location: ../forms/form_user.php");
  }
?>
<html lang="en"><head>

<meta charset="UTF-8">

<link rel="apple-touch-icon" type="image/png" href="https://cpwebassets.codepen.io/assets/favicon/apple-touch-icon-5ae1a0698dcc2402e9712f7d01ed509a57814f994c660df9f7a952f3060705ee.png">
<meta name="apple-mobile-web-app-title" content="CodePen">

<link rel="shortcut icon" type="image/x-icon" href="https://cpwebassets.codepen.io/assets/favicon/favicon-aec34940fbc1a6e787974dcd360f2c6b63348d4b1f4e06c77743096d55480f33.ico">

<link rel="mask-icon" type="image/x-icon" href="https://cpwebassets.codepen.io/assets/favicon/logo-pin-8f3771b1072e3c38bd662872f6b673a722f4b3ca2421637d5596661b4e2132cc.svg" color="#111">




<link rel="stylesheet" href="../css/table.css">
<script>
  window.console = window.console || function(t) {};
</script>

  
  
  <script>
  if (document.location.search.match(/type=embed/gi)) {
    window.parent.postMessage("resize", "*");
  }
</script>


</head>

<body translate="no">
<div><form method="post" style="padding-top: 80px;">
            <button type="submit" class='bttn' name="add" value="logout"> + </button> 
        </form></div>
  <div class="container">
	<table>
       
        
		<thead>
			<tr>
				<th>Role ID </th>
				<th> Name </th>
				<th>Role</th>
        <th>Role</th>
			</tr>
		</thead>
        <?php  foreach ($data as $i){
            echo"
		<tbody>
			<tr><form method='POST'>
				<td><input type='text' name='id' value='$i[0]'></td>
				<td><input type='text' name='name' value='$i[1]'></td>
        <td><input type='text' name='role' value='$i[2]'></td>
        <td><input type='text' name='role_id' value='$i[3]'></td>
				<td>
              
                <button type='submit' class='bttn' name='delete' value='$i[0]'> Delete </button> 
                </td>
                <td>
                <button type='submit' class='bttn' name='update' value='$i[0]'> Update </button>    
                </form>
            </td>
			</tr>	
		</tbody>";}?>
	</table>
</div>
</body>
</html>

