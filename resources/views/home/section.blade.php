@extends('templates.default')

@section('content')
    <div class="row">
        <div class="row text-center">
            <div class="col-md-12 text-center">
                <h1>Portal da Transparência</h1>
            </div>

            <div class="col-md-offset-2 col-md-8 text-center">
                <div class="box">
                    <div class="box-content">
                        <h2>{{ $section['title'] }}</h2>

                        <img class="tag-icon" src="{{ $section['icon'] }}">

                        <ul>
                            @foreach ($section['links'] as $link)
                                <li><a href="{{ $link['link'] }}">{{ $link['title'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12" style="margin-top: 80px;">
            <button onclick="goBack()" class="btn btn-block btn-primary">
                Voltar
            </button>
        </div>
    </div>
@stop
