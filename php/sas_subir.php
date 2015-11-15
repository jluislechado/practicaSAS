<?php

require '../clases/AutoCarga.php';

$carpeta='../../../pacientes';
if(!file_exists($carpeta))
{
    mkdir($carpeta, 0777, true);
} 

$numSS=  Request::post("id_us");
$dia=Request::post("dia");
$mes=  Request::post("mes");
$ano=  Request::post("anio");
$dni=  Request::post("dni");
//$archivos=  Request::post("imagen[]");

$carpetaSS='../../../pacientes/'.$numSS;
if(!file_exists($carpetaSS))
{
    mkdir($carpetaSS, 0777, true);
}

$subir=new UploadFileMultiple("imagen", $carpetaSS.'/');

if($subir->getNumArchivos()>0){
    $subir->upload();
    $numSubidos=$subir->getNumeroSubidos();
    $numIntentos=count($subir->getArray());
}else{
    $numSubidos=0;
    $numIntentos=0;
}
$paciente=new Paciente($numSS);
$sesion=new Session;
$sesion->set("_paciente",$paciente);

header("Location:paciente.php?subidos=$numSubidos&intentos=$numIntentos");
