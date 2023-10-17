<?php
require_once ("conexion.php");
if(empty($_POST['searchTerm'])){
	$errors[] = "ERROR searchTerm";
}else if (!empty($_POST['searchTerm'])){
	$search = $_POST['searchTerm'];
	$query_select2 = "SELECT * FROM t_tipos WHERE tipo LIKE '%$search%'";
	$result_select2 = mysqli_query($conexion,$query_select2);
	$data = array();
	while ($row = mysqli_fetch_array($result_select2)) {
		$data[] = array("id"=>$row['Id'], "text"=>$row['tipo']);
	}
	echo json_encode($data);
}
?>