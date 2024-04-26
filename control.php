<?php
/*No debe declarar le tipo de dato a retornar en ninguna funcion ex-> function name():int*/
declare(strict_types=0);

header('Access-Control-Allow-Origin: *');
header('Accept: */*');
error_reporting(E_ALL);
ini_set('display_errors', 0);
session_start();

class Presupuesto{
    private $SQL_SERVER;
    private $DATABASE_NAME;
    private $SQL_USER;
    private $SQL_PASS;
    private $conn;
	
	public function __construct(){
		$this->SQL_SERVER = 'localhost';
		$this->DATABASE_NAME = 'predb';
		$this->SQL_USER = 'root';
		$this->SQL_PASS = '';
	}

	public function startConnection(){
		/*
		@Description > START A NEW MYSQL CONNECTION
		*/
		$conn = new mysqli($this->SQL_SERVER, $this->SQL_USER, $this->SQL_PASS, $this->DATABASE_NAME);
		// Check connection
		if ($conn->connect_error) {
			die('Connection failed: ' . $conn->connect_error);
			exit;
		}
		return $conn;
	}

	public function closeConnection($conn){
		/*
		@Description > CLOSE CONNECTION
		:param conn: instancia de la conexion actual a la db
		*/
		$conn->close();
	}

    public function request_juridico($nombre, $telefono, $correo, $asunto){
		/*
		@Description > Add a new transaction
		*/

		$conn = $this->startConnection();
		$fecha = strval(date_create()->format('Y-m-d'));

		$stmt = $conn->prepare("INSERT INTO solicitud_juridico (nombre, telefono, correo, asunto, fecha) VALUES (?, ?, ?, ?, ?);");
		$stmt->bind_param("sssss", $nombre, $telefono, $correo, $asunto, $fecha);
		$stmt->execute();

		$count = $stmt->affected_rows;
		if ($count > 0){
			$ret_status = true;
			$ret_message = 'Solicitud recibida';
			$rows = [];
		}else{
			$ret_status = false;
			$ret_message = 'Error en la solicitud';
			$rows = [];
		}

		$stmt->close();
		$this->closeConnection($conn);
		return array('status'=>$ret_status, 'message'=>$ret_message , 'answer'=>$rows);
	}

	public function request_finca($nombre, $telefono, $correo){
		/*
		@Description > Add a new transaction
		*/

		$conn = $this->startConnection();
		$fecha = strval(date_create()->format('Y-m-d'));
		$stmt = $conn->prepare("INSERT INTO solicitud_finca (nombre, telefono, correo,  fecha) VALUES (?, ?, ?, ?);");
		$stmt->bind_param("ssss", $nombre, $telefono, $correo, $fecha);
		$stmt->execute();

		$count = $stmt->affected_rows;
		if ($count > 0){
			$ret_status = true;
			$ret_message = 'Solicitud recibida';
			$rows = [];
		}else{
			$ret_status = false;
			$ret_message = 'Error en la solicitud';
			$rows = [];
		}

		$stmt->close();
		$this->closeConnection($conn);
		return array('status'=>$ret_status, 'message'=>$ret_message , 'answer'=>$rows);
	}

}

$PRE = new Presupuesto();
if ($_SERVER["REQUEST_METHOD"] == 'GET'){
    $tipo = $_GET['tipo'];
    if ($tipo == 'finca'){
        $nombre = $_GET['name'];
        $correo = $_GET['correo'];
        $telefono = $_GET['telefono'];
        $poblacion = $_GET['poblacion1'];
        $response = $PRE->request_finca($nombre, $correo, $telefono);
    }
    else if ($tipo == 'juridico'){
        $nombre = $_GET['name'];
        $correo = $_GET['correo'];
        $telefono = $_GET['telefono'];
        $asunto = $_GET['asunto'];
        $response = $PRE->request_juridico($nombre, $correo, $telefono, $asunto);
    }
    else{
        $response = array('status'=>false, 'message'=>'Invalid TYPE' , 'answer'=>[]);
    }
	echo json_encode($response);
}else{
	echo "Invalid method";
}
?>