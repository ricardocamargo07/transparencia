/**
 * Arquivo geral de fun��es de ajax callback relativas as acoes do namespace
 * 
 */


/**
 * Variaveis
 */

app.ajax={ 

	listaOrdens:[],
	ordemSelecinada:'',
	regimeInterno:[],
	regimeSelecionado:'',
	regimeTitulo: '',
	listaDeputados:[],
	deputadoSelecionado:'',
	listaNoticias:[],
	listaAgendas:[],
	agendaSelecinada:'',
	mesAnoOrdem:'',
	mesAnoAgenda:'',
	numLoadNoticias: 0,
	scrollTopRegimento:0,
	scrollTopDeputado:0

}
/**
 * Fun��o de Ajax Callback deputado successo
 */
app.ajax.deputadoSuccess=function( result, textStatus, jqXHR ){
	app.ajax.listaDeputados = result;
	console.log('app.ajax.deputadoSuccess', result);
	montaListaDeputados();
	
};

/**
 * Fun��o de Ajax Callback deputado successo
 */
app.ajax.deputadoPesquisaSuccess=function( result, textStatus, jqXHR ){
	app.ajax.listaDeputados = result;
	montaListaDeputadosPesquisa();
	
};

/**
 * Fun��o de Ajax Callback faleconosco successo
 */
app.ajax.faleconoscoSuccess=function( result, textStatus, jqXHR ){
	limpaFaleConosco();
	setTimeout(function(){
       $.mobile.loading('hide');
    },500);   
	alert('Mensagem enviada com sucesso!');
	
};

/**
 * Fun��o de Ajax Callback noticia successo
 */
app.ajax.noticiaSuccess=function( result, textStatus, jqXHR ){
	app.ajax.listaNoticias.push(result[0]);
	montaListaNoticias();
	
};

/**
 * Fun��o de Ajax Callback deputado interna successo
 */
app.ajax.deputadoInternaSuccess=function( result, textStatus, jqXHR ){
	montaDeputadoInterna(result);
	
};

/**
 * Fun��o de Ajax Callback ordemDia successo
 */
app.ajax.ordemDiaSuccess=function( result, textStatus, jqXHR ){
	app.ajax.listaOrdens = result;
	ajustaCalendarioOrdem();
	
};

/**
 * Fun��o de Ajax Callback agenda successo
 */
app.ajax.agendaSuccess=function( result, textStatus, jqXHR ){
	app.ajax.listaAgendas = result;
	ajustaCalendarioAgenda();
	
};

/**
 * Fun��o de Ajax Callback agenda interna successo
 */
app.ajax.agendaInternaSuccess=function( result, textStatus, jqXHR ){

	$('.controle-conteudo').find('h1').append(result.Titulo);

	$('.controle-conteudo').find('.data').append(result.DataInicio +' - '+ result.DataFim);

	$('.container-fluid.conteudo').html('');
	$('.container-fluid.conteudo').append('<div align="center"><p>'+result.Descricao+'</p></div>');

	setTimeout(function(){
       $.mobile.loading('hide');
    },500);
 
};

/**
 * Fun��o de Ajax Callback agenda interna successo
 */
app.ajax.agendaPesquisaSuccess=function( result, textStatus, jqXHR ){

	

	$('.label_resultado').html('');
	$('.controle-resultado').html('');
	$('.label_resultado').html(result.length+' resultado(s) encontrado(s)');


	var templateResultado = ' <div class="resultado"><h2><a href="agenda_interna.html" class="agenda-resultado" data-transition="slide" data-alerj-id="$$_ALERJ_ID_$$" >$$_TITULO_$$</a></h2>'+
							'<p>$$_DESCRICAO_$$</p></div>';

	$.each( result, function( i, obj ) { 
		if (i <=30){
			
			var item = templateResultado.replace('$$_TITULO_$$', obj.Titulo);
			item = item.replace('$$_DESCRICAO_$$', obj.Descricao);
			item = item.replace('$$_ALERJ_ID_$$', obj.ID);

			$('.controle-resultado').append(item);

			if (i == 30 || result.length == (i + 1)){
				setTimeout(function(){
                   $.mobile.loading('hide');
                   $('.ui-datepicker-next').show();
                   $('.ui-datepicker-prev').show();
                },500);
			}
		}else{
			return;
		}
	});
	

	setTimeout(function(){
       $.mobile.loading('hide');
       $('.ui-datepicker-next').show();
       $('.ui-datepicker-prev').show();
    },500);    
};

/**
 * Fun��o de Ajax Callback ordemDiaInterna successo
 */
app.ajax.ordemDiaInternaSuccess=function( result, textStatus, jqXHR ){

	var detalheOrdem = result.replace('/icons/', 'http://alerjln1.alerj.rj.gov.br/icons/');

	$('.container-fluid.conteudo p').html('');
	$('.container-fluid.conteudo p').append(detalheOrdem);

	var h = $('.container-fluid.conteudo').find('table').find("font[color='#ff0000']");
	var hora;
	if (h[1]){
		hora = $(h[1]).html();
	}

	$('.container-fluid.conteudo').find('table').each(function(i, obj){
		if (i ==0){
			$(obj).remove();
		}
	});

	$('.container-fluid.conteudo').find("a[name='TOPO']").remove();
	$('.container-fluid.conteudo').find("div")[0].remove();
	$('.container-fluid.conteudo').find('div').find('b')[0].remove();

	var titulo = '';

	$('.container-fluid.conteudo').find('div').find('u').each(function(i, obj){
		if (i<=4){
			titulo = titulo + $(obj).text();
			if (i==0){
				titulo = titulo + '<br/>';
			}
			$(obj).remove();
		}

	});

	$('.controle-conteudo').find('h1').append(titulo);
	$('.controle-conteudo').find('.data').append(hora);

	setTimeout(function(){
       $.mobile.loading('hide');
    },500);
   
};

/**
 * Fun��o de Ajax Callback regimento interno successo
 */
app.ajax.regimeInternoSuccess=function( result, textStatus, jqXHR ){
	app.ajax.regimeInterno = result;
	montaRegimeInterno();
};

/**
 * Fun��o de Ajax Callback regimento interno interna successo
 */
app.ajax.regimeInternoInternaSuccess=function( result, textStatus, jqXHR ){

	var detalheRegimento = result.page.replace('/icons/', 'http://alerjln1.alerj.rj.gov.br/icons/');

	detalheRegimento = detalheRegimento.replace('Texto do Cap\u00edtulo', '');

	var t = app.ajax.regimeTitulo.split(' -');

    $('.conteudo-regimento p').html('');
    $('.conteudo-regimento p').append(detalheRegimento);

    $('.conteudo-regimento h2').html('');
  	$('.conteudo-regimento h2').append(result.title);

  	$('.titulo .area').html(t[0]);
  	$($('.titulo h1')[$('.titulo h1').length -1]).html(t[1]);

  	$($('.conteudo-regimento p').find('div')[0]).remove();
	$('.conteudo-regimento p').find('br').remove();

    setTimeout(function(){
           $.mobile.loading('hide');
    },500);
        
};

/**
 * Fun��o de Ajax Callback deputado Erro.
 */
app.ajax.deputadoError = function(){
	setTimeout(function(){
       $.mobile.loading('hide');
    },500);   
	alert('Servico indisponivel!');
};

/**
 * Fun��o de Ajax Callback ordemDia Erro.
 */
app.ajax.ordemDiaError = function(xhr, ajaxOptions, thrownError){
	setTimeout(function(){
       $.mobile.loading('hide');
       $('.ui-datepicker-next').show();
       $('.ui-datepicker-prev').show();
    },500);   
	alert('Servico indisponivel!');
};

/**
 * Fun��o de Ajax Callback ordemDiaInterna Erro.
 */
app.ajax.ordemDiaInternaError = function(){
	setTimeout(function(){
       $.mobile.loading('hide');
    },500);   
	alert('Servico indisponivel!');
};

/**
 * Fun��o de Ajax Callback regimento interno Erro.
 */
app.ajax.regimeInternoError = function(xhr, ajaxOptions, thrownError){
	setTimeout(function(){
       $.mobile.loading('hide');
    },500);   
	alert('Servico indisponivel!');
};

/**
 * Fun��o de Ajax Callback agenda Erro.
 */
app.ajax.agendaError = function(xhr, ajaxOptions, thrownError){
	setTimeout(function(){
       $.mobile.loading('hide');
       $('.ui-datepicker-next').show();
       $('.ui-datepicker-prev').show();
    },500);   
	alert('Servico indisponivel!');
};

/**
 * Fun��o de Ajax Callback agenda interno Erro.
 */
app.ajax.agendaInternaError = function(xhr, ajaxOptions, thrownError){
	setTimeout(function(){
       $.mobile.loading('hide');
    },500);   
	alert('Servico indisponivel!');
};

/**
 * Fun��o de Ajax Callback agenda interno Erro.
 */
app.ajax.agendaPesquisaError = function(xhr, ajaxOptions, thrownError){
	setTimeout(function(){
       $.mobile.loading('hide');
       $('.ui-datepicker-next').show();
       $('.ui-datepicker-prev').show();
    },500);   
	alert('Servico indisponivel!');
};

/**
 * Fun��o de Ajax Callback regimento interno interna Erro.
 */
app.ajax.regimeInternoInternaError = function(){
	setTimeout(function(){
       $.mobile.loading('hide');
    },500);   
	alert('Servico indisponivel!');
};


/**
 * Fun��o de Ajax Callback deputado interna Erro.
 */
app.ajax.deputadoInternaError = function(){
	setTimeout(function(){
       $.mobile.loading('hide');
    },500);   
	alert('Servico indisponivel!');
};

/**
 * Fun��o de Ajax Callback noticia Erro.
 */
app.ajax.noticiaError = function(){
	setTimeout(function(){
       $.mobile.loading('hide');
    },500);   
	alert('Servico indisponivel!');
};

/**
 * Fun��o de Ajax Callback faleconosco Erro.
 */
app.ajax.faleconoscoError = function(){
	setTimeout(function(){
       $.mobile.loading('hide');
    },500);   
	alert('Servico indisponivel!');
};

