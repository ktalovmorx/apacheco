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

		$stmt = $conn->prepare("INSERT INTO solicitud_juridico (nombre, telefono, correo, asunto) VALUES (?, ?, ?, ?);");
		$stmt->bind_param("ssss", $nombre, $telefono, $correo, $asunto);
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

	public function request_finca($name, $mail, $phone, $poblacion, $direccion, $cargo, $viviendas, $parqueos, $trasteros, $locales, $ascensores){
		/*
		@Description > Add a new transaction
		*/

		$conn = $this->startConnection();
		$fecha = strval(date_create()->format('Y-m-d'));
		$stmt = $conn->prepare("INSERT INTO solicitud_finca (nombre, correo, telefono, poblacion, direccion, cargo, viviendas, parqueos, trasteros, locales, ascensores) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
		$stmt->bind_param("sssssssssss", $name, $mail, $phone, $poblacion, $direccion, $cargo, $viviendas, $parqueos, $trasteros, $locales, $ascensores);
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
        $name = $_GET['name1'];
        $mail = $_GET['mail1'];
        $phone = $_GET['phone1'];
        $poblacion = $_GET['poblacion1'];
		$direccion = $_GET['poblacion1'];
		$cargo = $_GET['cargo1'];
		$viviendas = $_GET['viviendas1'];
		$parqueos = $_GET['parqueo1'];
		$trasteros = $_GET['trasteros1'];
		$locales = $_GET['locales1'];
		$ascensores = $_GET['ascensores1'];
        $response = $PRE->request_finca($name, $mail, $phone, $poblacion, $direccion, $cargo, $viviendas, $parqueos, $trasteros, $locales, $ascensores);
		header("Location: page/success.html");
		exit;
    }
    else if ($tipo == 'juridico'){
        $name = $_GET['name2'];
        $mail = $_GET['mail2'];
        $phone = $_GET['phone2'];
        $asunto = $_GET['asunto1'];
        $response = $PRE->request_juridico($name, $mail, $phone, $asunto);
		header("Location: page/success.html");
		exit;
    }
    else{
		header("Location: page/error.html");
		exit;
    }
}else{
	header("Location: page/error.html");
	exit;
}
?>