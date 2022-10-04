<?php

 class Connection{

    private  $server = "localhost";
    private  $database = "veterinaria";
    private  $user = "root";
    private  $password = "";
    public   $connection = null;

    function __construct(){

        try{
            $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');			
            return $this->connection = new PDO("mysql:host=".$this->server."; dbname=".$this->database, $this->user, $this->password, $opciones);			
            
        }catch (Exception $e){
            die(json_encode(["error" => 1, "mensaje" => $e->getMessage()],JSON_UNESCAPED_UNICODE));
        }
    }


}

?>