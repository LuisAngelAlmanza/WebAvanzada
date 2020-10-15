<?php 

	include_once "config.php";
	include_once "connectionController.php";

	if (isset($_POST) && isset($_POST['action'])) {
		if ($_POST['token'] == $_SESSION['token']) {
			
			$userController = new UserController();

			switch ($_POST['action']) {
				case 'store':
					
					$name = strip_tags($_POST['name']);
					$email = strip_tags($_POST['email']);
					$pass = strip_tags($_POST['password']);

					$userController->store($name,$email,$pass);

				break;

				case 'update':
					$name = strip_tags($_POST['name']);
					$email = strip_tags($_POST['email']);
					$pass = strip_tags($_POST['password']);
					$id = strip_tags($_POST['id']);

					$userController->update($name,$email,$pass,$id);
				break;

				case 'remove':
					$id = strip_tags($_POST['user_id']);
					echo json_encode($userController->remove($id));	
				break;
			}

		}else{
			$respuesta = array(
				'status' => "error",
				'message' => "Sin autorización"
			);
			echo json_encode($respuesta);
		}
		

		
	}

	Class UserController
	{
		function get()
		{
			$conn = connect();
			if (!$conn->connect_error) {
				
				$query = "SELECT * FROM users";
				$prepared_query = $conn->prepare($query);
				$prepared_query->execute();

				$results = $prepared_query->get_result();
				$users = $results->fetch_all(MYSQLI_ASSOC);

				if (count($users)>0) {
					return $users;
				}else
					return array();
			}else
				return array();
		}

		public function store($name, $email, $password)
		{
			$conn = connect();
			if (!$conn->connect_error) {

				if($name!="" && $email!="" && $password!=""){

					$query = "insert into users (name, email, password) values (?,?,?)";
					$prepared_query = $conn->prepare($query);
					$prepared_query->bind_param('sss', $name, $email, $password);
					if ($prepared_query->execute()){


						$_SESSION['status'] = "success";
						$_SESSION['message'] = "El registro se ha guardado correctamente";
						
						header('location: ' . $_SERVER['HTTP_REFERER']);
					}else{

						$_SESSION['status'] = "error";
						$_SESSION['message'] = "El registro no se ha guardado";
						header('location: ' . $_SERVER['HTTP_REFERER']);
					}

				}else{

					$_SESSION['status'] = "error";
					$_SESSION['message'] = "Verifique la informacion enviada";

					header('location: ' . $_SERVER['HTTP_REFERER']);
				}
				
			}else{

				$_SESSION['status'] = "error";
				$_SESSION['message'] = "Error durante la conexión";

				header('location: ' . $_SERVER['HTTP_REFERER']);
			}
		}

		public function update($name, $email, $password, $id)
		{
			$conn = connect();
			if (!$conn->connect_error) {

				if($name!="" && $email!="" && $password!="" && $id!=""){

					$query = "update users set name = ?, email = ?, password =? where id = ? ";

					$prepared_query = $conn->prepare($query);
					$prepared_query->bind_param('sssi', $name, $email, $password, $id);

					if ($prepared_query->execute()){

						//var_dump($_POST);
						$_SESSION['status'] = "success";
						$_SESSION['message'] = "El registro se ha actualizado correctamente";
						
						header('location: ' . $_SERVER['HTTP_REFERER']);
					}else{

						$_SESSION['status'] = "error";
						$_SESSION['message'] = "El registro no se ha actualizado";
						header('location: ' . $_SERVER['HTTP_REFERER']);
					}

				}else{

					$_SESSION['status'] = "error";
					$_SESSION['message'] = "Verifique la informacion enviada";

					header('location: ' . $_SERVER['HTTP_REFERER']);
				}
				
			}else{

				$_SESSION['status'] = "error";
				$_SESSION['message'] = "Error durante la conexión";

				header('location: ' . $_SERVER['HTTP_REFERER']);
			}
		}

		public function remove($id){

			$conn = connect();
			if (!$conn->connect_error) {

				if($id!=""){

					$query = "delete from users where id = ?";

					$prepared_query = $conn->prepare($query);
					$prepared_query->bind_param('i', $id);

					if ($prepared_query->execute()){

						$respuesta = array(
							'status' => "success",
							"id" => $id,
							'message' => "el registro se ha eliminado correctamente"
						);
						return $respuesta;

					}else{

						$respuesta = array(
							'status' => "error",
							'message' => "el registro no se ha eliminado"
						);
						return $respuesta;
					}

				}else{

					$respuesta = array(
						'status' => "error",
						'message' => "Verifique la informacion enviada"
					);
					return $respuesta;
				}
				
			}else{

				$respuesta = array(
					'status' => "error",
					'message' => "el registro no se ha eliminado"
				);
				return $respuesta;
			}
		}
	}

?>