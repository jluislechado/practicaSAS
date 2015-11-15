<?php

class Metodos {
    
    static function quitarGuiones($nombre){
        for($i=0;$i<strlen($nombre);$i++)
        {
            $cadena="";
            if(substr($nombre, $i, 1)=='_')
            {
                $cadena=$cadena."-";
            }
            else
            {
                $cadena=$cadena.substr($nombre, $i, 1);
            }
        }
        return $cadena;
    }
    
    static function quitarPuntos($nombre){
        for($i=0;$i<strlen($nombre);$i++)
        {
            $cadena="";
            if(substr($nombre, $i, 1)=='.')
            {
                $cadena=$cadena."-";
            }
            else
            {
                $cadena=$cadena.substr($nombre, $i, 1);
            }
        }
        return $cadena;
    }
    
    static function nombreUsuario($nombreArchivo){
        $usuario="";
        $i=0;
        while(substr($nombreArchivo, $i, 1)!="_")
        {
            $usuario=$usuario.substr($nombreArchivo, $i, 1);
            $i++;
        }
        return $usuario;
        
    }
    
    static function nombreCategoria($nombreArchivo){
        $categoria="";
        $i=0;
        while(substr($nombreArchivo, $i, 1)!="_")
        {
            $i++;
        }
        $contador=$i+1;
        while(substr($nombreArchivo, $contador, 1)!="_")
        {
            $categoria=$categoria.substr($nombreArchivo, $contador, 1);
            $contador++;
        }
        return $categoria;
    }
    
    static function nombreCancion($nombreArchivo){
        $cancion="";
        $i=0;
        while(substr($nombreArchivo, $i, 1)!="_")
        {
            $i++;
        }
        $contador=$i+1;
        while(substr($nombreArchivo, $contador, 1)!="_")
        {
            $contador++;
        }
        $contador2=$contador+1;
        while(substr($nombreArchivo, $contador2, 1)!=".")
        {
            $cancion=$cancion.substr($nombreArchivo, $cancion, 1);
            $contador2++;
        }
        return $cancion;
        
    }
    
    static function listar($usuario,$categoria,$privacidad){
        $carpeta="../usuarios/$usuario/$privacidad/$categoria";
        $cadena="";
            if(file_exists($carpeta)){
                 $directorio=opendir($carpeta);
                while($archivo=  readdir($directorio))
                {
                    if(!is_dir($archivo))
                    {    
                    $cadena=$cadena.'<a href="?src=../usuarios/'.$usuario.'/'.$privacidad.'/'.$categoria.'/'.$archivo.'"><li>'.$archivo.'</li></a>';
                    }
                }
                return $cadena;
            }
    }
    
    
    static function listar2($usuario,$categoria,$privacidad){
        $carpeta="../usuarios/$usuario/$privacidad/$categoria";
        $cadena="";
            if(file_exists($carpeta)){
                 $directorio=opendir($carpeta);
                while($archivo=  readdir($directorio))
                {
                    if(!is_dir($archivo))
                    {    
                    $cadena=$cadena.'<a href="reproductor.php?src=../usuarios/'.$usuario.'/'.$privacidad.'/'.$categoria.'/'.$archivo.'"><li>'.$archivo.'</li></a>';
                    }
                }
                return $cadena;
            }
    }
    
    static function listarUsuarios(){
       $carpeta="../usuarios";
       $array=  scandir($carpeta);
       $cadena="";
       for($i=0;$i<count($array);$i++)
       {
           if($array[$i]!="."&&$array[$i]!="..")
           {    
                $cadena=$cadena.'<a href="?nombre='.$array[$i].'"><li>'.$array[$i].'</li></a>';
           }
       }
       return $cadena;
    }
    
    
    
   static function removeDirectory($path)
{
    $path = rtrim( strval( $path ), '/' ) ;
    
    $d = dir( $path );
    
    if( ! $d )
        return false;
    
    while ( false !== ($current = $d->read()) )
    {
        if( $current === '.' || $current === '..')
            continue;
        
        $file = $d->path . '/' . $current;
        
        if( is_dir($file) )
            removeDirectory($file);
        
        if( is_file($file) )
            unlink($file);
    }
    
    rmdir( $d->path );
    $d->close();
    return true;
}
    
    //<a href="?nombre='.$array[$i].'></a>
    
}
