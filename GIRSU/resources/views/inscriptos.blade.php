@extends('layouts.app')

@section('content')
    <center>
    <?php
        require './GIRSU/vendor/autoload.php';
    ?>
        <div class="montserrat bienvenido">Bienvenido {{$user}}</div>
        <!--NavBar-->
        <div class="container-fluid my-4">
            <div class="row">
                <div class="col-md-2">
                    <div class="card paddingYBI">
                        <div class="card-body">
                            <ul class="navbar-nav navegacion">
                                <li class="nav-item py-2 nunito"><a class="nav-link" href="{{ url('/home') }}"><span class="fas fa-user-check iconosHome"></span> Acreditados</a></li>
                                <li class="nav-item py-2 nunito active inscriptosI"><a class="nav-link" href="#"><span class="fas fa-users iconosHome"></span> Inscriptos</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-10 my-4">
                    <table id="tableInscriptos" class='table table-sm table-hover table-responsive monserrat' data-route="{{Route('datatable.inscriptos')}}">
                        <thead class="thead-dark">
                            <tr>
                                <th>DNI</th>
                                <th>NOMBRE</th>
                                <th>APELLIDO</th>
                                <th>MAIL</th>
                                <th>TIPO</th>
                                <th>TELEFONO</th>
                                <th>COMPAÑIA</th>
                                <th>TRABAJO</th>
                                <th>DIRECCION</th>
                                <th>DEPARTAMENTO</th>
                                <th>PROVINCIA</th>
                                <th>PAIS</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </center>
@endsection
@section('script')
    <script src="{{ asset('js/jsFiles/impresionInscriptos.js') }}"></script>
@endsection