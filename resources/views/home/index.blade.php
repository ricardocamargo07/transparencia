@extends('templates.default')

@section('content')



    <div class="row ">
        <div class="col-md-12 text-center conteudo">
            <div class="introducao">
                <h2>INFORMAÇÃO É PODER </h2>
                <h3>Seja bem-vindo ao Portal da Transparência da Alerj!</h3>

                <div class="intro01">

                    <p>A Assembleia Legislativa do Estado do Rio de Janeiro (Alerj), honrando sua tradição de pioneirismo, foi a primeira casa legislativa do país e a primeira instituição pública do estado a lançar seu Portal da Transparência, em 21 de maio de 2012.</p>

                    <p>A medida atende às determinações da Lei 12.527/2011, de Acesso à Informação, de 18 de novembro de 2011, em vigor desde maio de 2012.</p>

                </div>

                <div class="intro2">

                    <p>A <a href="http://www.planalto.gov.br/ccivil_03/_ato2011-2014/2011/lei/l12527.htm" target="_blank">LAI</a> permite que qualquer pessoa física ou jurídica requisite informações públicas – um direito constitucional – sem que precise apresentar motivo para tal. A norma vale para os três Poderes da União, Estados, Municípios e Distrito Federal, inclusive Tribunais de Contas e Ministério Público. Engloba, ainda, entidades privadas que recebam recursos públicos.</p>

                    <p>A Alerj entende que Transparência vai muito além da mera disponibilização de dados. Ela passa também pela efetiva participação, acompanhamento e fiscalização por parte da sociedade para o exercício pleno da cidadania. E isso só é possível a partir do acesso das pessoas à informação.</p>
                    <p>Informação é Poder. E, na Alerj, você tem poder!</p>

                </div>
            </div>


            @foreach($sections as $section)
                <div class="col-md-6 col-lg-4 text-center">
                    <div class="box">
                        <div class="box-content">

                            <h3 class="tag-title">{{ $section['title'] }}</h3>

                            <div class="icones-tranparencia">
                                <img class="tag-icon" src="{{ $section['icon'] }}">
                            </div>

                            <ul class="itens-transparencia">
                                @foreach(collect($section['links'])->take($countLimit = config('app.items_limit_on_home')) as $link)
                                    <li class="btn"><a href="{{ $link['link'] }}">{{ $link['title'] }}</a></li>
                                @endforeach
                            </ul>

                            <br />
                            {{--@if (collect($section['links'])->count() > $countLimit)--}}
                                {{--<a href="{{ route('section', [$section['id']]) }}" class="btn btn-block btn-primary">--}}
                                    {{--<i class="fa fa-plus-circle" aria-hidden="true"></i>--}}
                                {{--</a>--}}
                            {{--@else--}}
                                {{--<span class="btn btn-block btn-primary"></span>--}}
                            {{--@endif--}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@stop
