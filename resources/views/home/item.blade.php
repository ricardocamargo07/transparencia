@extends('templates.default')

@section('h2-title')
    <h2>{{ $item['section']['title'] }}</h2>
@stop

@section('content')
    <div class="row">
        <div class="col-md-offset-1 col-md-10 text-center">
            <div class="">
                <div class="box-content-item">
                    <h3 class="">{{ $item['title'] }}</h3>

                    @if ($body = $item['html'] ?: $item['body'])
                        <div class="introduction">
                            {!! $body !!}
                        </div>
                    @endif
                </div>
            </div>

            @if (isset($item['files']) && $item['files']->count())
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    @foreach ($item['files'] as $year => $files)
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading-{{ $year }}">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse-{{ $year }}" aria-expanded="true" aria-controls="collapse-{{ $year }}">
                                        {{ $year }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse-{{ $year }}" class="panel-collapse collapse {{ ! isset($in) ? $in = 'in' : '' }}" role="tabpanel" aria-labelledby="heading-{{ $year }}">
                                <div class="panel-body">
                                    @foreach ($files as $group)
                                        <div class="row linha-mes">
                                            <div class="col-xs-5 col-md-offset-3 col-md-3 mes-label">
                                               {{ $group[0]['title'] }}
                                            </div>

                                            <div class="col-xs-7 col-md-3 tipos-downloads">
                                                @foreach($group as $file)
                                                    <a href="{{ $file['url'] }}" download>
                                                        <i class="btn fa fa-file-{{ $file['file_type'] }}-o" aria-hidden="true">
                                                            <span class="label-dowload-tipo">{{ $file['file_type'] }}</span>
                                                        </i>
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="row">
            <div class="col-xs-offset-3 col-xs-6 col-md-offset-5 col-md-2">
                <a href="{{ URL::previous() }}" class="btn btn-block btn-primary voltar"> <i class="fa fa-step-backward" aria-hidden="true"></i> Voltar</a>
            </div>
        </div>
    </div>
@stop
