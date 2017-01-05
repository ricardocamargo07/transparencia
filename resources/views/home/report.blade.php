@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-md-12 text-center conteudo">
            <h1>Portal da Transparência</h1>

            <h2>{{ $report['section']['title'] }}</h2>
        </div>

        <div class="col-md-offset-2 col-md-8 text-center">
            <div class="box">
                <div class="box-content">
                    <h3>{{ $report['title'] }}</h3>
                    <p></p>

                    @if ($report['body'])
                        <div class="introduction">
                            {!! $report['body'] !!}
                        </div>
                    @endif

                    @if ($report['files']->count())
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                            @foreach ($report['files'] as $year => $files)
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="heading1">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                                {{ $year }}
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1">
                                        <div class="panel-body">
                                            @foreach ($files as $file)
                                                <a href="{{ $file['url'] }}">{{ $file['title'] }}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-12" style="margin-top: 80px;">
                <a href="{{ URL::previous() }}" class="btn btn-block btn-primary">Voltar</a>
            </div>
        </div>
    </div>
@stop
