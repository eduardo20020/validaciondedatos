<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
    <?php
        if(isset($_POST['enviar'])){
            $correo = $_POST['correo'];
            $nombre = $_POST['nombre'];
            $password = $_POST['password'];
            $valor = $_POST['seleccion'];
            $errores = array();
            $registerMsg = array();
            if(empty($nombre) || empty($password) ||empty($valor) || empty($correo)){
                $errores [] = 'rellena los campos plis';
            }else{
                try{
                    require_once 'conexion.php';
                    $stmt = $conn->prepare("SELECT nombre FROM registro WHERE nombre = :nombre");
                    $stmt->bindParam(':nombre', $nombre);
                    $stmt->execute();
                    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if ($row[0]['nombre']==$nombre){
                        $errores [] = 'el usuario ya existe';
                    }else{
                        $insert = $conn->prepare("INSERT INTO registro VALUES (:nombre, :password, :rol, :correo)");
                        $insert->bindParam(':nombre', $nombre);
                        $insert->bindParam(':password', $password);
                        $insert->bindParam(':rol', $valor);
                        $insert->bindParam(':correo', $correo);
                        if($insert->execute()){
                            $registerMsg [] = 'registro exitoso...';
                            header("refresh:1;url=login.php");
                        }
                    }
                }
                catch(PDOException $e) {
                    echo "Error al insertar datos: " . $e->getMessage();
                }
            }
         }
    
    ?>

    

<form method="post" autocomplete="off" class="container text-center">
    <h3>registro</h3>

    <label for="">nombre: </label><br>
    <input name="nombre" type="text" id="nombre"><br>

    <label for="">password: </label><br>
    <input name="password" type="text" id="password"><br>

    <label for="">correo: </label><br>
    <input name="correo" type="text" id="correo"><br><br>


    <select name="seleccion" id="">
        <option value="alumno">alumno</option>
        <option value="maestro">maestro</option>
    </select> <br><br>

    <input name="enviar" type="submit" value="enviar"><br>
    <a href="login.php">ya tienes una cuneta?</a>
</form>
<div class="container text-center py-4">
            <?php
            if (isset($errores)) {
                foreach ($errores as $error) {
                    echo '<div><strong>ERROR: ' . $error . '</strong></div>';
                }
            }
            if (isset($registerMsg[0])) {
                echo '<div><strong>ÉXITO: ' . $registerMsg[0] . '</strong></div>';
            }
            ?>
    </div>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>