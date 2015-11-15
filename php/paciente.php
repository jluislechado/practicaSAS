<?php
require '../clases/AutoCarga.php';
$subidos = Request::get("subidos");
$intentos = Request::get("intentos");
$sesion = new Session();
$paciente = $sesion->get("_paciente");
$numSS = $paciente->getNumSS();
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Paciente</title>
        <link rel="stylesheet" type="text/css" href="../estilo/estilo.css"/>
    </head>
    <body>
        <div id="contenedor">
            <div id="cabecera">
                <div id="limpia"></div>
                <div id="identificacion">Nº Seguridad Social: <?php echo $numSS; ?></div>

            </div>
            <div id="cuerpo">
                
                <div id="listado">Listado de archivos almacenados:</div>
                <div id="limpia2"></div>
                <div id="cuerpoIzq">    
                    <?php
                    $carpeta = "../../../pacientes/$numSS";
                    $cadena = "";
                    if (file_exists($carpeta)) {
                        $directorio = opendir($carpeta);
                        while ($archivo = readdir($directorio)) {
                            if (!is_dir($archivo)) {
                                $cadena = $cadena . '<a href="leer.php?imagen=' . $carpeta . '/' . $archivo . '"><li>' . $archivo . '</li></a>';
                            }
                        }
                        echo $cadena;
                    }
                    ?>
                </div>
                <div id="cuerpoDerecha">
                    <div id="subidos">Nº de archivos subidos: <?php echo $subidos; ?></div>
                    <div id="intentos">Nº de intentos: <?php echo $intentos; ?></div>
                </div>
                <div id="cerrar"><a href="phplogout.php">Cerrar sesión</a></div>
            </div>
        </div>
    </body>
</html>
