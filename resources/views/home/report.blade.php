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

                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading1">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                        2016
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1">
                                <div class="panel-body">
                                    <p>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR></p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading2">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                        2015
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading2">
                                <div class="panel-body">
                                    <p>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR></p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading3">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                        2014
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3">
                                <div class="panel-body">
                                    <p>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR></p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading4">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                        2013
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading4">
                                <div class="panel-body">
                                    <p>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR></p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading5">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                        2012
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading5">
                                <div class="panel-body">
                                    <p>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR></p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading6">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse6" aria-expanded="false" aria-controls="collapse6">
                                        2011
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading6">
                                <div class="panel-body">
                                    <p>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR></p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading7">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse7" aria-expanded="false" aria-controls="collapse7">
                                        2010
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse7" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading7">
                                <div class="panel-body">
                                    <p>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR></p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading8">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse8" aria-expanded="false" aria-controls="collapse8">
                                        2009
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse8" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading8">
                                <div class="panel-body">
                                    <p>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR></p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading9">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse9" aria-expanded="false" aria-controls="collapse9">
                                        2008
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse9" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading9">
                                <div class="panel-body">
                                    <p>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR></p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading10">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse10" aria-expanded="false" aria-controls="collapse10">
                                        2007
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse10" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading10">
                                <div class="panel-body">
                                    <p>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR>conteudo conteudo conteudo<BR></p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop
