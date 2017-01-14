@extends('templates.default')

@section('h2-title')
    <h2>Acompanhe seu pedido de informação na Alerj</h2>
@stop

@section('content')
    <div class="row">
        <div class="col-md-offset-1 col-md-10 text-center">
            <div class="">
                <div class="box-content-item">
                    <h3 class="">Protocolo {{ $protocol['protocol'] }}</h3>
                </div>
            </div>

            <div class="row faq">
                <div class="col-xs-12">
                    <div class="item">
                        <h4>Situação atual do pedido</h4>
                            <div class="row protocol-answer-row">
                                <div class="col-md-2 bold">
                                    Nome
                                </div>

                                <div class="col-md-10">
                                    {{ $protocol['name'] }}
                                </div>
                            </div>

                            <div class="row protocol-answer-row">
                                <div class="col-md-2 bold">
                                    Data
                                </div>

                                <div class="col-md-10">
                                    {{ $protocol['created_at'] }}
                                </div>
                            </div>

                            <div class="row protocol-answer-row">
                                <div class="col-md-2 bold">
                                    Pergunta
                                </div>

                                <div class="col-md-10">
                                    {{ $protocol['question'] }}
                                </div>
                            </div>

                            <div class="row protocol-answer-row">
                                <div class="col-md-2 bold">
                                    Resposta
                                </div>

                                <div class="col-md-10">
                                    @if ($protocol['answer'])
                                        {{ $protocol['answer'] }}
                                    @else
                                        Ainda não há resposta para este pedido.
                                    @endif
                                </div>
                            </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-offset-5 col-md-2">
                <a href="{{ URL::previous() }}" class="btn btn-block btn-primary voltar"> <i class="fa fa-step-backward" aria-hidden="true"></i> Voltar</a>
            </div>
        </div>
    </div>
@stop
