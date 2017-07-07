<!DOCTYPE html>
<html>
    <head>
        <title>Alerj - Transparência</title>
        <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=Edge" /><meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <![endif]-->
        <meta charset="utf-8" />
        <meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />
        <link rel="stylesheet" type="text/css" href="http://legislaqui.antoniocarlosribeiro.com/www.alerj.rj.gov.br/jquery-ui.css" />
        <link rel="stylesheet" type="text/css" href="http://legislaqui.antoniocarlosribeiro.com/www.alerj.rj.gov.br/colorpicker.css" />
        <link rel="stylesheet" type="text/css" href="http://legislaqui.antoniocarlosribeiro.com/www.alerj.rj.gov.br/datepicker.css" />
        <link rel="stylesheet" type="text/css" href="http://legislaqui.antoniocarlosribeiro.com/www.alerj.rj.gov.br/lightbox.css" />
        <link rel="stylesheet" type="text/css" href="http://legislaqui.antoniocarlosribeiro.com/www.alerj.rj.gov.br/jquery.jscrollpane.css" />
        <link rel="stylesheet" type="text/css" href="http://legislaqui.antoniocarlosribeiro.com/www.alerj.rj.gov.br/jquery-ui.theme.css">
        <link rel="stylesheet" type="text/css" href="http://legislaqui.antoniocarlosribeiro.com/www.alerj.rj.gov.br/jquery-ui.structure.css">
        <link rel="stylesheet" type="text/css" href="http://legislaqui.antoniocarlosribeiro.com/www.alerj.rj.gov.br/estilos.css" />

        <!-- Styles -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Loading Bootstrap -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="/css/custom.css" />
        <link rel="stylesheet" href="/css/styles.css">
        <link rel="stylesheet" href="/css/tabelas.css">

        @if (request()->get('client') == 'app')
            <link rel="stylesheet" href="/css/client-app.css">
        @endif

        <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>

    <body>
        <div id="app">
            @if (request()->get('client') !== 'app')
                @include('templates.superior')

                @include('templates.menu')
            @endif

            <div class="fundo transparencia">
                <div class="container-full titulo-portal text-center">
                    <div class="row">
                        <div class="col-xs-8 col-xs-offset-2 col-sm-6 col-sm-offset-3">
                            <h1>Portal da Transparência</h1>
                            @yield('h2-title')
                        </div>
                        <div class="col-xs-2 refresh-cache pull-right" >
                            <div class="">
                                <a href="{{ route('cache.clear') }}">
                                    <i class="fa fa-refresh"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="container">
                    @yield('content')
                </div>
            </div>
        </div>

        <script src="/js/app.js"></script>

        <script>
            function goBack() {
                window.history.back();
            }
        </script>

        @yield('javascript')

        @include('partials.google-analytics')
    </body>
</html>
