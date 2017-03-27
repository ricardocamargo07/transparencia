@extends('templates.default')

@section('content')
    <div class="row ">
        <div class="col-md-12 text-center conteudo">
            <div class="introducao">
                <h2 class="subtitle-home">Informação é poder</h2>
                <h3 class="subtitle-home">Seja bem-vindo ao Portal da Transparência da Alerj!</h3>

                <div class="intro01">
                    <p>A Assembleia Legislativa do Estado do Rio de Janeiro (Alerj), honrando sua tradição de pioneirismo, foi a primeira casa legislativa do país e a primeira instituição pública do estado a lançar seu Portal da Transparência, em 21 de maio de 2012.</p>
                    <p>A medida atende às determinações da Lei 12.527/2011, a Lei de Acesso à Informação, de 18 de novembro de 2011, em vigor desde maio de 2012.</p>
                </div>

                <div class="intro2">
                    <p>A <a href="http://www.planalto.gov.br/ccivil_03/_ato2011-2014/2011/lei/l12527.htm" target="_blank">LAI</a> permite que qualquer pessoa física ou jurídica requisite informações públicas – um direito constitucional – sem que precise apresentar motivo para tal. A norma vale para os três Poderes da União, estados, municípios e Distrito Federal, inclusive Tribunais de Contas e Ministério Público. Engloba, ainda, entidades privadas que recebam recursos públicos.</p>
                    <p>A Alerj entende que transparência vai muito além da mera disponibilização de dados. Ela passa também pela efetiva participação, acompanhamento e fiscalização da sociedade para o exercício pleno da cidadania. E isso só é possível a partir do acesso das pessoas à informação.</p>
                    <p>Informação é poder. E, na Alerj, você tem poder!</p>
                </div>
            </div>

            @foreach($data as $item)
                <div class="col-md-6 col-lg-4 text-center">
                    <div class="box">
                        <div class="box-content">

                            <h3 class="tag-title">{{ $item['title'] }}</h3>

                            <div class="icones-tranparencia">
                                <img class="tag-icon" src="{{ $item['icon'] }}">
                            </div>

                            <ul class="itens-transparencia">
                                @foreach(collect($item['links'])->take($countLimit = config('app.items_limit_on_home')) as $link)
                                    <a href="{{ $link['link'] }}" {{-- target="{{ $link['is_external'] ? '_blank' : '_self' }}" --}}><li class="btn">{{ $link['title'] }}</li></a>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@stop


{{--http://transparencia.antoniocarlosribeiro.com/api/alerj/informacao/71/arquivos--}}
{{--http://transparencia.dev/api/alerj/informacao/71/arquivos--}}
{{--http://transparencia.dev/section/report/71--}}

