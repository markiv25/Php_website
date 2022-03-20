<?php
class DB{
private $conn;

function __construct()
{
	$this->conn = new mysqli($_SERVER['DB_SERVER'],$_SERVER['DB_USER'],$_SERVER['DB_PASSWORD'],$_SERVER['DB']);

	if ($this->conn->connect_error){
		echo "connect failed :".mysqli_connect_error();
		die();
	}
}
	function getAllPeople(){
		$data = array();
		if($stmt = $this->conn->prepare("select * from people")){
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($id,$last,$first,$nick);

			if($stmt->num_rows > 0){
				while($stmt->fetch()) {
					$data[]=array('id' => $id, 'first' => $first,'last' => $last,'nick' => $nick);
				}
			}//ifnumrows
		}//ifstmt
		return $data;
	}

	function getAllPeopleAsTable(){
		$data = $this->getAllPeople();

		if(count($data)>0){

			$bigString="<table border ='1'>\n 
			<tr><th>ID</th><th>FIRST</th><th>LAST</th><th>NICK</th></tr>\n";

			foreach ($data as $row) {
				$bigString.= "<tr><td><a href='Lab04_2.php?id={$row['id']}'>{$row['id']}</a></td><td>{$row['first']}</td>
				<td>{$row['last']}</td>
				<td>{$row['nick']}</td></tr>\n";
			}
			$bigString .= "</table>\n";

		}else{
			$bigString = "<h2>No people exists</h2>";

		}
		return $bigString;
	}

	function insert($last,$first,$nick){
		$query = "insert into people(LastName, FirstName, NickName) values (?,?,?)";

		$insertId = -1;

		if($stmt = $this->conn->prepare($query)) {
			$stmt->bind_param("sss",$last,$first,$nick);
			$stmt->execute();
			$stmt->store_result();
			$insertId = $stmt->insertId;

		}
		return $insertId;

	}//insert

	function getphone($id){
		$data = array();
		if($stmt = $this->conn->prepare("select * from phonenumbers where PersonID = ?")){
			$stmt->bind_param("i",intval($id));
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($id,$phoneType,$phoneNum,$areaCode);
			echo "<h2>".$stmt->num_rows." Record for ID: $id</h2>";
			if($stmt->num_rows > 0){
				while($stmt->fetch()) {
					$data[]=array('id' => $id, 'phoneType' => $phoneType,'phoneNum' => $phoneNum,'areaCode' => $areaCode);
				}
			}
		}
		if(count($data)>0){

			$Stringdata="<table border ='1'>\n 
			<tr><th>ID</th><th>PhoneType</th><th>PhoneNum</th><th>AreaCode</th></tr>\n";

			foreach ($data as $i) {
				$Stringdata.= "<tr><td>{$i['id']}</td><td>{$i['phoneType']}</td>
				<td>{$i['phoneNum']}</td>
				<td>{$i['areaCode']}</td></tr>\n";
			}
			$Stringdata .= "</table>\n";

		}else{
			$Stringdata = "<h2> No phone attached </h2>";

		}

	return $Stringdata;
}
	

	function delete($id){
		$query = "delete from people where PersonID=?";

		$numRows=0;

		if($stmt = $this->conn->prepare($query)) {
			$stmt->bind_param("i",intval($id));
			$stmt->execute();
			$stmt->store_result();
			$numRows = $stmt->affected_rows;

		}
		return $numRows;

	}//delete

	function update($id,$last,$first,$nick){
		$query = "update people set LastName = ?, FirstName =?, NickName=? where PersonID = ?";

		$numRows = 0;

		if($stmt = $this->conn->prepare($query)) {
			$stmt->bind_param("ssss",$last,$first,$nick,$id);
			$stmt->execute();
			$stmt->store_result();
			$numRows = $stmt->affected_rows;

		}
		return $numRows;
	}//update

}
?>