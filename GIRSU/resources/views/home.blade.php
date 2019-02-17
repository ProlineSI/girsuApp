@extends('layouts.app')

@section('content')
    <center>
    <?php
        require './GIRSU/vendor/autoload.php';
  
    ?>  
        <input id="signup-token" name="_token" type="hidden" value="{{csrf_token()}}">
        @if (session('mensaje'))
            <div class="mx-5 my-1">
                <div class="alert alert-success">
                    {{ session('mensaje') }}
                </div>
            </div>
        @endif
        <div class="mx-5 my-1" id="alertSuccess">
        </div>
        <div class="montserrat bienvenido">Bienvenido {{$user}}</div>
        <!--NavBar-->
        <div class="container-fluid my-4">
            <div class="row">
                <div class="col-md-2">
                    <div class="card paddingYB">
                        <div class="card-body">
                            <ul class="navbar-nav navegacion">
                                <li class="nav-item py-2 active nunito"><a class="nav-link" href="{{ url('/home') }}"><span class="fas fa-user-check iconosHome"></span> Acreditados</a></li>
                                <li class="nav-item py-2 nunito inscriptos"><a class="nav-link" href="{{ url('/inscriptos') }}"><span class="fas fa-users iconosHome"></span> Inscriptos</a></li>
                                <li id="li_imprimir"><button class="btn btn-girsu my-2" data-toggle='modal' data-target='#impresionGral'>Imprimir Certificados</button></li>
                                <li><button class="btn btn-girsu" data-toggle='modal' data-target='#mailGral'>Enviar Emails</button></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-10 my-4">
                    <table id="tableAcreditados" class='table table-sm table-hover table-responsive monserrat' data-route="{{Route('datatable.acreditados')}}">
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
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyAcreditados">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal fade" aria-hidden="true" id="mailWait">
            <div class="modal-dialog modal-sm modal-dialog-centered ">
                <div class="modal-content">
                    <div class="modal-body backgroundAzul">
                        <h6 class="letraVerde">Enviando Email</h6>
                    </div>
                </div>
            </div>
        </div>
         <div class="modal fade" aria-hidden="true" id="mailConfirm">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content backgroundAzul">
                    <div class="modal-body">
                        <h6 class="letraVerde">Esta seguro que desea enviar el email?</h6>
                        <input type="hidden" id="eventbrite_id" value="">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-girsuInv" id="enviarEmail">Enviar</button>
                        <button class="btn btn-girsuInv" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" aria-hidden="true" id="impresionGral">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Seleccione Participantes</h5> 
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="checkbox" class="form-check-input" id="selecTodosImp"> Seleccionar Todos<br><hr>
                        <form action="/impresionGral" method="post">
                            @csrf
                            @foreach ( $participantes as $participante )
                                <div class="form-check my-2 border-bottom">
                                    <input type="checkbox" class="form-check-input" id="checkParticipante{{ $participante->eventbrite_id }}" name="check_impresion[]" value="{{ $participante->eventbrite_id }}">
                                    <label class="form-check-label" for="checkParticipante{{ $participante->eventbrite_id }}"><span class="font-weight-bold">Nombre: </span>{{ $participante->nombre }}</label><br>
                                    <label class="form-check-label" for="checkParticipante{{ $participante->eventbrite_id }}"><span class="font-weight-bold">Apellido: </span>{{ $participante->apellido }}</label><br>
                                    <label class="form-check-label" for="checkParticipante{{ $participante->eventbrite_id }}"><span class="font-weight-bold">Dni: </span>{{ $participante->dni }}</label>
                                </div>
                            @endforeach
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-girsu">Imprimir</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" aria-hidden="true" id="mailGral">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Seleccione Participantes</h5> 
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="checkbox" class="form-check-input" id="selecTodosMail"> Seleccionar Todos<br><hr>
                        <form action="/mailGral" method="post">
                            @csrf
                            @foreach ( $participantes as $participante )
                                <div class="form-check my-2 border-bottom">
                                    <input type="checkbox" class="form-check-input" id="checkParticipante{{ $participante->eventbrite_id }}" name="check_mail[]" value="{{ $participante->eventbrite_id }}">
                                    <label class="form-check-label" for="checkParticipante{{ $participante->eventbrite_id }}"><span class="font-weight-bold">Nombre: </span>{{ $participante->nombre }}</label><br>
                                    <label class="form-check-label" for="checkParticipante{{ $participante->eventbrite_id }}"><span class="font-weight-bold">Apellido: </span>{{ $participante->apellido }}</label><br>
                                    <label class="form-check-label" for="checkParticipante{{ $participante->eventbrite_id }}"><span class="font-weight-bold">Dni: </span>{{ $participante->dni }}</label>
                                </div>
                            @endforeach
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-girsu">Enviar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </center>
@endsection
@section('script')
    <script src="{{ asset('js/jsFiles/impresionHome.js') }}"></script>
@endsection