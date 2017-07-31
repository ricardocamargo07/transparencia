var partidos;
$(document).ready(function () {
    partidos = [];
    $('#btnPesquisa').click(function () {
        $('form#formPerfilDeputadoConsultar').submit();
    })

    //---------- Adicionando AUTOCOMPLETE ----------------------//
    $('.js-autocompletepartido').keyup(function () {
        var campo = $(this)[0].id;

        $('#' + campo).autocomplete({
            source: rootUrl + 'Visualizar/ConsultarPartidoPolitico?nome=' + $('#' + campo).val(),
            minLength: 1,
            focus: function (event, ui) {
                $('#' + campo).val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $(campo).val(ui.item.label);
                return false;
            }
        });
    });

    $('.js-autocompletepolitico').keyup(function () {
        var campo = $(this)[0].id;

        $('#' + campo).autocomplete({
            source: rootUrl + 'Visualizar/ConsultarDeputado?nome=' + $('#' + campo).val(),
            minLength: 1,
            focus: function (event, ui) {
                $('#' + campo).val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $(campo).val(ui.item.label);
                return false;
            }
        });
    });
    //---------- FIM AUTOCOMPLETE ----------------------//
});

function carregaAbaAgenda() {
    if (!carregouAbaAgenda) {
        RequisicaoAjaxVotacao(rootUrl + "Home/CarregaAbaEvento", null, function (response) {
            $('#divAgendaAba').append(response);
            carregouAbaAgenda = true;
        });
    }
}

$('a[class*=js-aba]').click(function (e) {
    e.preventDefault();

    $elemento = $(this);
    $elemento.addClass('ativo');

    $divVisivel = $('#divAba' + $elemento.attr('class').replace('js-aba', '').replace('ativo', '').replace(' ', ''));

    $('a[class*=js-aba]').not($elemento).removeClass('ativo');
    $('div[id*=divAba]').not($elemento).addClass('invisivel');

    $divVisivel.removeClass('invisivel');
});

$('div[class*=js-iconeAtuacao]').click(function (e) {
    e.preventDefault();

    $elemento = $(this);
    isExpandir = ($elemento.children().attr('class').indexOf('icone_35') > -1);

    $divAcao = $('#div' + $elemento.attr('class').split(' ')[0].replace('js-icone', ''));

    if (isExpandir) {
        carregaDeputados($elemento[0].id);
        $elemento.children().removeClass('icone_35');
        $elemento.children().addClass('icone_34');
        $elemento.children().attr('title', 'Recuar');
        $divAcao.slideDown("slow");

    }
    else {
        $elemento.children().removeClass('icone_34');
        $elemento.children().addClass('icone_35');
        $elemento.children().attr('title', 'Expandir');
        $divAcao.slideUp("slow");
    }

});

function carregaDeputados(id) {    
    if (partidos['partido' + id] == null) {
        var nomeDeputado = $('#nomedeputado').val();
        RequisicaoAjax(rootUrl + "Visualizar/ConsultaDeputadosDoPartido", { codigoPartido: id, nomeDeputado: nomeDeputado }, function (response) {
            $('#divPartido' + id).append(response);
            partidos['partido' + id] = true;
        });
    }
}


