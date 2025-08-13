@extends('adminlte::page')

@section('title', 'Reportes de envíos de eventos')

@section('content')
<div class="pt-3">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card card-primary card-outline">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Listado de envíos</h3>
                    <a href="{{ route('admin.create.reporteEnvio') }}" class="btn btn-sm btn-primary">Registrar nuevo envío</a>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre del evento</th>
                                <th>Dirección de entrega</th>
                                <th>Fecha de envío</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reportesEnviosEventos as $reporte)
                                <tr>
                                    <td>{{ $reporte->id }}</td>
                                    <td>{{ $reporte->nombre_evento }}</td>
                                    <td>{{ $reporte->direccion_entrega }}</td>
                                    <td>{{ \Carbon\Carbon::parse($reporte->fecha_envio)->format('d/m/Y') }}</td>
                                    <td class="text-center ">
                                        <a href="{{route('admin.ver.enviosEventosReportes',$reporte->id)}}" class="btn btn-xs btn-info"><i class="fas fa-eye"></i> Ver reporte
                                        </a>
                                        <a href="{{route('admin.editar.enviosEventosReportes',$reporte->id)}}" class="btn btn-xs btn-primary">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <form action="" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('¿Estás seguro de eliminar este reporte?')">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </button>
                                        </form>
                                    </a>

                                    <a href="{{route('admin.descargar.reporteEnvioEvento.pdf',$reporte->id)}}" class="btn btn-danger btn-xs">
                                        <i class="fa fa-file-pdf"></i> Descargar PDF
                                    </a>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No hay reportes registrados.</td>
                                </tr>

                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

