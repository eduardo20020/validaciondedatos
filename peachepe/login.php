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
            $nombre = $_POST['nombre'];
            $password = $_POST['password'];
            $valor = $_POST['seleccion'];
            $errores = array();
            $registerMsg = array();
            if(empty($nombre) || empty($password) ||empty($valor)){
                $errores [] = 'rellena los campos plis';
            }else{
                try {
                    require_once 'conexion.php';
                    $select_stm = $conn->prepare("SELECT nombre, password, rol FROM registro WHERE nombre=:nombre AND password=:password AND rol=:rol");
                    $select_stm->bindParam(":nombre", $nombre);
                    $select_stm->bindParam(":password", $password);
                    $select_stm->bindParam(":rol", $valor);
                    $select_stm->execute();
                    if($select_stm->rowCount() > 0) {
                        $row = $select_stm->fetch(PDO::FETCH_ASSOC);
                        $dbusuario = $row["nombre"];
                        $dbpassword = $row["password"];
                        $dbrol = $row["rol"];
        
                        if($nombre == $dbusuario && $password == $dbpassword && $valor == $dbrol) {
                            switch ($dbrol) {
                                case 'alumno':
                                    $_SESSION['alumno'] = $usuario;
                                    echo 'exito alumno';
                                    header("refresh:1;url=perfiles/alumno.php");
                                    break;
                                
                                case 'maestro':
                                    $_SESSION['maestro'] = $usuario;
                                    echo 'exito maestro';
                                    header("refresh:1;url=perfiles/maestro.php");
                                    break;
                                default:
                                    $errores[] = "Usuario, contraseña o rol no válidos.";
                            }
                        } else {
                            $errores[] = "Usuario, contraseña o rol no válidos.";
                        }
                    } else {
                        $errores[] = "Usuario, contraseña o rol no válidos.";
                    }
                } catch ( PDOException $e) {
                    
                }
            }
         }
    
    ?>

    

<form method="post" autocomplete="off" class="container text-center">
<h3>inicio de sesion</h3>

    <label for="">nombre: </label><br>
    <input name="nombre" type="text" id="nombre"><br>

    <label for="">password: </label><br>
    <input name="password" type="text" id="password"><br><br>

    <select name="seleccion" id="">
        <option value="alumno">alumno</option>
        <option value="maestro">maestro</option>
    </select> <br><br>

    <input name="enviar" type="submit" value="enviar"><br>
    <a href="index.php">crear una cuenta</a>
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