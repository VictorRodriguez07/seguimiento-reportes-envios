@extends('adminlte::master')

@section('title', 'Página no encontrada')

@section('body_class', 'login-page')

@section('body')
<div class="container">
    <div class="row">
    	<div class="col-md-4 offset-md-4" style="margin-top: 40px">
        	<a href="{{ route('login') }}"><img src="{{ asset('imgs/logo-tqi.png') }}" class="img-responsive"></a>
    	</div>
        <div class="col-md-12 text-center" style="margin-top: 40px">
            <h1>Ups has llegado al lugar equivocado, intenta ir atras</h1>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(function() {
});
</script>
@stop