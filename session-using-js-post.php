<?php
	try {
		if(isset($_POST["user_email"]) && isset($_POST["user_id"])) {
			session_start();
			unset($_SESSION['id']);
			unset($_SESSION['email']);
			session_destroy();
			session_start();
			include "../../conn.php";
			global $conn;
			$sql = $conn->prepare("SELECT id, email FROM `sunshine_users` WHERE email = :email AND id = :user_id");
			$sql->bindParam(':email', $_POST["user_email"]);
			$sql->bindParam(':user_id', $_POST["user_id"]);
			$sql->execute();
			$row = $sql->fetch();
			if(!empty($row)) {
				$_SESSION['id'] = $row['id'];
				$_SESSION['sunshine_email'] = $row['email'];
				$json_array['status_reg'] = 1;
				echo json_encode($json_array);
				return;
			}
		}
	} catch(Exception $e) {
		$json_array['status'] = -99;
		$json_array['errMessage'] = $e->getMessage();
		echo json_encode($json_array);	 
		return;
	} catch(Error $e) {
		$json_array['status'] = -99;
		$json_array['errMessage'] = $e->getMessage();
		echo json_encode($json_array);	 
		return;
	}
?>
