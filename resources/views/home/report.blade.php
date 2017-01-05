@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-md-12 text-center conteudo">
            <h1>Portal da Transparência</h1>

            <h2>{{ $report['section']['title'] }}</h2>

            <h3>{{ $report['title'] }}</h3>
        </div>
    </div>
@stop
