@extends('templates.default')

@section('content')
    <div class="row text-center conteudo">
        <div class="col-md-12 text-center">
            <h1>Portal da Transparência</h1>
        </div>

        <div class="col-md-offset-2 col-md-8 text-center">
            <div class="box">
                <div class="box-content">
                    <h2>{{ $section['title'] }}</h2>

                </div>
            </div>
        </div>
    </div>
@stop
