<?php
require '../clases/AutoCarga.php';
$sesion=new Session;
$sesion->destroy();
header('Location:../sas.html');
