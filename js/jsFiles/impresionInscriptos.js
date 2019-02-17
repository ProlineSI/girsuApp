$(function() {
    $.noConflict(); 
    $('#tableInscriptos').DataTable({
        responsive: true,
        language: {
            url: 'js/DataTables/Spanish.json', 
            searchPlaceholder: 'Buscar Participante..'
        },
        processing: true,
        serverSide: true,
        aaSorting: [],
        ajax: {
            url: $('#tableInscriptos').data('route'),
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
            {data: 'workCountry', name: 'workCountry'}
        ]
    });
});