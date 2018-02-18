<?php
/**
* Script PHP actualización ip publica.
* @author Albertsuarez (info@albertsuarez.com) - (www.albertuarez.com)
* @date 2017
*/

error_reporting(E_ALL);
ini_set("display_errors", 1);
$hostname = '';
$database = '';
$username = '';
$password = '';
$token="";
$public_ip = $_SERVER['REMOTE_ADDR'];
$mysqli = new mysqli($hostname, $username,$password, $database);
$route = "";
if(isset($_GET["route"])){$route = $_GET["route"];}

try {

	switch ($route) {
	case 'ip':
		if($_GET["token"] == $token){
			print $public_ip;
		}else{

			throw new Exception('Invalid Token.');

		}

		break;
	case 'put':
		if($_GET["token"] == $token){
			if ($mysqli -> connect_errno) {
				throw new Exception("ERROR MySQL: (" . $mysqli -> mysqli_connect_errno()
				. ") " . $mysqli -> mysqli_connect_error());

			}else{
					$sql_insert = "INSERT INTO ip VALUES (NULL, '".$public_ip."',now()); ";
					$sql_last = "SELECT * FROM ip ORDER BY id DESC ";

						if (!$resultado = $mysqli->query($sql_last)) {

							throw new Exception('The last record could not be recovered.');

						}else{

							$last_ip_row = $resultado->fetch_assoc();

							if($last_ip_row["ip"] !== $public_ip){

								if(!$resultado = $mysqli->query($sql_insert)) {

									throw new Exception('Could not be included in the database.');

								}else{

									print "Correct saving.";
								}

							}else{

									print "Ip in use.";

							}


						}

						$sql_last_data_delete = "SELECT * FROM ip WHERE DATEDIFF( CURDATE( ) , `date` ) > 30 ;";
						$sql_last_data_delete_ok = "DELETE FROM ip WHERE DATEDIFF( CURDATE( ) , `date` ) > 30 ;";
						if(!$delete_row = $mysqli->query($sql_last_data_delete)){

							throw new Exception('I do not select the records to be deleted.');

						}else{


							if(!$delete_row_ok = $mysqli->query($sql_last_data_delete_ok)){

								throw new Exception('I do not eliminate the records.');

							}else{

								print " - Deleted records -> ".$delete_row->num_rows;

							}


						}



				mysqli_close($mysqli);
			}
		}else{

			throw new Exception('Invalid Token.');

		}

		break;
	default:

		$sql_last_data = "SELECT * FROM ip ORDER BY id DESC ";

		if(!$resultado = $mysqli->query($sql_last_data)){

			throw new Exception('The last record could not be recovered.');

		}else{


			$last_ip_row = $resultado->fetch_assoc();
			header('Location: http://'.$last_ip_row["ip"].'');


		}


		break;
	}


} catch (Exception $e) {

	print "¡Error!: " . $e->getMessage() ;

}


?>