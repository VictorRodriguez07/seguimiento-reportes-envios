@extends('adminlte::page')

@section('title', 'Editar material gráfico')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/jquery-ui/jquery-ui.min.css') }}">
@endsection

@section('content')
    <div class="editar-material pt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header text-center">
                        <h2 class="card-title">Editar material gráfico</h2>
                    </div>
                    <div class="card-body">
                        {!! Form::model($material, ['route' => ['admin.materiales.post.editar', $material], 'method' => 'PUT', 'class' => 'form-horizontal', 'files' => true]) !!}
                        
                        {{-- Nombre --}}
                        <div class="row mb-3 align-items-center @if($errors->has('nombre')) has-error @endif">
                            {!! Form::label('nombre', 'Nombre *', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Nombre del material', 'required', 'maxlength' => '100']) !!}
                                <p class="help-block text-danger">{{ $errors->first('nombre') }}</p>
                            </div>
                        </div>

                        {{-- Cantidad --}}
                        <div class="row mb-3 align-items-center @if($errors->has('cantidad')) has-error @endif">
                            {!! Form::label('cantidad', 'Cantidad *', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::number('cantidad', null, ['class' => 'form-control', 'min' => 0, 'required']) !!}
                                <p class="help-block text-danger">{{ $errors->first('cantidad') }}</p>
                            </div>
                        </div>

                        {{-- Disponible --}}
                        <div class="row mb-3 align-items-center @if($errors->has('disponible')) has-error @endif">
                            {!! Form::label('disponible', '¿Disponible? *', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9 pt-1">
                                <div class="form-check form-check-inline">
                                    {{ Form::radio('disponible', 0, $material->disponible == 0, ['class' => 'form-check-input', 'id' => 'disponible_si']) }}
                                    {!! Form::label('disponible_si', 'Sí', ['class' => 'form-check-label']) !!}
                                </div>
                                <div class="form-check form-check-inline">
                                    {{ Form::radio('disponible', 1, $material->disponible == 1, ['class' => 'form-check-input', 'id' => 'disponible_no']) }}
                                    {!! Form::label('disponible_no', 'No', ['class' => 'form-check-label']) !!}
                                </div>
                                <p class="help-block text-danger">{{ $errors->first('disponible') }}</p>
                            </div>
                        </div>

                        {{-- Tipo de material gráfico --}}
                        <div class="row mb-3 align-items-center @if($errors->has('tipo_material_grafico_id')) has-error @endif">
                            {!! Form::label('tipo_material_grafico_id', 'Tipo de material gráfico *', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::select('tipo_material_grafico_id', $tipos_materiales, $material->tipo_material_grafico_id, ['class' => 'form-control', 'required']) !!}
                                <p class="help-block text-danger">{{ $errors->first('tipo_material_grafico_id') }}</p>
                            </div>
                        </div>

                        {{-- Imagen --}}
                        <div class="row mb-3 align-items-center @if($errors->has('img')) has-error @endif">
                            {!! Form::label('img', 'Imagen', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::file('img', ['class' => 'form-control']) !!}
                                @if($material->img)
                                    <div class="mt-3">
                                        <strong>Imagen actual:</strong><br>
                                        <img src="{{ asset('storage/' . $material->img) }}" alt="Imagen actual" class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                @endif
                                <p class="help-block text-danger">{{ $errors->first('img') }}</p>
                            </div>
                        </div>

                        {{-- Botón --}}
                        <div class="form-group text-center mt-4">
                            <a href="{{ route('admin.materiales.listar') }}" class="btn btn-secondary btn-lg px-4 mr-2">
                                <i class="fas fa-arrow-left"></i> Atrás
                            </a>

                            {!! Form::submit('Actualizar', ['class' => 'btn btn-primary btn-lg px-4']) !!}
                        </div>


                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
