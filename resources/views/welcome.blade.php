<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div id="app">
            <div class="flex-center position-ref full-height">
                @if (Route::has('login'))
                    <div class="top-right links">
                        @if (Auth::check())
                            <a href="{{ url('/home') }}">Home</a>
                        @else
                            <a href="{{ url('/login') }}">Login</a>
                            <a href="{{ url('/register') }}">Register</a>
                        @endif
                    </div>
                @endif

                <div class="content">
                    <div class="title m-b-md">
                        @{{ name }}
                    </div>

                    <div class="links">
                        <a href="https://laravel.com/docs">Documentation</a>
                        <a href="https://laracasts.com">Laracasts</a>
                        <a href="https://laravel-news.com">News</a>
                        <a href="https://forge.laravel.com">Forge</a>
                        <a href="https://github.com/laravel/laravel">GitHub</a>
                    </div>
                </div>
            </div>
        </div>

        <script src="/js/app.js"></script>
    </body>
</html>

<div class="row faq">
    <div class="col-xs-12">
        <div class="item">
            <h4>Tem um número de protocolo?</h4>

            <p>Se já possui um número de protocolo, você pode acompanhar seu pedido pelo site da Alerj. Clique no botão abaixo para acessar o formulário:</p>

            <div class="row form-botoes">
                <div class="col-md-12">
                    <a href="http://www2.alerj.rj.gov.br/leideacesso/formulario-2016.asp" class="btn btn-primary btn-block">
                        <i class="fa fa-desktop" aria-hidden="true"></i>Formulário online
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row faq">
    <div class="col-xs-12">
        <div class="item">
            <h4>Pedido Presencial</h4>
            <p>Ligue grátis para o Alô Alerj no telefone 0800-0220008.</p>
        </div>
    </div>
</div>

<div class="row faq">
    <div class="col-xs-12">
        <div class="item">
            <h4>Pedido Eletrônico</h4>
            <p>Entre na página do Web Chat da ALERJ e fale com nossos atendentes através do <a href="https://www.aloalerj.rj.gov.br">Alô Alerj</a></p>
        </div>
    </div>
</div>
