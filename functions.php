<?php
require_once("UserModel.php");

if (isset($_POST)) {
    $accion = $_GET['action'];

    switch ($accion) {
        case 'list':
            
            $fechaInicio = $_GET['startDate'];
            $fechaFin = $_GET['endDate'];
            $apellidoPaterno = $_GET['surname'];
            $userModel = new UserModel();
            echo $userModel->listPersons($fechaInicio,$fechaFin,$apellidoPaterno);
            
          

        break;
        case 'delete':
            $idPerson = $_POST['idPerson'];
            $userModel = new UserModel();
            echo $userModel->deletePerson($idPerson);
            
        break;
        case 'get':
            $idPerson = $_POST['idPerson'];
            $userModel = new UserModel();
            echo $userModel->getPerson($idPerson);
        break;
        case 'update':
            $idPerson = $_POST['idPersona'];
            $nombres = $_POST['nombres'];
            $apellidoPaterno = $_POST['apellidoPaterno'];
            $apellidoMaterno = $_POST['apellidoMaterno'];
            $domicilio = $_POST['domicilio'];
            $telefonoFijo = $_POST['telefonoFijo'];
            $userModel = new UserModel();
            echo $userModel->updatePerson($idPerson,$nombres,$apellidoPaterno,$apellidoMaterno,$domicilio,$telefonoFijo);
        break;
        case 'save':
            $nombres = $_POST['nombres'];
            $apellidoPaterno = $_POST['apellidoPaterno'];
            $apellidoMaterno = $_POST['apellidoMaterno'];
            $domicilio = $_POST['domicilio'];
            $telefonoFijo = $_POST['telefonoFijo'];
            $userModel = new UserModel();
            echo $userModel->savePerson($nombres,$apellidoPaterno,$apellidoMaterno,$domicilio,$telefonoFijo);
        break;


    }
}


?>