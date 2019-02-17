$(function() {
    var funcionesHome = {};
        (function(app){
            app.init = function(){
                $.noConflict();
                app.dataTable();
                app.bindings();
            }
            
            app.dataTable = function() {
                $('#tableAcreditados').DataTable({
                responsive: true,
                language: {
                    url: 'js/DataTables/Spanish.json', 
                    searchPlaceholder: 'Buscar Participante..'
                },
                processing: true,
                serverSide: true,
                aaSorting: [],
                ajax: {
                    url: $('#tableAcreditados').data('route'),
                },
                columns: [
                    {data: 'dni', name: 'dni', responsivePriority: 1},
                    {data: 'nombre', name: 'nombre', responsivePriority: 3 },
                    {data: 'apellido', name: 'apellido', responsivePriority: 2 },
                    {data: 'email', name: 'email'},
                    {data: 'ticket_type', name: 'ticket_type'},
                    {data: 'celular', name: 'celular'},
                    {data: 'company', name: 'company'},
                    {data: 'empleo', name: 'empleo'},
                    {data: 'workAdress1', name: 'workAdress1'},
                    {data: 'workCity', name: 'workCity'},
                    {data: 'workState', name: 'workState'},
                    {data: 'workCountry', name: 'workCountry'},
                    {data: 'Acciones',
                        "orderable": false,
                        "searchable": false,
                        "render": function (data, type, row, meta){
                            var a = "<form action='credencial/"+ row.eventbrite_id +"' method='POST'>"+
                                    "   <button class='btn btn-link impresionCreButton' style='font-size: 95%; margin-bottom: -18px; margin-left: -5px; margin-right: -15px; margin-top: -10px;'>Imprimir Credencial</button>"+
                                    "</form>"+
                                    "<form action='certificadoPre/"+ row.eventbrite_id +"' method='POST'>"+
                                    "   <button class='btn btn-link impresionCertButton' style='font-size: 95%; margin-bottom: -10px; margin-left: -5px; margin-right: -15px;'>Imprimir Certificado</button>"+
                                    "</form>"+
                                    "   <button class='btn btn-link btn-mail' data-id_participante='" + row.eventbrite_id + "' style='font-size: 95%; margin-bottom: -10px; margin-left: -5px; margin-right: -15px;'>Enviar por mail</button>"
                            return a;
                        }, responsivePriority: 4 
                    }
                ]
            });
            }
            
            app.bindings = function(){
                
                $('#enviarEmail').on('click', function(){
                    app.sendMailIndividual($('#eventbrite_id').attr("value"));
                    $('#mailConfirm').modal('hide');
                    $('#mailWait').modal({show:true});
                })
            
                $('#tbodyAcreditados').on('click', '.btn-mail', function(){
                    $('#mailConfirm').modal({show:true});
                    $('#eventbrite_id').val($(this).attr("data-id_participante"));
                });
                
                $('#selecTodosImp').on('click', function(){
                    $('input:checkbox').not(this).prop('checked', this.checked);
                });
                $('#selecTodosMail').on('click', function(){
                    $('input:checkbox').not(this).prop('checked', this.checked);
                }); 
                
            }
            
            app.sendMailIndividual = function(id){
                $.ajax({
                    url: "/certificadoVirtual",
                    type: 'POST',
                    data: {id: id, _token: $('#signup-token').val()},
                    dataType: 'json',
                    success: function(res){
                        var alert = '<div class="alert alert-success" id="alert">'+
                                        'Email enviado correctamente' +
                                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                                        '<span aria-hidden="true">&times;</span>' +
                                        '</button>' +
                                    '</div>' ;
                        $('#mailWait').modal('hide');
                        $('#alertSuccess').html(alert);
                    },
                    error: function(res){
                        console.log(res);
                    }   
                         
                })
            }
            
            $('div.alert').delay(5000).slideUp(500);
            $('#alert').delay(5000).slideUp(500);
            app.init();
            
        })(funcionesHome);
});