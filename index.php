<?php
$metodo = $_SERVER['REQUEST_METHOD'];
$servername = "localhost";
$username = "root";
$password = "Mnovember@23";
$dbname = "user_db"; 
$mysqli = new mysqli($servername,$username ,$password,$dbname);
switch($metodo){
    case 'GET':
        if(!empty($_SERVER['PATH_INFO'])){
            $id = substr($_SERVER['PATH_INFO'],1);
            echo $id;
            if ($mysqli->connect_errno)
            {
              printf("conexion fallida: %s\n", $mysqli->connect_error);
              exit();
            }else{
                $sql = "SELECT * FROM users WHERE id = '".$id."'";
                if($result = $mysqli->query($sql)){
                    $fila = $result->fetch_assoc();
                    $json = json_encode($fila);
                    print($json);
                    $result -> close();
                }
            }
        }else{
            if ($mysqli->connect_errno)
            {
              printf("conexion fallida: %s\n", $mysqli->connect_error);
              exit();
            }else{
                $sql = "SELECT * FROM users";
                $collection = array();
                if($result = $mysqli->query($sql)){
                    while ( $fila = $result->fetch_assoc() ) {
                            $json = json_encode($fila);
                            array_push($collection,$json);
                    }
                    $result -> close();
                }
                print_r($collection);
            }
        }
        break;
    case 'POST':
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        if ($mysqli->connect_errno)
            {
              printf("conexion fallida: %s\n", $mysqli->connect_error);
              exit();
            }else{
                $sql = "INSERT INTO  users(name,email,password)  values($name,$email, $password)";
                if ($mysqli->query($sql) === TRUE) {
                    echo "Nuevo Usuario Creado correctamente";
                } else {
                    echo "Error: " . $sql . "<br>" . $mysqli->error;
                }
                $mysqli->close();
            }
        break;
    case 'PUT':
        $json = [
            'error' => '1',
            'mensaje' => 'El sistema aun no cuenta con actualizaciones'
        ];
        print(json_encode($json));
        break;
    case 'DELETE':
        if(!empty($_SERVER['PATH_INFO'])){
            $id = substr($_SERVER['PATH_INFO'],1);
            if ($mysqli->connect_errno)
            {
              printf("conexion fallida: %s\n", $mysqli->connect_error);
              exit();
            }else{
                $sql = "DELETE FROM users WHERE id = $id";
                if ($mysqli->query($sql) === TRUE){
                    $json = [
                        'error' => '0',
                        'filas afectadas' => $mysqli ->affected_rows,
                        'mensaje' => 'Usuario eliminado correctamente'
                    ];
                    print(json_encode($json));
                    $mysqli -> close();
                }else{
                    $json = [
                        'error' => $mysqli ->error,
                        'mensaje' => 'No se pudo eliminar el usuario.'
                    ];
                    print(json_encode($json));
                    $mysqli -> close();
                }
            }
        }
        break;
}
?>