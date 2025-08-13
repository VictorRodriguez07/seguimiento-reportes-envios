@extends('adminlte::page')

@section('title', 'Ver materiales gráficos')

@section('content')
<div class="ver-materiales pt-3">
    <div class="row">
        @if (session('status'))
            <div class="col-md-12">
                <div class="alert alert-success text-center">
                    {{ session('status') }}
                </div>
            </div>
        @endif

        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header text-center">
                    <h2 class="card-title">Listado de materiales gráficos</h2>
                </div>
                <div class="card-body">
                        <table class="table table-bordered table-striped" id="materiales-table">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Tipo</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-center">Disponible</th>
                                    <th class="text-center">Imagen</th>
                                    <th class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($materiales as $material)
                                    <tr>
                                        <td class="text-center align-middle" >{{$material->id}}</td>
                                        <td class="text-center align-middle">{{ $material->nombre }}</td>
                                        <td class="text-center align-middle">{{ $material->tipo }}</td>
                                        <td class="text-center align-middle">{{ $material->cantidad }}</td>
                                        <td class="text-center align-middle">
                                            @if ($material->disponible == 0)
                                                <span class="badge bg-success">Sí</span>
                                            @else
                                                <span class="badge bg-danger">No</span>
                                            @endif
                                        </td>
                                        <td class="text-center align-middle">
                                            @if ($material->img)
                                                <img src="{{ asset('storage/' . $material->img) }}" alt="Imagen" class="img-thumbnail" style="max-width: 70px;">
                                            @else
                                                <span class="text-muted">Sin imagen</span>
                                            @endif
                                        </td>
                                        <td class="text-center align-middle" style="min-width: 180px;">
                                            <a href="{{ route('admin.materiales.editar', $material->id) }}" class="btn btn-xs btn-primary">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                            <button class="btn btn-danger btn-xs">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                </div> 
            </div> 
        </div>
    </div> 
</div> 
@endsection
