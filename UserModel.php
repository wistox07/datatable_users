<?php
require_once("Connection.php");
class UserModel extends Connection {

    public function listPersons($fechaInicio,$fechaFin,$apellidoPaterno){

        $stmt2 = $this->connection->prepare("SELECT 
        idPersona,
        nombres,
        apellidoPaterno,
        apellidoMaterno,
        domicilio,
        telefonoFijo,
        DATE(fechaRegistro) AS fechaRegistro
        FROM persona
        WHERE 
        DATE(fechaRegistro) BETWEEN ? AND ? 
        AND (?  = '' OR apellidoPaterno LIKE CONCAT('%', ?, '%'))
        ORDER BY idPersona DESC");
        $stmt2->bindParam(1, $fechaInicio, PDO::PARAM_STR);
        $stmt2->bindParam(2, $fechaFin, PDO::PARAM_STR);
        $stmt2->bindParam(3, $apellidoPaterno, PDO::PARAM_STR);
        $stmt2->bindParam(4, $apellidoPaterno, PDO::PARAM_STR);
        $stmt2->setFetchMode(PDO::FETCH_ASSOC);
        $stmt2->execute();
        return json_encode(["data" => $stmt2->fetchAll()],JSON_UNESCAPED_UNICODE);
        
    }

    public function deletePerson($idPerson){
        $stmt2 = $this->connection->prepare("DELETE from persona WHERE idPersona = ?");
        $stmt2->bindParam(1, $idPerson, PDO::PARAM_INT);
        $stmt2->setFetchMode(PDO::FETCH_ASSOC);
        $stmt2->execute();
        echo ($stmt2->rowCount() > 0) ? json_encode(["error" => 0, "message" => "Se eliminó correctamente el registro"],JSON_UNESCAPED_UNICODE) : json_encode(["error" => 1, "message" => "No se eliminó el registro"],JSON_UNESCAPED_UNICODE) ;
    }

    public function getPerson($idPerson){
        try{
            $stmt2 = $this->connection->prepare("SELECT 
            idPersona,
            nombres,
            apellidoPaterno,
            apellidoMaterno,
            domicilio,
            telefonoFijo,
            DATE(fechaRegistro) AS fechaRegistro
            from persona WHERE idPersona = ?");
            $stmt2->bindParam(1, $idPerson, PDO::PARAM_INT);
            $stmt2->setFetchMode(PDO::FETCH_ASSOC);
            $stmt2->execute();
            if($stmt2->rowCount() > 0){
                $result = $stmt2->fetch();
                $salida = ["data" => $result, "error"=>0, "mensaje"=>"Se encontraron registros"];
                echo json_encode($salida,JSON_UNESCAPED_UNICODE);
            }
            else{
               echo json_encode(["error" => 1, "message" => "No se encontró registro"], JSON_UNESCAPED_UNICODE) ;
            }

        }catch(Exception $ex){
            echo json_encode(["error" => 1, "message" => $ex->getMessage()],JSON_UNESCAPED_UNICODE);
        }

    
    
    }

    public function updatePerson($idPerson,$nombres,$apellidoPaterno,$apellidoMaterno,$domicilio,$telefonoFijo){
        try{

            $stmt = $this->connection->prepare("UPDATE 
            persona 
            SET nombres = ?,
            apellidoPaterno = ?,
            apellidoMaterno = ?,
            domicilio = ?,
            telefonoFijo = ?
            WHERE idPersona = ?
            ");
            $stmt->bindParam(1, $nombres, PDO::PARAM_STR);
            $stmt->bindParam(2, $apellidoPaterno, PDO::PARAM_STR);
            $stmt->bindParam(3, $apellidoMaterno, PDO::PARAM_STR);
            $stmt->bindParam(4, $domicilio, PDO::PARAM_STR);
            $stmt->bindParam(5, $telefonoFijo, PDO::PARAM_STR);
            $stmt->bindParam(6, $idPerson, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();

            echo json_encode(["error" => 0, "message" => "Modificación exitosa"],JSON_UNESCAPED_UNICODE);

        }
        catch(Exception $ex)
        {
            echo json_encode(["error" => 1, "message" => $ex->getMessage()],JSON_UNESCAPED_UNICODE);
        }
    }

    public function savePerson($nombres,$apellidoPaterno,$apellidoMaterno,$domicilio,$telefonoFijo){
        try{

            $stmt = $this->connection->prepare("INSERT INTO persona
            (nombres,
            apellidoPaterno,
            apellidoMaterno,
            domicilio,
            telefonoFijo
            ) VALUES(?,?,?,?,?)");
            $stmt->bindParam(1, $nombres, PDO::PARAM_STR);
            $stmt->bindParam(2, $apellidoPaterno, PDO::PARAM_STR);
            $stmt->bindParam(3, $apellidoMaterno, PDO::PARAM_STR);
            $stmt->bindParam(4, $domicilio, PDO::PARAM_STR);
            $stmt->bindParam(5, $telefonoFijo, PDO::PARAM_STR);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            echo ($stmt->rowCount() > 0) ? json_encode(["error" => 0, "message" => "Se insertó correctamente el registro"],JSON_UNESCAPED_UNICODE) : json_encode(["error" => 1, "message" => "No se insertó el registro"],JSON_UNESCAPED_UNICODE) ;

        }
        catch(Exception $ex)
        {
            echo json_encode(["error" => 1, "message" => $ex->getMessage()],JSON_UNESCAPED_UNICODE);
        }
    }
}

?>