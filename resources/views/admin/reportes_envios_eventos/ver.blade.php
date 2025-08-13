@extends('adminlte::page')

@section('title', 'Ver reporte de envío')

@section('content')
<div class="ver-reporte pt-3">
    <div class="row">
        @if (session('status'))
            <div class="col-md-12">
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            </div>
        @endif

        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header text-center">
                    <h2 class="card-title">Detalle del reporte de envío</h2>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        {!! Form::label('nombre_evento', 'Nombre del evento:') !!}
                        {{ $reporte->nombre_evento }}
                    </div>
                    <div class="form-group">
                        {!! Form::label('direccion_entrega', 'Dirección de entrega:') !!}
                        {{ $reporte->direccion_entrega }}
                    </div>
                    <div class="form-group">
                        {!! Form::label('fecha_envio', 'Fecha de envío:') !!}
                        {{ \Carbon\Carbon::parse($reporte->fecha_envio)->format('d/m/Y') }}
                    </div>
                    <div class="form-group">
                        {!! Form::label('observaciones', 'Observaciones:') !!}
                        {{ $reporte->observaciones ?? 'Sin observaciones' }}
                    </div>
                    <div class="form-group">
                        {!! Form::label('destinatario', 'Destinatario:') !!}
                        {{ $reporte->destinatario_nombre }}
                    </div>
                    <div class="form-group">
                        {!! Form::label('responsable', 'Responsable:') !!}
                        {{ $reporte->responsable_nombre }}
                    </div>

                    <hr>
                    <h5>Materiales gráficos enviados</h5>
                 
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Material</th>
                                    <th>Imagen</th>
                                    <th>Cantidad enviada</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @forelse($materiales as $mat)
                                        <tr>
                                            <td>{{ $mat->material_nombre }}</td>
                                             <td class="text-center">
                                    
                                                @if($mat->material_img)
                                                    <img src="{{ asset('storage/' . $mat->material_img) }}" alt="Imagen" width="60" class="img-thumbnail">
                                                @else
                                                    Sin imagen
                                                @endif
                                            </td>
                                            <td>{{ $mat->cantidad_enviada }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center">No se registraron materiales.</td>
                                        </tr>
                                    @endforelse
                                </tbody>

                        </table>
                    

                    <div class="row mt-4">
                        <div class="col-md-4 offset-md-4">
                            <a href="{{ route('admin.listar.enviosEventosReportes') }}" class="btn btn-default btn-block" role="button">Volver al listado</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
