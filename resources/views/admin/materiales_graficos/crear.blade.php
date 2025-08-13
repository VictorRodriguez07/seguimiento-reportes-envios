@extends('adminlte::page')

@section('title', 'Registrar Material Gráfico')

@section('content')
<div class="container pt-3">
    <div class="row">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <div class="card card-primary card-outline">
                <div class="card-header text-center">
                    <h2 class="card-title">Registrar Material Gráfico</h2>
                </div>

                <div class="card-body">
                    {!! Form::open(['route' => 'admin.registrar.material.evento.store', 'files' => true]) !!}

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group @error('nombre') has-error @enderror">
                                {!! Form::label('nombre', 'Nombre del material*') !!}
                                {!! Form::text('nombre', old('nombre'), ['class' => 'form-control', 'required']) !!}
                                <p class="help-block">{{ $errors->first('nombre') }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group @error('cantidad') has-error @enderror">
                                {!! Form::label('cantidad', 'Cantidad disponible*') !!}
                                {!! Form::number('cantidad', old('cantidad'), ['class' => 'form-control', 'required', 'min' => 1]) !!}
                                <p class="help-block">{{ $errors->first('cantidad') }}</p>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group @error('tipo_material_grafico_id') has-error @enderror">
                                {!! Form::label('tipo_material_grafico_id', 'Tipo de material gráfico*') !!}
                                {!! Form::select('tipo_material_grafico_id', $tipos->pluck('nombre', 'id'), old('tipo_material_grafico_id'), ['class' => 'form-control', 'placeholder' => 'Seleccione un tipo...', 'required']) !!}
                                <p class="help-block">{{ $errors->first('tipo_material_grafico_id') }}</p>
                            </div>
                        </div>

                    
                        <div class="col-md-12">
                            <div class="form-group @error('img') has-error @enderror">
                                {!! Form::label('img', 'Imagen del material*') !!}
                                {!! Form::file('img', ['class' => 'form-control-file', 'accept' => 'image/*', 'required']) !!}
                                <p class="help-block">{{ $errors->first('img') }}</p>
                            </div>
                        </div>

                    </div>

                  
                    <div class="row">
                        <div class="col-md-4 offset-md-4">
                            {!! Form::submit('Registrar', ['class' => 'btn btn-primary btn-block']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
