@extends('templates.default')

@section('h2-title')
    <h2>Como acompanhar seu pedido</h2>
@stop

@section('content')
    <div class="row">
        <div class="col-md-offset-1 col-md-10 text-center">
            <div class="">
                <div class="box-content-item">
                    <h3 class="">Acompanhe seu pedido de informação na Alerj</h3>
                </div>
            </div>

            <div class="row faq">
                <div class="col-xs-12">
                    <div class="item">
                        <h4>Digite o número do procotolo</h4>

                        <div class="row">
                            <form action="/protocolo" method="get">
                                <div class="coluna_04">
                                    <div style="padding-top: 20px">
                                        <textarea rows="1" class="js-obrigatorio" id="campoMensagem" name="mensagem" style="font-size: 2em; ">28812/2016</textarea>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="row form-botoes">
                            <div class="col-md-12">
                                <a href="/protocolo" class="btn btn-primary btn-block">
                                    <i class="fa fa-desktop" aria-hidden="true"></i>Pesquisar
                                </a>
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
