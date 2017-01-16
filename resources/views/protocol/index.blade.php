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
                    <div class="item protocolo">
                        <h4>Digite o número do procotolo</h4>

                        <form action="/protocolo" method="post">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}">

                            <div class="row">
                                <div class="col-xs-12">
                                    <div style="padding-top: 20px">
                                        <textarea name="protocol" rows="1" class="js-obrigatorio" id="campoMensagem" style="font-size: 2em; ">6.518/2012</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-botoes">
                                <div class="col-xs-8 col-xs-offset-2 col-md-4 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fa fa-desktop" aria-hidden="true"></i>Pesquisar
                                    </button>
                                </div>
                            </div>
                        </form>
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
