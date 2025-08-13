@extends('adminlte::master')

@section('title', 'Página expirada')

@section('body_class', 'login-page')

@section('body')
<div class="container">
    <div class="row">
    	<div class="col-md-4 offset-md-4" style="margin-top: 40px">
        	<a href="{{ route('login') }}"><img src="{{ asset('imgs/logo-tqi.png') }}" class="img-responsive"></a>
    	</div>
        <div class="col-md-12 text-center" style="margin-top: 40px">
            <h1>Al parecer ha pasado mucho tiempo de inactividad, refresca la página</h1>
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