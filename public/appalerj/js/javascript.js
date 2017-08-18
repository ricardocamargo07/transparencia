// JavaScript Document

var dataOrdemSelecionada;
var dataAgendaSelecionada;

$(document).ready(function(){
    "use strict";   

    $('.version').html('Versão: '+app.version);

});

$(document).bind("mobileinit", function() {
  $.support.touchOverflow = true;
  $.mobile.touchOverflowEnabled = true;
});

jQuery(function ($){
    "use strict";   
    if ($.datepicker.regional){

        $.datepicker.regional['pt-BR'] = {
        closeText: 'Fechar',
        prevText: 'Anterior',
        nextText: 'Pr&oacute;ximo',
        currentText: 'Hoje',
        monthNames: ['Janeiro', 'Fevereiro', 'Mar&ccedil;o', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        monthNamesShort: ['Janeiro', 'Fevereiro', 'Mar&ccedil;o', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
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
    }
    
    $.datepicker.setDefaults($.datepicker.regional['pt-BR']);
});


jQuery(function ($) {
    "use strict";
    
    $(".datepicker").datepicker({
        dateFormat: 'dd/mm/yy'
    });
});     



function convertImgToDataURLviaCanvas(url, callback, outputFormat){
    var img = new Image();
    img.crossOrigin = 'Anonymous';
    img.onload = function(){
        var canvas = document.createElement('CANVAS');
        var ctx = canvas.getContext('2d');
        var dataURL;
        canvas.height = this.height;
        canvas.width = this.width;
        ctx.drawImage(this, 0, 0);
        dataURL = canvas.toDataURL(outputFormat);
        callback(dataURL);
        canvas = null; 
    };
    img.src = url;
}


/** Funcao para formatacao de datas
*/
function formatDate(data){
    var today = data;
    var dd = today.getDate();
    var mm = today.getMonth()+1; 

    var yyyy = today.getFullYear();
    if(dd<10){
        dd='0'+dd
    } 
    if(mm<10){
        mm='0'+mm
    } 
    return dd+'/'+mm+'/'+yyyy;
}



function montaRegimeInternoPesquisa(regime){

    var templateTitulo = '<div class="titulo" >'+
                         '<div class="$$_AREA_$$">$$_TITULO_$$</div>'+
                         '<h1>$$_DESCRICAO_TITULO_$$</h1>'+
                         '</div>';

    var templateCapitulo = '<a $$_LINK_$$ data-transition="slide" class="capitulo ordem-item $$_SEM_LINK_$$" data-titulo="$$_TITULO_$$" data-alerj-id="$$_ID_$$">'+
                           '<span class="area">$$_CAPITULO_$$</span>'+
                           '<span class="descricao">$$_DESCRICAO_CAPITULO_$$</span>'+
                           '</a>';

    var templateSecao  = '<a $$_LINK_$$ data-transition="slide"  class="secao ordem-item $$_SEM_LINK_$$" data-titulo="$$_TITULO_$$" data-alerj-id="$$_ID_$$">'+
                         '<span class="area">$$_SECAO_$$</span>'+
                         '<span class="descricao">$$_TITULO_SECAO_$$</span>'+
                         '</a>';

    var templateSubSecao  = '<a $$_LINK_$$ data-transition="slide"  class="subsecao ordem-item $$_SEM_LINK_$$" data-titulo="$$_TITULO_$$" data-alerj-id="$$_ID_$$">'+
                         '<span class="area">$$_SECAO_$$</span>'+
                         '<span class="descricao">$$_TITULO_SECAO_$$</span>'+
                         '</a>';

    $('.container-fluid.conteudo').html('');
    var title = '';
    $.each(regime, function( index, value ) {

        if (value.title.indexOf(' -') > 0){
            var regimento = value.title.split(' -');
            

            if (value.level == 0){
                title = value.title;
                var titulo = templateTitulo.replace('$$_TITULO_$$', regimento[0]);
                titulo = titulo.replace('$$_DESCRICAO_TITULO_$$', regimento[1]);
                titulo = titulo.replace('$$_AREA_$$', 'area');
                $('.container-fluid.conteudo').append(titulo);

            }else if (value.level == 1){

                var capitulo = templateCapitulo.replace('$$_CAPITULO_$$', regimento[0]);
                capitulo = capitulo.replace('$$_DESCRICAO_CAPITULO_$$', regimento[1]);
                capitulo = capitulo.replace('$$_TITULO_$$', title);
                capitulo = capitulo.replace('$$_AREA_$$', 'area');

                if (value.has_content){
                    capitulo = capitulo.replace('$$_LINK_$$', '');
                    capitulo = capitulo.replace('$$_SEM_LINK_$$', '');
                    capitulo = capitulo.replace('$$_ID_$$', value.id);
                }else{
                    capitulo = capitulo.replace('$$_LINK_$$', 'href="javascipt:;"');
                    capitulo = capitulo.replace('$$_SEM_LINK_$$', 'sem-link');
                    capitulo = capitulo.replace('$$_ID_$$', '');
                }
                
                $('.container-fluid.conteudo').append(capitulo);    

            }else if (value.level == 2){

                var secao = templateSecao.replace('$$_SECAO_$$', regimento[0]);
                secao = secao.replace('$$_TITULO_SECAO_$$', regimento[1]);
                secao = secao.replace('$$_TITULO_$$', title);

                if (value.has_content){
                    secao = secao.replace('$$_LINK_$$', '');
                    secao = secao.replace('$$_SEM_LINK_$$', '');
                    secao = secao.replace('$$_ID_$$', value.id);
                }else{
                    secao = secao.replace('$$_LINK_$$', 'href="javascipt:;"');
                    secao = secao.replace('$$_SEM_LINK_$$', 'sem-link');
                    secao = secao.replace('$$_ID_$$', '');
                }
       
                $('.container-fluid.conteudo').append(secao);
            
            }else if (value.level > 2){

                var subsecao = templateSubSecao.replace('$$_SECAO_$$', regimento[0]);
                subsecao = subsecao.replace('$$_TITULO_SECAO_$$', regimento[1]);
                subsecao = subsecao.replace('$$_ID_$$', value.id);
                subsecao = subsecao.replace('$$_TITULO_$$', title);

                if (value.has_content){
                    subsecao = subsecao.replace('$$_LINK_$$', '');
                    subsecao = subsecao.replace('$$_SEM_LINK_$$', '');
                    subsecao = subsecao.replace('$$_ID_$$', value.id);
                }else{
                    subsecao = subsecao.replace('$$_LINK_$$', 'href="javascipt:;"');
                    subsecao = subsecao.replace('$$_SEM_LINK_$$', 'sem-link');
                    subsecao = subsecao.replace('$$_ID_$$', '');
                }
       
                $('.container-fluid.conteudo').append(subsecao);
            
            }

        }else{


            if (value.level == 0){
                title = value.title;
                var titulo = templateTitulo.replace('$$_TITULO_$$', '');
                titulo = titulo.replace('$$_DESCRICAO_TITULO_$$', value.title);
                titulo = titulo.replace('$$_AREA_$$', 'sem_area');
                
               $('.container-fluid.conteudo').append(titulo);              

            }else if (value.level == 1){

                var capitulo = templateCapitulo.replace('$$_CAPITULO_$$', '');
                capitulo = capitulo.replace('$$_DESCRICAO_CAPITULO_$$', value.title);
                capitulo = capitulo.replace('$$_TITULO_$$', title);
                capitulo = capitulo.replace('$$_AREA_$$', 'sem_capitulo');

                if (value.has_content){
                    capitulo = capitulo.replace('$$_LINK_$$', '');
                    capitulo = capitulo.replace('$$_SEM_LINK_$$', '');
                    capitulo = capitulo.replace('$$_ID_$$', value.id);
                }else{
                    capitulo = capitulo.replace('$$_LINK_$$', 'href="javascipt:;"');
                    capitulo = capitulo.replace('$$_SEM_LINK_$$', 'sem-link');
                    capitulo = capitulo.replace('$$_ID_$$', '');
                }
                
                $('.container-fluid.conteudo').append(capitulo);       

            }else if (value.level == 2){

                var secao = templateSecao.replace('$$_SECAO_$$', '');
                secao = secao.replace('$$_TITULO_SECAO_$$', value.title);
                secao = secao.replace('$$_TITULO_$$', title);

                if (value.has_content){
                    secao = secao.replace('$$_LINK_$$', '');
                    secao = secao.replace('$$_SEM_LINK_$$', '');
                    secao = secao.replace('$$_ID_$$', value.id);
                }else{
                    secao = secao.replace('$$_LINK_$$', 'href="javascipt:;"');
                    secao = secao.replace('$$_SEM_LINK_$$', 'sem-link');
                    secao = secao.replace('$$_ID_$$', '');
                }
                
                $('.container-fluid.conteudo').append(secao);

            }else if (value.level > 2){

                var subsecao = templateSubSecao.replace('$$_SECAO_$$', '');
                subsecao = subsecao.replace('$$_TITULO_SECAO_$$', value.title);
               
                subsecao = subsecao.replace('$$_TITULO_$$', title);

                if (value.has_content){
                    subsecao = subsecao.replace('$$_LINK_$$', '');
                    subsecao = subsecao.replace('$$_SEM_LINK_$$', '');
                    subsecao = subsecao.replace('$$_ID_$$', value.id);
                }else{
                    subsecao = subsecao.replace('$$_LINK_$$', 'href="javascipt:;"');
                    subsecao = subsecao.replace('$$_SEM_LINK_$$', 'sem-link');
                    subsecao = subsecao.replace('$$_ID_$$', '');
                }

                
                $('.container-fluid.conteudo').append(subsecao);

            }

        }

        if (regime.length == (index + 1)){
            setTimeout(function(){
               $.mobile.loading('hide');
            },500);
        }

    });

    $('.label_resultado').html(regime.length+' resultado(s) encontrado(s)');

    if (regime.length == 0){
        setTimeout(function(){
           $.mobile.loading('hide');
        },500);
    }


}




function montaRegimeInterno(){

    var templateTitulo = '<div class="titulo" >'+
                         '<div class="$$_AREA_$$">$$_TITULO_$$</div>'+
                         '<h1>$$_DESCRICAO_TITULO_$$</h1>'+
                         '</div>';

    var templateCapitulo = '<a $$_LINK_$$  class="capitulo ordem-item $$_SEM_LINK_$$" data-titulo="$$_TITULO_$$" data-alerj-id="$$_ID_$$">'+
                           '<span class="$$_AREA_$$">$$_CAPITULO_$$</span>'+
                           '<span class="descricao">$$_DESCRICAO_CAPITULO_$$</span>'+
                           '</a>';

    var templateSecao  = '<a $$_LINK_$$ class="secao ordem-item $$_SEM_LINK_$$" data-titulo="$$_TITULO_$$" data-alerj-id="$$_ID_$$">'+
                         '<span class="area">$$_SECAO_$$</span>'+
                         '<span class="descricao">$$_TITULO_SECAO_$$</span>'+
                         '</a>';

    var templateSubSecao  = '<a $$_LINK_$$ class="subsecao ordem-item $$_SEM_LINK_$$" data-titulo="$$_TITULO_$$" data-alerj-id="$$_ID_$$">'+
                         '<span class="area">$$_SECAO_$$</span>'+
                         '<span class="descricao">$$_TITULO_SECAO_$$</span>'+
                         '</a>';

    $('.container-fluid.conteudo').html('');
    var title = '';
    $.each(app.ajax.regimeInterno, function( index, value ) {


        if (value.title.indexOf(' -') > 0){
            var regimento = value.title.split(' -');
            
            if (value.level == 0){
                title = value.title;
                var titulo = templateTitulo.replace('$$_TITULO_$$', regimento[0]);
                titulo = titulo.replace('$$_DESCRICAO_TITULO_$$', regimento[1]);
                titulo = titulo.replace('$$_AREA_$$', 'area');
                $('.container-fluid.conteudo').append(titulo);

            }else if (value.level == 1){

                var capitulo = templateCapitulo.replace('$$_CAPITULO_$$', regimento[0]);
                capitulo = capitulo.replace('$$_DESCRICAO_CAPITULO_$$', regimento[1]);
                capitulo = capitulo.replace('$$_TITULO_$$', title);
                capitulo = capitulo.replace('$$_AREA_$$', 'area');

                if (value.has_content){
                    capitulo = capitulo.replace('$$_LINK_$$', '');
                    capitulo = capitulo.replace('$$_SEM_LINK_$$', '');
                    capitulo = capitulo.replace('$$_ID_$$', value.id);
                }else{
                    capitulo = capitulo.replace('$$_LINK_$$', 'href="javascipt:;"');
                    capitulo = capitulo.replace('$$_SEM_LINK_$$', 'sem-link');
                    capitulo = capitulo.replace('$$_ID_$$', '');
                }
                
                $('.container-fluid.conteudo').append(capitulo);    

            }else if (value.level == 2){

                var secao = templateSecao.replace('$$_SECAO_$$', regimento[0]);
                secao = secao.replace('$$_TITULO_SECAO_$$', regimento[1]);
                secao = secao.replace('$$_TITULO_$$', title);

                if (value.has_content){
                    secao = secao.replace('$$_LINK_$$', '');
                    secao = secao.replace('$$_SEM_LINK_$$', '');
                    secao = secao.replace('$$_ID_$$', value.id);
                }else{
                    secao = secao.replace('$$_LINK_$$', 'href="javascipt:;"');
                    secao = secao.replace('$$_SEM_LINK_$$', 'sem-link');
                    secao = secao.replace('$$_ID_$$', '');
                }
       
                $('.container-fluid.conteudo').append(secao);
            
            }else if (value.level > 2){

                var subsecao = templateSubSecao.replace('$$_SECAO_$$', regimento[0]);
                subsecao = subsecao.replace('$$_TITULO_SECAO_$$', regimento[1]);
                subsecao = subsecao.replace('$$_TITULO_$$', title);

                if (value.has_content){
                    subsecao = subsecao.replace('$$_LINK_$$', '');
                    subsecao = subsecao.replace('$$_SEM_LINK_$$', '');
                    subsecao = subsecao.replace('$$_ID_$$', value.id);
                }else{
                    subsecao = subsecao.replace('$$_LINK_$$', 'href="javascipt:;"');
                    subsecao = subsecao.replace('$$_SEM_LINK_$$', 'sem-link');
                    subsecao = subsecao.replace('$$_ID_$$', '');
                }
       
                $('.container-fluid.conteudo').append(subsecao);
            
            }

        }else{

            if (value.level == 0){
                title = value.title;
                var titulo = templateTitulo.replace('$$_TITULO_$$', '');
                titulo = titulo.replace('$$_DESCRICAO_TITULO_$$', value.title);
                titulo = titulo.replace('$$_AREA_$$', 'sem_area');
                
                $('.container-fluid.conteudo').append(titulo);              

            }else if (value.level == 1){

                var capitulo = templateCapitulo.replace('$$_CAPITULO_$$', '');
                capitulo = capitulo.replace('$$_DESCRICAO_CAPITULO_$$', value.title);
                capitulo = capitulo.replace('$$_TITULO_$$', title);
                capitulo = capitulo.replace('$$_AREA_$$', 'sem_capitulo');

                if (value.has_content){
                    capitulo = capitulo.replace('$$_LINK_$$', '');
                    capitulo = capitulo.replace('$$_SEM_LINK_$$', '');
                    capitulo = capitulo.replace('$$_ID_$$', value.id);
                }else{
                    capitulo = capitulo.replace('$$_LINK_$$', 'href="javascipt:;"');
                    capitulo = capitulo.replace('$$_SEM_LINK_$$', 'sem-link');
                    capitulo = capitulo.replace('$$_ID_$$', '');
                }
                
                $('.container-fluid.conteudo').append(capitulo);       

            }else if (value.level == 2){

                var secao = templateSecao.replace('$$_SECAO_$$', '');
                secao = secao.replace('$$_TITULO_SECAO_$$', value.title);
                secao = secao.replace('$$_TITULO_$$', title);

                if (value.has_content){
                    secao = secao.replace('$$_LINK_$$', '');
                    secao = secao.replace('$$_SEM_LINK_$$', '');
                    secao = secao.replace('$$_ID_$$', value.id);
                }else{
                    secao = secao.replace('$$_LINK_$$', 'href="javascipt:;"');
                    secao = secao.replace('$$_SEM_LINK_$$', 'sem-link');
                    secao = secao.replace('$$_ID_$$', '');
                }

                
                $('.container-fluid.conteudo').append(secao);

            }else if (value.level > 2){

                var subsecao = templateSubSecao.replace('$$_SECAO_$$', '');
                subsecao = subsecao.replace('$$_TITULO_SECAO_$$', value.title);
                subsecao = subsecao.replace('$$_TITULO_$$', title);

                if (value.has_content){
                    subsecao = subsecao.replace('$$_LINK_$$', '');
                    subsecao = subsecao.replace('$$_SEM_LINK_$$', '');
                    subsecao = subsecao.replace('$$_ID_$$', value.id);
                }else{
                    subsecao = subsecao.replace('$$_LINK_$$', 'href="javascipt:;"');
                    subsecao = subsecao.replace('$$_SEM_LINK_$$', 'sem-link');
                    subsecao = subsecao.replace('$$_ID_$$', '');
                }

                
                $('.container-fluid.conteudo').append(subsecao);

            }

        }

        if (app.ajax.regimeInterno.length == (index + 1)){
            setTimeout(function(){
               $.mobile.loading('hide');
            },500);
        }

    });


}

function ajustaTamanhoNoticia(){
    var $elemPrimeiro = $('.limit');         

    $.each($elemPrimeiro, function( index, elemVal ) {
        
        var $elem = $(elemVal);       
        var $limit = 235;       
        
        var $str = $elem.html();
        var $strtemp = $str.substr(0,$limit);
        $str = $strtemp + '<span class="reticencias">...</span>' + '<span class="texto">' + $str.substr($limit,$str.length) + '</span>';    // Recompose the string with the span tag wrapped around the hidden part of it
        $elem.html($str);
       
    });   

    $('.animar-conteudo p.limit span.texto').toggle(false);
    $('.botao-expandir').click(function(){

        $(this).find('img').toggleClass('recuar');
        $(this).find('img.expandir').attr({src:"imagens/icone_03.jpg"});
        $(this).find('img.expandir.recuar').attr({src:"imagens/icone_04.jpg"});
                
        $(this).parent().find('.animar-conteudo p.limit span.reticencias').toggle().text();
        $(this).parent().find('.animar-conteudo p.limit span.texto').toggleClass('abrir');
        
        $(this).parent().find('.animar-conteudo p.limit span.texto').toggle('hide', function(){
            $('.animar-conteudo p.limit span.texto.abrir').css('display','inline');
        });     
        
        $(this).parent().find('.animar-conteudo p.limit span.texto').toggle(true);
    });
}

function ajustaTamanhoNoticiaItem(index){
    var $elemPrimeiro = $('#item'+index);         

    $.each($elemPrimeiro, function( index, elemVal ) {
        
        var $elem = $(elemVal);       
        var $limit = 235;       
        
        var $str = $elem.html();
        var $strtemp = $str.substr(0,$limit);
        $str = $strtemp + '<span class="reticencias">...</span>' + '<span class="texto">' + $str.substr($limit,$str.length) + '</span>';    // Recompose the string with the span tag wrapped around the hidden part of it
        $elem.html($str);
       
    });   

    $elemPrimeiro.parent().find('span.texto').toggle(false);
    $($elemPrimeiro).parent().parent().find('.botao-expandir').click(function(){

        $(this).find('img').toggleClass('recuar');
        $(this).find('img.expandir').attr({src:"imagens/icone_03.jpg"});
        $(this).find('img.expandir.recuar').attr({src:"imagens/icone_04.jpg"});
                
        $(this).parent().find('.animar-conteudo p.limit span.reticencias').toggle().text();
        $(this).parent().find('.animar-conteudo p.limit span.texto').toggleClass('abrir');
        
        $(this).parent().find('.animar-conteudo p.limit span.texto').toggle('hide', function(){
            $('.animar-conteudo p.limit span.texto.abrir').css('display','inline');
        });     
        
        $(this).parent().find('.animar-conteudo p.limit span.texto').toggle(true);
    });
}


/** Monta lista noticias
*/
function montaListaNoticias (){

    $('.conteudo-noticia').html('');

    $.each(app.ajax.listaNoticias, function( index, noticia ) {

        if (index <= 2){
            var templateNoticia = '<div class="noticia">'+
                          '<h2 class="titulo_noticia">$$TITULO_NOTICIA$$</h2>' +
                          '<span class="data">$$_DATA_$$</span>'+
                          '<div class="share" data-alerj-noticia-id="$$_ID_$$" data-alerj-noticia-titulo="$$_TITULO_NOTICIA_$$"  style="float:right; margin-right:10%; padding-bottom: 4%;cursor: pointer; "><img src="imagens/botao-compartilhar.png" class="img_share" alt="Compartilhar"/></div>'+
                          '<div id="$$_ID_$$"><img id="loading-$$_ID_$$" src="css/images/preloader.gif" width="520" height="295" alt="$$_DESC_IMG_$$" class="imagem img-responsive"/></div>'+
                          '<span class="por">$$_POR_$$</span>'+
                          '<div class="padding-0 col-lg-12 animar-conteudo">'+
                          '<p class="limit" id="item'+index+'">$$_CONTEUDO_$$</p>'+
                          '</div>'+
                          '<div class="controle-botao botao-expandir"><img src="imagens/icone_03.jpg" width="22" height="22" alt="Expandir" class="expandir"/></div>'+
                          '</div>';

            templateNoticia = templateNoticia.replace('$$TITULO_NOTICIA$$', noticia.Titulo);
            templateNoticia = templateNoticia.replace('$$_TITULO_NOTICIA_$$', noticia.Titulo);
            templateNoticia = templateNoticia.replace('$$_DATA_$$', noticia.DataPublicacao);
            templateNoticia = templateNoticia.replace('$$_ID_$$', noticia.ID);
            templateNoticia = templateNoticia.replace('$$_ID_$$', noticia.ID);
            templateNoticia = templateNoticia.replace('$$_ID_$$', noticia.ID);

            if (noticia.Multimidias && noticia.Multimidias[0] && noticia.Multimidias[0].Arquivo != null && noticia.Multimidias[0].Credito != null){

                templateNoticia = templateNoticia.replace('$$_DESC_IMG_$$', noticia.Multimidias[0].Credito);
                templateNoticia = templateNoticia.replace('$$_POR_$$', noticia.Multimidias[0].Credito);

            }else{

                templateNoticia = templateNoticia.replace('$$_DESC_IMG_$$', '');
                templateNoticia = templateNoticia.replace('$$_POR_$$', '');
            }

            var conteudoNoticia = replaceAll(noticia.Conteudo, '<p>', '<br/>');
            conteudoNoticia = replaceAll(conteudoNoticia, '</p>', '');
            conteudoNoticia = replaceAll(conteudoNoticia, '&nbsp;', ' ');

            templateNoticia = templateNoticia.replace('$$_CONTEUDO_$$', conteudoNoticia);

            $('.conteudo-noticia').append(templateNoticia);

            var temMultimedia= false;


            $.each(noticia.Multimidias, function( index, multimidia ) {

                var img = $("<img class='imagem img-responsive' />").attr('src', 'http://'+multimidia.Arquivo.trim())
                .on('load', function() {
                    if (!this.complete || typeof this.naturalWidth == "undefined" || this.naturalWidth == 0) {
                        
                    } else {
                        $("#loading-"+noticia.ID).remove();
                        $("#"+noticia.ID).append(img);
                    }
                }).on('error', function() {
                    $("#loading-"+noticia.ID).remove();
                    $("#"+noticia.ID).html('');
                    $("#"+noticia.ID).append('<img class="img-responsive" src="imagens/img_indisponivel.jpg" >');
                });

                temMultimedia = true;
                return false;

            });

            if (!temMultimedia){
                $("#loading-"+noticia.ID).remove();
            }

            setTimeout(ajustaTamanhoNoticiaItem(index), 100);
            

            if (3 == (index +1 )){

                $('.conteudo-noticia').append('<div class="carregando_noticias">'+
                          '<img src="css/images/ajax-loader.gif" alt="Loading">'+
                          '</div>'); 

                setTimeout(function(){
                   $.mobile.loading('hide');
                },500);
                
            }                               
        } 

        app.ajax.numLoadNoticias = 3;

    });   

    if (app.ajax.listaNoticias.length < 3){
        setTimeout(function(){
           $.mobile.loading('hide');
        },500);
    }

    $('.label_resultado').html(app.ajax.listaNoticias.length+' resultado(s) encontrado(s)');
                    

}



function adicionaItemNoticia(noticia, numLoadNoticias) {

    //var noticia = app.ajax.listaNoticias[app.ajax.numLoadNoticias];

    if (noticia){

        var templateNoticia = '<div class="noticia">'+
                          '<h2 class="titulo_noticia">$$TITULO_NOTICIA$$</h2>' +
                          '<span class="data">$$_DATA_$$</span>'+
                          '<div class="share" data-alerj-noticia-id="$$_ID_$$" data-alerj-noticia-titulo="$$_TITULO_NOTICIA_$$"  style="float:right; margin-right: 10%;padding-bottom: 3%;cursor: pointer;"><img src="imagens/botao-compartilhar.png"  class="img_share" alt="Compartilhar"/></div>'+
                          '<div id="$$_ID_$$"><img id="loading-$$_ID_$$" src="css/images/preloader.gif" width="520" height="295" alt="$$_DESC_IMG_$$" class="imagem img-responsive"/></div>'+
                          '<span class="por">$$_POR_$$</span>'+
                          '<div class="padding-0 col-lg-12 animar-conteudo">'+
                          '<p class="limit" id="item'+numLoadNoticias+'">$$_CONTEUDO_$$</p>'+
                          '</div>'+
                          '<div class="controle-botao botao-expandir"><img src="imagens/icone_03.jpg" width="22" height="22" alt="Expandir" class="expandir"/></div>'+
                          '</div>'+

                          '<div class="carregando_noticias">'+
                          '<img src="css/images/ajax-loader.gif" alt="Loading">'+
                          '</div>';

        templateNoticia = templateNoticia.replace('$$TITULO_NOTICIA$$', noticia.Titulo);
        templateNoticia = templateNoticia.replace('$$_TITULO_NOTICIA_$$', noticia.Titulo);
        templateNoticia = templateNoticia.replace('$$_DATA_$$', noticia.DataPublicacao);
        templateNoticia = templateNoticia.replace('$$_ID_$$', noticia.ID);
        templateNoticia = templateNoticia.replace('$$_ID_$$', noticia.ID);
        templateNoticia = templateNoticia.replace('$$_ID_$$', noticia.ID);

        var temMultimedia= false;

        $.each(noticia.Multimidias, function( index, multimidia ) {

            if (multimidia.Arquivo != null && multimidia.Credito != null){

                templateNoticia = templateNoticia.replace('$$_DESC_IMG_$$', multimidia.Credito);
                templateNoticia = templateNoticia.replace('$$_POR_$$', multimidia.Credito);

               

                var img = $("<img class='imagem img-responsive' />").attr('src', 'http://'+multimidia.Arquivo.trim())
                    .on('load', function() {
                        if (!this.complete || typeof this.naturalWidth == "undefined" || this.naturalWidth == 0) {
                            
                        } else {
                            $("#loading-"+noticia.ID).remove();
                            $("#"+noticia.ID).append(img);
                        }
                    }).on('error', function() {
                        $("#loading-"+noticia.ID).remove();
                        $("#"+noticia.ID).html('');
                        $("#"+noticia.ID).append('<img class="img-responsive" src="imagens/img_indisponivel.jpg" >');
                    });

                temMultimedia = true;
                return false;

            }
            
        });

        if (!temMultimedia){

             setTimeout(function(){
               $("#loading-"+noticia.ID).remove();
               $("#"+noticia.ID).remove();
            },500);

            templateNoticia = templateNoticia.replace('$$_IMAGEM_$$', '');
            templateNoticia = templateNoticia.replace('$$_DESC_IMG_$$', '');
            templateNoticia = templateNoticia.replace('$$_POR_$$', '');

        }

        

        var conteudoNoticia = replaceAll(noticia.Conteudo, '<p>', '<br/>');
        conteudoNoticia = replaceAll(conteudoNoticia, '</p>', '');
        conteudoNoticia = replaceAll(conteudoNoticia, '&nbsp;', ' ');

        templateNoticia = templateNoticia.replace('$$_CONTEUDO_$$', conteudoNoticia);

        $('.conteudo-noticia').find('.carregando_noticias').remove();

        $('.conteudo-noticia').append(templateNoticia);
        
        setTimeout(ajustaTamanhoNoticiaItem(numLoadNoticias), 100);

       // app.ajax.numLoadNoticias =  app.ajax.numLoadNoticias + 1;

    }else{

        var divload = $('.conteudo-noticia').find('.carregando_noticias');
        $(divload).html('<center><b>N&atilde;o existem mais noticias.</b></center>')

    }

    setTimeout(function(){
       $.mobile.loading('hide');
    },500);
             

}


function escapeRegExp(str) {
    return str.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
}

function replaceAll(str, find, replace) {
  return str.replace(new RegExp(escapeRegExp(find), 'g'), replace);
}




/** Monta deputado interna
*/
function montaDeputadoInterna(deputado){


        $('.email').html('');
        $('.email_rodape').html('');
        if (deputado.Email && deputado.Email[0]){
            $('.email').append(deputado.Email[0]);
            $('.email').attr('href', 'mailto:'+deputado.Email[0]);
            $('.email_rodape').append(deputado.Email[0]);
            $('.email_rodape').attr('href', 'mailto:'+deputado.Email[0]);
        }

        $('.controle-imagem img').attr('alt', deputado.Nome);


        var img = $("<img class='img-responsive' />").attr('src', 'http://'+deputado.Foto.trim())
                .on('load', function() {
                    if (!this.complete || typeof this.naturalWidth == "undefined" || this.naturalWidth == 0) {
                        
                    } else {
                        $("#deputado-interna-imagem").remove();
                        $("#controle-deputado-interna-imagem").append(img);
                    }
                }).on('error', function() {
                    $("#deputado-interna-imagem").remove();
                    $("#controle-deputado-interna-imagem").append('<img class="img-responsive" src="imagens/img_indisponivel.jpg" >');
                });

        if (deputado.LiderBanca){
            $('.controle-imagem img').addClass( 'lider' );
        }
        

        $('.nome_politico').html('');
        $('.nome_politico').append(deputado.NomePolitico);

        $('.cabecalho_deputado .nome .texto').html('');
        $('.cabecalho_deputado .nome .texto').append(deputado.Nome);

        $('.cabecalho_deputado .data .texto').html('');
        $('.cabecalho_deputado .data .texto').append(deputado.DataNascimento);

        $('.cabecalho_deputado .local .texto').html('');
        $('.cabecalho_deputado .local .texto').append(deputado.LocalNascimento);

        $('.descricao_biografia').find('p').html('');
        
        var bio = deputado.Biografia;
        

        var patt = /<a href="(.*?)"/g;
        var site = '';
        while(match=patt.exec(bio)){
        	if (match[1]){
        		 site = match[1];
                 break;
        	}
        }
        
        bio = bio.replace(site, "");
        bio = bio.replace("href=\"", "href=\"#\" onclick=\"openURL('"+site.trim()+"');");
        
        $('.descricao_biografia').find('p').append(bio+'<br><br><br>');

        $('.partido_interna').html('');
        $('.partido_interna').html('<span>'+deputado.Partido+'</span> '+deputado.DescricaoPartido);

        if (deputado.Email && deputado.TelefoneInstitucional[0]){
            $('.telefone').html('');
            $('.telefone').html('<a href="tel:+55-'+deputado.TelefoneInstitucional[0].replace('(','').replace(')','').replace(' ','-')+'">'+deputado.TelefoneInstitucional[0]+'</a>');
        }

        if (deputado && deputado.ComissoesServiceModel){
            $('.participacoes').html('');
            $.each(deputado.ComissoesServiceModel, function( index, value ) {

                if (value.Cargo &&  value.NomeComissao){
                    $('.participacoes').append('<div class="nome">' + value.Cargo + '</div>');
                    $('.participacoes').append('<div class="funcao">' + value.NomeComissao + '</div>');
                }
                
            });

        }

        $('.endereco_rodape').html('');
        var endereco_rodape = 'Endereço para contato: ' + deputado.Endereco+'</br>';
        endereco_rodape = endereco_rodape +'CEP: ' + deputado.NrCEP +'</br>';
      //  endereco_rodape = endereco_rodape +'Gabinete Número: </br>';
     //   endereco_rodape = endereco_rodape +'Andar: </br>';

        if (deputado.TelefoneInstitucional[0] ){
            endereco_rodape = endereco_rodape +'Telefone: <a href="tel:+55-'+deputado.TelefoneInstitucional[0].replace('(','').replace(')','').replace(' ','-')+'">'+deputado.TelefoneInstitucional[0]+'</a></br>';
        }
        
        endereco_rodape = endereco_rodape +'Fax: ' +' </br>';

       $('.endereco_rodape').append(endereco_rodape);


}


/** Funcao para limpar campos do faleconosco
*/
function limpaFaleConosco(){

    $('#nome').val('');
    $('#email').val('');
    $('#ddd').val('');
    $('#telefone').val('');
    $('#mensagem').val('');

}


/** Funcao que valida um data entre um intervalo de datas
*/

function validaEntreDatas(dataInicio, dataFim, dataCheck){

    var d1 = dataInicio.split("/");
    var d2 = dataFim.split("/");
    var c = dataCheck.split("/");

    var from = new Date(d1[2], d1[1]-1, d1[0]);  
    var to   = new Date(d2[2], d2[1]-1, d2[0]);
    var check = new Date(c[2], c[1]-1, c[0]);

    var ret = false;

    if((check.getTime() > from.getTime() && check.getTime() < to.getTime()) || 
        (check.getTime() == from.getTime() || check.getTime() == to.getTime())){
       ret = true;
    }

    return ret;
}


/** 
*/
function convertStringtoDate(str){
    var d = str.split("/");
    return new Date(d[2], d[1]-1, d[0]);  
}

/** Metodo que ajusta o calendario com circulo em dias com enventos da ordem do dia
*/
function ajustaCalendarioOrdem(){

    setTimeout(function(){
       $.mobile.loading('show');
       $('.ui-datepicker-next').hide();
       $('.ui-datepicker-prev').hide();
    },10);

    if (app.ajax.mesAnoOrdem == ''){
        var data  =  new Date();
        app.ajax.mesAnoOrdem = (data.getMonth()+1) +'/'+ data.getFullYear();
    }

    var ordemMesAno = [];

    
    

    $.each(app.ajax.listaOrdens, function( index, ordem ) {

        if (ordem.carbon && ordem.carbon.date){
            var dataOrdem = new Date(ordem.carbon.date.replace(' ', 'T'));
            var mesAnoOrdem = (dataOrdem.getMonth()+1) +'/'+ dataOrdem.getFullYear();

            if (mesAnoOrdem == app.ajax.mesAnoOrdem){
                ordemMesAno.push(ordem);
            } 
        }

    });

    if (ordemMesAno.length == 0){

        setTimeout(function(){
           $.mobile.loading('hide');
           $('.ui-datepicker-next').show();
           $('.ui-datepicker-prev').show();
        },500); 

        return;

    }

    $.each(ordemMesAno, function( index, ordemMesAnoItem ) {

        $('.ui-datepicker-calendar td a').each(function (i, obj){
            var dataOrdem = new Date(ordemMesAnoItem.carbon.date.replace(' ', 'T'));
            if ($(obj).html() == dataOrdem.getDate()){
                if (dataOrdem > new Date()){
                    $(obj).addClass('evento');
                    $(obj).addClass('futuro');
                }else {
                    $(obj).addClass('evento');
                }
                
            }

        });

        if (ordemMesAno.length == (index + 1)){
            setTimeout(function(){
               $.mobile.loading('hide');
               $('.ui-datepicker-next').show();
               $('.ui-datepicker-prev').show();
            },500); 
        }

    });

    

}

/** Metodo que ajusta o calendario com circulo em dias com enventos da agenda
*/
function ajustaCalendarioAgenda(){

    if (app.ajax.mesAnoAgenda == ''){
        var data  =  new Date();
        app.ajax.mesAnoAgenda = (data.getMonth()+1) +'/'+ data.getFullYear();
    }


    if (app.ajax.listaAgendas.length == 0){
        setTimeout(function(){
           $.mobile.loading('hide');
           $('.ui-datepicker-next').show();
           $('.ui-datepicker-prev').show();
        },500); 

        return;
    }


    $('.ui-datepicker-calendar td a').each(function (i, obj){

        $.each(app.ajax.listaAgendas, function( index, agenda ) {

            if (agenda.DataInicio || agenda.DataFim) {
                var dia = $(obj).html();
                if (validaEntreDatas(agenda.DataInicio, agenda.DataFim, (dia + '/' +app.ajax.mesAnoAgenda ))) {

                    var data = convertStringtoDate((dia + '/' +app.ajax.mesAnoAgenda ));
                    if (data > new Date()){
                        $(obj).addClass('evento'); 
                        $(obj).addClass('futuro');   
                    }else{
                        $(obj).addClass('evento');  
                    }
                    
                }
            }

            if (app.ajax.listaAgendas.length == (index + 1)){
                setTimeout(function(){
                   $.mobile.loading('hide');
                   $('.ui-datepicker-next').show();
                   $('.ui-datepicker-prev').show();
                },500); 
            }

        });

    });   


}


function selecionaDiaOrdem(dataOrdemSelecionada){
    
    $('.eventos').html('');

    $.each(app.ajax.listaOrdens, function( index, value ) {
         
        if (value.carbon && value.carbon.date){

            if (dataOrdemSelecionada == formatDate(new Date(value.carbon.date.replace(' ', 'T')))){
                //adiciona campo na tela
                
                templateOrdem = '<li><a class="ordem-item" data-alerj-id="$$_ALERJ_ID_$$">'+
                '<span class="ponto"></span><span class="texto">'+
                '<strong>$$_HORA_$$</strong> - $$_ORDEM_$$</span></a></li>';

                var campos = value.title.split('(');
                    
                templateOrdem = templateOrdem.replace('$$_ALERJ_ID_$$', value.alerj_id);
                templateOrdem = templateOrdem.replace('$$_ORDEM_$$', campos[0]);
                templateOrdem = templateOrdem.replace('$$_HORA_$$', campos[1].replace(')',''));

                $('.eventos').append(templateOrdem);
            }
        }
    });

    setTimeout(ajustaCalendarioOrdem, 100);


}



                






















