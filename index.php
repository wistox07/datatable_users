<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous"></head>


</head>
<body>
    <div class="container">
        <div class="mb-3 row">
            <div class="col-sm-4">
                <button id="nuevaPersonaModal" type="button" class="btn btn-success">Nueva Persona</button>
            </div>
            
        </div>
        <div class="mb-3 row">
            <label for="nombres" class="col-sm-1 col-form-label">Desde</label>
            <div class="col-sm-3">
                <input class="form-control" id="filtroFechaInicial" name="txtFechaInicial" placeholder="MM/DD/YYY" type="date" value="2022-01-15" />
            </div>
            <label for="nombres" class="col-sm-1 col-form-label">Hasta</label>
            <div class="col-sm-3">
                <input class="form-control" id="filtroFechaFinal" name="txtFechaFinal" placeholder="MM/DD/YYY" type="date" value="<?php echo date('Y-m-d', strtotime(date('Y-m-d'). ' + 1 month')) ?>"/>                 
            </div>
            <div class="col-sm-1">
                <button id="buscarPersona" type="button" class="btn btn-warning">Buscar</button>
            </div>

            
        </div>
        <div class="mb-3 row">
            <label for="nombres" class="col-sm-1 col-form-label">Apellido Paterno</label>
            <div class="col-sm-4">
                <input class="form-control" id="filtroApellidoPaterno" name="txtFiltroApellidoPaterno" placeholder="Apellido Paterno" type="text" />                 
            </div>
        </div>

        <br>
        <br>

        <table id="table_persons" class="display responsive table table-middle table-bordered table-default dataTable" width="100%">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombres</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Domicilio</th>
                    <th>Telefono</th>
                    <th>Fecha de Registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th>Id</th>
                    <th>Nombres</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Domicilio</th>
                    <th>Telefono</th>
                    <th>Fecha de Registro</th>
                    <th >Acciones</th>
                </tr>
            </tfoot>
        </table>


        
                <!-- MODAL REGISTRO EDITAR-->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="tituloModalRegistrar" class="modal-title" id="exampleModalLabel">Registrar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="alerta">

                        </div>

                        <input type="hidden" id="idPersona" name="txtIdPersona">
                        
                        <div class="mb-3 row">
                            <label for="nombres" class="col-sm-2 col-form-label">Nombres</label>
                            <div class="col-sm-10">
                                <input type="text"  class="form-control" id="nombres" name="txtNombres">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="apellidoPaterno" class="col-sm-2 col-form-label">Apellido Paterno</label>
                            <div class="col-sm-10">
                                <input type="text"   class="form-control"  id="apellidoPaterno" name="txtApellidoPaterno">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="apellidoMaterno" class="col-sm-2 col-form-label">Apellido Materno</label>
                            <div class="col-sm-10">
                                <input type="text"  class="form-control"  id="apellidoMaterno" name="txtApellidoMaterno">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="domicilio" class="col-sm-2 col-form-label">Domicilio</label>
                            <div class="col-sm-10">
                                <input type="text"  class="form-control"  id="domicilio" name="txtDomicilio">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="telefonoFijo" class="col-sm-2 col-form-label">Telefono Fijo</label>
                            <div class="col-sm-10">
                                <input type="text"   class="form-control" id="telefonoFijo" name="txtTelefonoFijo">
                            </div>
                        </div>
                        <!--
                        <div id="contenedorFechaRegistro" class="mb-3 row">
                            <label for="fechaRegistro" class="col-sm-2 col-form-label">Fecha Registro</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="fechaRegistro" name="txtFechaRegistro">
                            </div>
                        </div>
                    -->
                    </div>
                    <div class="modal-footer">
                        
                        <button type="button" class="btn btn-success" id="btnGuardarPersona">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        

    </div>

    <script src="https://cdn.datatables.net/1.11.5/js/jquery.js" type="text/javascript" ></script>    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript" src="js/persons.js"></script>
</body>
</html>
