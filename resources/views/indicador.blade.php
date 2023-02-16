<!DOCTYPE html>
<html>
<head>
    <title>Solutoria</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>
<body> 
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">SOLUTORIA jobs</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">    
                <li class="nav-item active">
                    <a class="btn btn-success" href="javascript:void(0)" id="createIndicador">Crear nuevo indicador</a>
                </li>            
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Importar indicadores</button>
            </form>
        </div>
        </nav>

        <div class="container">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Listado de indicadores</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Graficas</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <table id="tablaIndicador" class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th width="300px">Nombre</th>
                                    <th>Código</th>
                                    <th>Unidad</th>
                                    <th>Valor</th>
                                    <th>Fecha</th>
                                    <th>Tiempo</th>
                                    <th>Origen</th>
                                    <th width="200px">Acciones</th>                
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                </div>            
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <form id="frmPeriodo">
                        @csrf
                        <label for="inicio">Desde:</label>
                        <input type="date" id="inicio" name="inicio">

                        <label for="final">Hasta:</label>
                        <input type="date" id="final" name="final">

                        <button id="btnGraficar" class="btn btn-primary">Graficar</button>
                    </form>

                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    
                    <canvas id="myChart" height="100px"></canvas>
                    
                    <script type="text/javascript">
                        var labels = new Array();
                        var values = new Array(); 
                        
                        $(document).ready(function() {
                            $('#frmPeriodo').submit(function(e) {
                                e.preventDefault();
                                $.ajax({
                                    data: $('#frmPeriodo').serialize(),
                                    url: "{{ route('charts.index') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    success: function(response){
                                        response.forEach(function(data){
                                            labels.push(data.fechaindicador);
                                            values.push(data.valor);
                                        });  

                                        const data = {
                                            labels: labels,
                                            datasets: [{
                                            label: 'Grafica en el periodo seleccionado',
                                            backgroundColor: 'rgb(255, 99, 132)',
                                            borderColor: 'rgb(255, 99, 132)',
                                            data: values,
                                            }]
                                        };

                                        const config = {
                                            type: 'line',
                                            data: data,
                                            options: {}
                                        };

                                        const myChart = new Chart(
                                            document.getElementById('myChart'),
                                            config
                                        );
                                    },
                                    error: function (data) {
                                        console.log('Error:', data);
                                        $('#btnGraficar').html('Graficar de nuevo');
                                    }
                                });
                            });
                        });
                    </script>
                </div>                 
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">

                <form id="frmRegistro" name="frmRegistro" class="needs-validation" novalidate>
                    <input type="hidden" id="idIndicador">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="txtNombre">Nombre</label>
                            <input type="text" class="form-control" id="txtNombre" name="txtNombre" value="" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="txtCodigo">Código</label>
                            <input type="text" class="form-control" id="txtCodigo" name="txtCodigo" value="" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label for="selUnidad">Unidad medida</label>
                            <select class="custom-select" id="selUnidad" name="selUnidad" required>
                                <option selected disabled value="">Seleccione...</option>
                                <option>Dólar</option>
                                <option>Peso</option>
                                <option>Porcentaje</option>
                                <option>Otro</option>
                            </select>
                            <div class="invalid-feedback">
                                Por favor, seleccione una unidad.
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="txtValor">Valor</label>
                            <input type="text" class="form-control" id="txtValor" name="txtValor" required>
                            <div class="invalid-feedback">
                                Por favor, digite un valor.
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="txtFecha">Fecha</label>
                            <input type="text" class="form-control" id="txtFecha" name="txtFecha" required>
                            <div class="invalid-feedback">
                                Por favor, introduzca una fecha.
                            </div>
                        </div>                                                           
                    </div>
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label for="txtTiempo">Tiempo</label>
                            <input type="text" class="form-control" id="txtTiempo" name="txtTiempo">
                        </div>                            
                        <div class="col-md-3 mb-3">
                            <label for="selOrigen">Origen</label>
                            <select class="custom-select" id="selOrigen" name="selOrigen" required>
                                <option selected disabled value="">Seleccione...</option>
                                <option>mindicador.cl</option>
                                <option>Otra</option>
                            </select>
                            <div class="invalid-feedback">
                                Por favor seleccione un origen.
                            </div>
                        </div>                                           
                    </div>
                    <button id="btnSave" class="btn btn-primary" type="submit" value="create">Guardar</button>
                </form>
                <script>
                // Example starter JavaScript for disabling form submissions if there are invalid fields
                    (function() {
                        'use strict';
                        window.addEventListener('load', function() {
                            // Fetch all the forms we want to apply custom Bootstrap validation styles to
                            var forms = document.getElementsByClassName('needs-validation');
                            // Loop over them and prevent submission
                            var validation = Array.prototype.filter.call(forms, function(form) {
                                form.addEventListener('submit', function(event) {
                                    if (form.checkValidity() === false) {
                                        event.preventDefault();
                                        event.stopPropagation();
                                    }
                                    form.classList.add('was-validated');
                                }, false);
                            });
                        }, false);
                    })();
                </script>
                </div>
            </div>
        </div>
    </div>    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>  

    <script type="text/javascript">
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('indicadors.index') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'nombreindicador', name: 'nombreindicador'},
                {data: 'codigoindicador', name: 'codigoindicador'},
                {data: 'unidadmedidaindicador', name: 'unidadmedidaindicador'},
                {data: 'valorindicador', name: 'valorindicador'},
                {data: 'fechaindicador', name: 'fechaindicador'},
                {data: 'tiempoindicador', name: 'tiempoindicador'},
                {data: 'origenindicador', name: 'origenindicador'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        }); 

        $('#createIndicador').click(function () {
            $('#btnSave').val("create-indicador");
            $('#idIndicador').val('');
            $('#frmRegistro').trigger("reset");
            $('#modelHeading').html("Crear nuevo indicador");
            $('#ajaxModel').modal('show');
        });        

        $('body').on('click', '.editIndicador', function () {
            var idIndicador = $(this).data('id');

            $.get("{{ route('indicadors.index') }}" +'/' + idIndicador +'/edit', function (data) {
                $('#modelHeading').html("Editar indicador");
                $('#btnSave').val("edit-indicador");
                $('#ajaxModel').modal('show');
                $('#idIndicador').val(data.id);
                $('#txtNombre').val(data.nombreindicador);
                $('#txtCodigo').val(data.codigoindicador);
                $('#selUnidad').val(data.unidadmedidaindicador);
                $('#txtValor').val(data.valorindicador);
                $('#txtFecha').val(data.fechaindicador);
                $('#txtTiempo').val(data.tiempoindicador);
                $('#selOrigen').val(data.origenindicador);
            })
        });

        $('#btnSave').click(function (e) {
            e.preventDefault();

            $(this).html('Guardar');
        
            $.ajax({
                data: $('#frmRegistro').serialize(),
                url: "{{ route('indicadors.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('#frmRegistro').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();
                
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#btnSave').html('Guardar cambios');
                }
            });
        });      
                
        $('body').on('click', '.deleteIndicador', function () {
            var idIndicador = $(this).data("id");
            confirm("Esta seguro de eliminar el indicador?");
        
            $.ajax({
                type: "DELETE",
                url: "{{ route('indicadors.store') }}" + '/' + idIndicador,
                success: function (data) {
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });        
    });
    </script>
</body>
</html>