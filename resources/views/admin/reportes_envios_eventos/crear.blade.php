@extends('adminlte::page')
@section('title', 'Crear usuario')
@section('content')
<div class="pt-3">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card card-primary card-outline">
                <div class="card-header text-center">
                    <h3 class="card-title">Registrar nuevo envío</h3>
                </div>

                <form action="{{route('admin.store.enviosEventosReportes')}}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="fecha_envio">Fecha de envío</label>
                            <input type="date" name="fecha_envio" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="nombre_evento">Nombre del evento</label>
                            <input type="text" name="nombre_evento" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="direccion_entrega">Dirección de entrega</label>
                            <input type="text" name="direccion_entrega" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="observaciones">Observaciones</label>
                            <textarea name="observaciones" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="id_destinatario">Destinatario</label>
                            <select name="id_destinatario" id="id_destinatario" class="form-control" style="width: 100%"></select>
                        </div>

                        <div class="form-group">
                            <label for="id_responsable">Responsable</label>
                            <select name="id_responsable" id="id_responsable" class="form-control" style="width: 100%"></select>
                        </div>

                        <hr>
                        <h5>Materiales gráficos enviados</h5>
                        <table class="table table-bordered" id="tabla-materiales">
                            <thead>
                                <tr>
                                    <th>Material</th>
                                    <th>Cantidad</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select name="materiales[0][id]" class="form-control" required>
                                            <option value="">Seleccione...</option>
                                            @foreach ($materiales as $mat)
                                                <option value="{{ $mat->id }}">{{ $mat->nombre }} (Disponible: {{ $mat->cantidad }})</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="materiales[0][cantidad]" class="form-control" min="1" required>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger btn-sm eliminar-fila">X</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-secondary btn-sm" id="agregar-fila">Agregar material</button>
                    </div>

                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary">Guardar envío</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    let index = 1;

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

    document.getElementById('agregar-fila').addEventListener('click', function() {
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
            </tr>
        `;
        tabla.insertAdjacentHTML('beforeend', nuevaFila);
        index++;
    });

    //funccion de escucha para eliminar una fila de la tabla de materiales
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('eliminar-fila')) {
            e.target.closest('tr').remove();
        }
    });

   


</script>
@endsection
