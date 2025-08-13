@extends('adminlte::page')
@section('title', 'Editar envío')
@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endsection
@section('content')
<div class="editar-envio pt-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header text-center">
                    <h3 class="card-title">Editar envío de materiales</h3>
                </div>
                <div class="card-body">
                    {!! Form::model($reporte, ['route' => ['admin.editar.post.enviosEventosReportes', $reporte->id], 'method' => 'PUT']) !!}
                    <h5 class="font-weight-bold">Información del envío</h5>

                    <div class="row form-group mb-3">
                        {!! Form::label('fecha_envio', 'Fecha de envío *', ['class' => 'col-md-3 text-right control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::date('fecha_envio', null, ['class' => 'form-control', 'required']) !!}
                        </div>
                    </div>

                    <div class="row form-group mb-3">
                        {!! Form::label('nombre_evento', 'Nombre del evento *', ['class' => 'col-md-3 text-right control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::text('nombre_evento', null, ['class' => 'form-control', 'required']) !!}
                        </div>
                    </div>

                    <div class="row form-group mb-3">
                        {!! Form::label('direccion_entrega', 'Dirección de entrega *', ['class' => 'col-md-3 text-right control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::text('direccion_entrega', null, ['class' => 'form-control', 'required']) !!}
                        </div>
                    </div>

                    <div class="row form-group mb-3">
                        {!! Form::label('observaciones', 'Observaciones', ['class' => 'col-md-3 text-right control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::textarea('observaciones', null, ['class' => 'form-control', 'rows' => 3]) !!}
                        </div>
                    </div>

                    <div class="row form-group mb-3">
                        {!! Form::label('id_destinatario', 'Destinatario *', ['class' => 'col-md-3 text-right control-label']) !!}
                        <div class="col-md-9">
                            <select name="id_destinatario" id="id_destinatario" class="form-control" style="width: 100%"></select>
                        </div>
                    </div>

                    <div class="row form-group mb-3">
                        {!! Form::label('id_responsable', 'Responsable *', ['class' => 'col-md-3 text-right control-label']) !!}
                        <div class="col-md-9">
                            <select name="id_responsable" id="id_responsable" class="form-control" style="width: 100%"></select>
                        </div>
                    </div>

                    <hr>
                    <h5 class="font-weight-bold">Materiales gráficos enviados</h5>
                    <table class="table table-bordered" id="tabla-materiales">
                        <thead>
                            <tr>
                                <th>Material</th>
                                <th>Cantidad</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($materialesEnviados as $i => $detalle)
                            <tr>
                                <td>
                                    <select name="materiales[{{ $i }}][id]" class="form-control" required>
                                        <option value="">Seleccione...</option>
                                        @foreach ($materiales as $mat)
                                            <option value="{{ $mat->id }}" {{ $mat->id == $detalle->id_material_grafico ? 'selected' : '' }}>
                                                {{ $mat->nombre }} (Disponible: {{ $mat->cantidad }})
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="materiales[{{ $i }}][cantidad]" value="{{ $detalle->cantidad_enviada }}" class="form-control" min="1" required>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-danger btn-sm eliminar-fila">X</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-secondary btn-sm" id="agregar-fila">Agregar material</button>

                    <div class="mt-4 text-center">
                         <a href="{{ route('admin.listar.enviosEventosReportes') }}" class="btn btn-secondary btn-lg px-4 mr-2">
                                <i class="fas fa-arrow-left"></i> Atrás
                            </a>
                        {!! Form::submit('Actualizar reporte', ['class' => 'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    let index = {{ count($materialesEnviados) }};

    //Haciendo uso de la funcion select2 de JQuery, inicializa el campo de destinatario con Select2, 
    // permite buscar usuarios (destinatarios) vía AJAX
    // y muestrar resultados dinámicos con mensajes personalizados
    $('#id_destinatario').select2({
    ajax: {
        url: '{{ route('admin.destinatarios.select') }}',
        dataType: 'json',
        delay: 250,
        data: function(params) {
            return { search: params.term };
        },
        processResults: function(data) {
            return { results: data };
        },
        cache: true
    },
    placeholder: 'Seleccione un responsable',
    minimumInputLength: 1,
    language: {
        inputTooShort: function () {
            return 'Por favor, escriba al menos una letra.';
        },
        searching: function () {
            return 'Buscando destinatarios...';
        },
        noResults: function () {
            return 'No se encontraron destinatarios con ese nombre.';
        }
    }
    
});
//Haciendo uso de la funcion select2 de JQuery, inicializa el campo de destinatario con Select2, 
    // permite buscar usuarios (responsables) vía AJAX
    // y muestrar resultados dinámicos con mensajes personalizados
$('#id_responsable').select2({
    ajax: {
        url: '{{ route('admin.destinatarios.select') }}',
        dataType: 'json',
        delay: 250,
        data: function(params) {
            return { search: params.term };
        },
        processResults: function(data) {
            return { results: data };
        },
        cache: true
    },
    placeholder: 'Seleccione un responsable',
    minimumInputLength: 1,
    language: {
        inputTooShort: function () {
            return 'Por favor, escriba al menos una letra.';
        },
        searching: function () {
            return 'Buscando destinatarios...';
        },
        noResults: function () {
            return 'No se encontraron destinatarios con ese nombre.';
        }
    }
    
});

     // funcion de esccucha encargada de Agrega una nueva fila a la tabla de materiales, al hacer click en el botón "agregar material", con un select de materiales y un input de cantidad.
    // Cada fila incluye un botón para eliminarla. El índice se incrementa para mantener nombres únicos en los inputs.
    document.getElementById('agregar-fila').addEventListener('click', function () {
        const tabla = document.querySelector('#tabla-materiales tbody');
        const nuevaFila = `
            <tr>
                <td>
                    <select name="materiales[${index}][id]" class="form-control" required>
                        <option value="">Seleccione...</option>
                        @foreach ($materiales as $mat)
                            <option value="{{ $mat->id }}">{{ $mat->nombre }} (Disponible: {{ $mat->cantidad }})</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="materiales[${index}][cantidad]" class="form-control" min="1" required>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm eliminar-fila">X</button>
                </td>
            </tr>`;
        tabla.insertAdjacentHTML('beforeend', nuevaFila);
        index++;
    });

    //funcion de escucha para eliminar una fila de la tabla de materiales
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('eliminar-fila')) {
            e.target.closest('tr').remove();
        }
    });
</script>
@endsection