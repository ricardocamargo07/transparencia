$(document).ready(function () {
    var largura = window.innerWidth;
    $('.largura').text(largura);

    $(window).resize(function () {
        var largura = window.innerWidth;
        $('.largura').text(largura);
    });
});

$(document).ready(function () {
    $('.scrolltop').click(function () {
        $('html,body').animate({ scrollTop: $('.superior').offset().top }, 500);
    });
});
/* ------- SCROlL AGENDA ------ */

jQuery(function ($) {
    $.datepicker.regional['pt-BR'] = {
        closeText: 'Fechar',
        prevText: 'Anterior',
        nextText: 'Pr&oacute;ximo',
        currentText: 'Hoje',
        monthNames: ['Janeiro', 'Fevereiro', 'Mar&ccedil;o', 'Abril', 'Maio', 'Junho',
        'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        monthNamesShort: ['Janeiro', 'Fevereiro', 'Mar&ccedil;o', 'Abril', 'Maio', 'Junho',
        'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        dayNames: ['Domingo', 'Segunda-feira', 'Ter&ccedil;a-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sabado'],
        dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
        dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
        weekHeader: 'Sm',
        dateFormat: 'dd/mm/yy',
        firstDay: 0,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['pt-BR']);
});
jQuery(function ($) {
    $(".datapicker").datepicker({
        showOn: "both",
        buttonImage: rootUrl + "Content/imagens/icone_vazio.png",
        buttonImageOnly: true,
        buttonText: 'Selecione uma data',
        dateFormat: 'dd/mm/yy'
    });
});

$(function () {
    $('.controle_sroll').each(
		function () {
		    $(this).jScrollPane(
				{
				    autoReinitialise: true,
				    showArrows: true
				}
			);
		    var api = $(this).data('jsp');
		    var throttleTimeout;
		    $(window).bind(
				'resize',
				function () {
				    // IE fires multiple resize events while you are dragging the browser window which
				    // causes it to crash if you try to update the scrollpane on every one. So we need
				    // to throttle it to fire a maximum of once every 50 milliseconds...
				    if (!throttleTimeout) {
				        throttleTimeout = setTimeout(
							function () {
							    api.reinitialise();
							    throttleTimeout = null;
							},
							50
						);
				    }
				}
			);
		}
	)

});

/*$(document).ready(function() {
	$('.conteudo .item.noticias').addClass('ativo');
	$('.cartela .navegacao ul li a').click(function(){
		$('.conteudo .item').removeClass('ativo');
		
		var nomedaclass = $(this).attr('class');
		
		var caminho = $(this).parent().parent().parent().parent().find('.conteudo');
		$(caminho).find('.'+nomedaclass+'').addClass('ativo');
		
	});
});*/


$(document).ready(function () {
    $(".controle_video").animate({ opacity: 0 }, 0);

    $(".controle_video").css({ 'display': 'none' });
    $(".controle_video iframe").css({ 'display': 'none' });
    $('.navegacao a.imagens').addClass('ativo');

    $('.navegacao a.imagens').click(function () {
        $('.navegacao a.videos').removeClass('ativo');
        $(this).addClass('ativo');
        $(".controle_imagem").stop(true).animate({ opacity: 1 }, 500);
        $(".controle_video").stop(true).animate({ opacity: 0 }, 500);

        $(".controle_video iframe").css({ 'display': 'none' });
        $(".controle_video").css({ 'display': 'none' });

        $(".painel_interno .paginacao").css({ 'display': 'block' });
    });

    $('.navegacao a.videos').click(function () {
        $('.navegacao a.imagens').removeClass('ativo');
        $(this).addClass('ativo');
        $(".controle_imagem").stop(true).animate({ opacity: 0 }, 500);
        $(".controle_video").stop(true).animate({ opacity: 1 }, 500);

        $(".controle_video iframe").css({ 'display': 'block' });
        $(".controle_video").css({ 'display': 'block' });

        $(".painel_interno .paginacao").css({ 'display': 'none' });

    });
});

$(document).ready(function () {
    $(".posicao_menu_movel").css({ 'display': 'none' })
    $(".menu_select .icone.Recuar").css({ 'display': 'none' });

    $(".menu_select").click(function () {
        if ($(".posicao_menu_movel").is(":visible")) {
            $('.posicao_menu_movel').stop().slideToggle("show");
            $(".menu_select .icone.Recuar").css({ 'display': 'none' });
            $(".menu_select .icone.Expandir").css({ 'display': 'block' });

        } else {
            $('.posicao_menu_movel').stop().slideToggle("show");
            $(".menu_select .icone.Recuar").css({ 'display': 'block' });
            $(".menu_select .icone.Expandir").css({ 'display': 'none' });
        }
    });
});

/* ---------------------------------------------------------------------------------------------------- Sanfona --- */
$(document).ready(function () {
    $(".sanfona").css({ 'display': 'none' })
    $(".titulo_sanfona .icone.recuar").css({ 'display': 'none' })

    $(".icone.expandir").click(function () {

        //$(".icone.expandir").css({ 'display': 'block' })
        //$(".icone.recuar").css({ 'display': 'none' })
        //$(".sanfona").css({ 'display': 'none' })

        var parents = $(this).parent().parent();
        parents.find('.sanfona').stop().slideToggle("show");
        parents.find(".sanfona").css({ 'display': 'block' })

        parents.find(".icone.expandir").css({ 'display': 'none' })
        parents.find(".icone.recuar").css({ 'display': 'block' })

        parents.find(".sub-sanfona .titulo_sanfona .icone.recuar").css({ 'display': 'none' })
        parents.find(".sub-sanfona .titulo_sanfona .icone.expandir").css({ 'display': 'block' })
        parents.find(".sub-sanfona .sanfona").css({ 'display': 'none' })

    });

    $(".icone.recuar").click(function () {
        var parents = $(this).parent().parent();
        parents.find('.sanfona').stop().slideToggle("show");

        parents.find(".icone.expandir").css({ 'display': 'block' })
        parents.find(".icone.recuar").css({ 'display': 'none' })
    });

    $(".sub-sanfona .titulo_sanfona .icone.expandir").click(function () {
        var parents = $(this).parent().parent();
        parents.find(".sub-sanfona .sanfona").css({ 'display': 'block' })
        parents.find(".sub-sanfona .titulo_sanfona .icone.recuar").css({ 'display': 'block' })
        parents.find(".sub-sanfona .titulo_sanfona .icone.expandir").css({ 'display': 'none' })
    });

    $(".sub-sanfona .titulo_sanfona .icone.recuar").click(function () {
        var parents = $(this).parent().parent();
        parents.find(".sub-sanfona .sanfona").css({ 'display': 'none' })
        parents.find(".sub-sanfona .titulo_sanfona .icone.recuar").css({ 'display': 'none' })
        parents.find(".sub-sanfona .titulo_sanfona .icone.expandir").css({ 'display': 'block' })
    });
});


/* ---------------------------------------------------------------------------------------------------- CARTELA --- */

$(document).ready(function (Cartela) {

    $('#demo').removeAttr('autoplay')
    $('.jq_item').click(function () {

        if (this.id == 'radioalerj') {
            $('#demo').attr('autoplay')
            document.getElementById('demo').play();
        }
        else {
            $('#demo').removeAttr('autoplay')
           // document.getElementById('demo').pause();
        }
    });

    $(".central .cartela .conteudo .item").css({ display: "none" });

    $(".cartela .navegacao ul li a").hover(function () {
        $(this).stop(true, false).animate({ opacity: "1.0" });
    }, function () {
        $(this).stop(true, false).animate({ opacity: "0.7" });
    });
    //Marcando e abrindo itens iniciais
    $('.cartela .navegacao ul li').first().addClass('nav_ativa');
    $('.conteudo .item').first().addClass('ativo');

    var TextoSelecionado = $('.cartela .navegacao ul li.nav_ativa a').text();
    $('.menu_cartela .descricao').html(TextoSelecionado);


    $('.cartela .navegacao ul li').click(function () {
        //Apagando anteriores
        $('.cartela .navegacao ul li').removeClass('nav_ativa');

        $('.conteudo div.item').stop(true, true).animate({ opacity: 0 }, 500, function () {
            $('.conteudo .item').removeClass('ativo');
            $(caminho).find('.' + nomedaclass + '').addClass('ativo');
        });

        //Ativando navegação
        $(this).addClass('nav_ativa');
        //Pegando item clicado
        var nomedaclass = $(this).attr('id');
        var caminho = $(this).parent().parent().parent().parent().find('.conteudo');
        $(caminho).find('.' + nomedaclass + '').stop(true, true).animate({ opacity: 1.0 }, 500);


        //Animação da Seta
        var posicaoClique = $(this).position();
        var T_item = $(this).width();
        var T_F_item = T_item / 2;

        var Destino = posicaoClique.left + T_F_item - 20;
        $('.navegacao .seta').animate({ left: Destino }, 500);

        TextoSelecionado = $('.cartela .navegacao ul li.nav_ativa a').text();
        $('.menu_cartela .descricao').html(TextoSelecionado);
    });


    //CONTROLE DE NAVEGAÇÃO DA CARTELA
    $(".menu_cartela .icone.Recuar").css({ 'display': 'none' });

    $(".menu_cartela").click(function () {
        if ($(".navegacao").is(":visible")) {
            $('.navegacao').stop().slideToggle("show");
            $(".menu_cartela .icone.Recuar").css({ 'display': 'none' });
            $(".menu_cartela .icone.Expandir").css({ 'display': 'block' });

        } else {
            $('.navegacao').stop().slideToggle("show");
            $(".menu_cartela .icone.Recuar").css({ 'display': 'block' });
            $(".menu_cartela .icone.Expandir").css({ 'display': 'none' });
        }
    });

    //Controlando o Display None das Opções da Cartela
    $(window).resize(function () {
        var tela = $(window).width();
        if (tela >= 480) {
            $(".cartela .navegacao").addClass('display_block');
        } else if (tela < 480) {
            $(".cartela .navegacao").removeClass('display_block');
        }
    });

});
function ExibirDica() {
    $('.dica_descricao').toggle();
};


// Modal estava sendo apresentada ao abrir a página e não permitia ser fechada, erro acontecia somente no IE.
$(function () {

    var isIE = /*@cc_on!@*/false || !!document.documentMode;   // IE6 ou superior
    if (isIE) {
        $("#modal").hide();

        $("a[href=#modal]").click(function () {
            $("#modal").show();
        });
        $("a.close").click(function () {
            $("#modal").hide();
        });

        $(".botao input[type='submit']").css('height', '20.4px');
    }

});