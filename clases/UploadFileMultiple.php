<?php
class UploadFileMultiple {
    private $array = [ Array() ];
    const CONSERVAR = 1;
    const REMPLAZAR = 2; 
    const RENOMBRAR = 3;
    private $politica = self::RENOMBRAR;
    private $error = false; 
    private $numArchivos = 0;
    private $arrayDeTipos = Array(
        "mp3"=>1,
        "MP3"=>1,
        "JPG"=>1,
        "jpg"=>1,
        "png"=>1,
        "PNG"=>1
    );
    function __construct($parametro, $destino = "../../../pacientes/") {
        if(isset($_FILES[$parametro])){
            $nuevoArray = $this->construirArray($_FILES[$parametro]);
            foreach ($nuevoArray as $indice => $valor) {
                if($valor["name"] !== ""){
                    $this->numArchivos++;
                    $this->array[$indice]["destino"] = $destino;
                    $this->array[$indice]["ubicacionTemporal"] = $valor["tmp_name"];
                    $this->array[$indice]["nombre"] = pathinfo($valor["name"])["filename"];
                    $this->array[$indice]["extension"] = pathinfo($valor["name"])["extension"];
                    $this->array[$indice]["tamaño"] = $valor["size"];
                    $this->array[$indice]["tamañoMax"] = 1000000000;
                    $this->array[$indice]["parametro"] = $parametro;
                    $this->array[$indice]["errorArchivo"] = false;
                    $this->array[$indice]["error"] = $valor["error"];
                    $this->array[$indice]["subido"] = false;
                }else{
                    $this->array["errorArchivo"] = true;
                }
            }
        }else{
            $this->error = true;
        }
    }
    //Método que devuelve el array de arrays construido
    public function getArray() {
        return $this->array;
    }
    public function setArray($array) {
        $this->array = $array;
    }
    //Netodo que al pasarle un indice, devuelve el destino alojado en ese índice
    public function getDestino($indice) {
        return $this->array[$indice]["destino"];
    }
    //Método que devuelve el número de archivos que componene el array construído
    public function getNumArchivos() {
        return $this->numArchivos;
    }
    //Método que cuenta y devuelve el número de archivos subidos
    public function getNumeroSubidos() {
        $numSubidos = 0;
        foreach ($this->array as $indice => $valor) {
            if($valor["subido"]){
                $numSubidos++;
            }
        }
        return $numSubidos;
    }
    public function getName($indice) {
        return $this->array[$indice]["nombre"];
    }
    public function getTamaño($indice) {
        return $this->array[$indice]["tamaño"];
    }
    public function getExtension($indice) {
        return $this->array[$indice]["extension"];
    }    
    public function getPolitica() {
        return $this->politica;
    }
    public function setName($name,$indice) {
        $this->array[$indice]["nombre"] = $name;
    }
    public function setDestino($destino,$indice) {
        $this->array[$indice]["destino"] = $destino;
    }
//Funciona igual que el método upload() de la clase UploadFile.php; con la diferencia que
//en este caso recorre el array, va comprobando que cada archivo cumple con las especificaciones impuestas
//y subiendo los archivos uno a uno.
    public function upload(){
        foreach ($this->array as $archivo => $valor) {
            if($valor["subido"])
                continue;//Actúa como un break, pero evalúa el siguiente archivo sin salirse del todo
            if($valor["error"])
                continue;
            if($valor["errorArchivo"] != UPLOAD_ERR_OK)
                continue;
            if($valor["tamaño"] > $valor["tamañoMax"])
                continue;
            if(!$this->isTipo($valor["extension"]))
                continue;
            if(!(is_dir($valor["destino"]) && substr($valor["destino"], -1) === "/"))
                continue;
            if($this->politica === self::RENOMBRAR && file_exists($valor["destino"] . $valor["nombre"] . "." . $valor["extension"]))
                $valor["nombre"] = $this->remplazar($archivo,$valor["nombre"]);
            if(move_uploaded_file($valor["ubicacionTemporal"], $valor["destino"] . $valor["nombre"] . "." . $valor["extension"])){
                    $this->array[$archivo]["subido"] = true;
            }else{
                $this->array[$archivo]["subido"] = false;
            }
        }
    }
    
    private function remplazar($indice, $nombre){
        $i = 1;
        while(file_exists($this->array[$indice]["destino"] . $nombre . "_" . $i . "." . $this->array[$indice]["extension"])){
            $i++;
        }
        return $nombre."_".$i;
    }
    
    public function addTipo($tipo){
        if(!$this->isTipo($tipo)){
            $this->arrayDeTipos[$tipo]=1;
            return true;
        }
        return false;
    }
    
    public function removeTipo($tipo){
        if($this->isTipo($tipo)){
            unset($this->arrayDeTipos[$tipo]);
            return true;
        }
        return false;
    }
    
    public function isTipo($tipo){
        return isset($this->arrayDeTipos[$tipo]);
    }
//Método al que se le pasa un array y construye un nuevo array de arrays con éste    
    public function construirArray($archivo){
        $array = Array();
        foreach ($archivo as $datoFiles => $valorDatos) {
            foreach ($valorDatos as $indiceArchivo => $valorArchivo) {
                $array[$indiceArchivo][$datoFiles] = $valorArchivo;
            }
        }
        return $array;
    }    
}
