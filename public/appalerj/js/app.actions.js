/**
 * Arquivo geral de acoes
 * 
 */

app.actions={}




/**
 * Faz a chama da para de consulta
 */

app.actions.noticia=function(filtro){

	if (filtro && filtro != ''){

		var url = '/ConteudoNoticiaService';
		if (filtro){
			url = url+'/?valor='+filtro;
		}

		app.actions.ajaxPortal({
			type: 'GET'
			,url: url
			,success: app.ajax.noticiaSuccess
			,error: app.ajax.noticiaError
			,jsonpCallback: 'app.ajax.noticiaSuccess'
		});

	}else{


		app.actions.ajaxPortal({
			type: 'GET'
			,url: '/noticiaservice?pagina=1'
			,success: function( result, textStatus, jqXHR ){
				app.ajax.listaNoticias.push(result[0]);
				
				app.actions.ajaxPortal({
					type: 'GET'
					,url: '/noticiaservice?pagina=2'
					,success: function( result, textStatus, jqXHR ){
						app.ajax.listaNoticias.push(result[0]);
						
						app.actions.ajaxPortal({
							type: 'GET'
							,url: '/noticiaservice?pagina=3'
							,success: app.ajax.noticiaSuccess
							,error: app.ajax.noticiaError
							,jsonpCallback: 'app.ajax.noticiaSuccess'
						});
						
					}
					,error: app.ajax.noticiaError
					,jsonpCallback: 'app.ajax.noticiaSuccess'
				});
				
			}
			,error: app.ajax.noticiaError
			,jsonpCallback: 'app.ajax.noticiaSuccess'
		});
		
		
		
		
		
		

	}
	
	
	
};

app.actions.faleconosco=function(data){
	
	app.actions.ajaxPortal({
		type: 'POST'
		,url: '/EmailService'
		,data: data
		,success: app.ajax.faleconoscoSuccess
		,error: app.ajax.faleconoscoError
		,jsonpCallback: 'app.ajax.faleconoscoSuccess'
	});
	
};


app.actions.deputado=function(){
	
	app.actions.ajaxPortal({
		type: 'GET'
		,url: '/deputadoservice'
		,success: app.ajax.deputadoSuccess
		,error: app.ajax.deputadoError
		,jsonpCallback: 'app.ajax.deputadoSuccess'
	});
	
};

app.actions.deputadoPesquisa=function(filtro){

	var url = '/deputadoservice';
	if (filtro){
		url = url+'/?nome='+filtro;
	}
	
	app.actions.ajaxPortal({
		type: 'GET'
		,url: url
		,success: app.ajax.deputadoPesquisaSuccess
		,error: app.ajax.deputadoError
		,jsonpCallback: 'app.ajax.deputadoPesquisaSuccess'
	});
	
};


app.actions.deputadoInterna=function(){
	
	app.actions.ajaxPortal({
		type: 'GET'
		,url: '/deputadoservice/'+app.ajax.deputadoSelecionado
		,success: app.ajax.deputadoInternaSuccess
		,error: app.ajax.deputadoInternaError
		,jsonpCallback: 'app.ajax.deputadoInternaSuccess'
	});
	
};

app.actions.agenda=function(mes, ano){

	setTimeout(function(){
       $.mobile.loading('show');
       $('.ui-datepicker-next').hide();
       $('.ui-datepicker-prev').hide();
    },10); 
	
	app.actions.ajaxPortal({
		type: 'GET'
		,url: '/AgendasService?Mes='+mes+'&Ano='+ano
		,success: app.ajax.agendaSuccess
		,error: app.ajax.agendaError
		,jsonpCallback: 'app.ajax.agendaSuccess'
	});
	
};

app.actions.agendaInterna=function(){
	
	app.actions.ajaxPortal({
		type: 'GET'
		,url: '/AgendaService/'+app.ajax.agendaSelecinada
		,success: app.ajax.agendaInternaSuccess
		,error: app.ajax.agendaInternaError
		,jsonpCallback: 'app.ajax.agendaInternaSuccess'
	});
	
};

app.actions.agendaPesquisa=function(filtro){
	
	app.actions.ajaxPortal({
		type: 'GET'
		,url: '/AgendaService?titulo='+filtro
		,success: app.ajax.agendaPesquisaSuccess
		,error: app.ajax.agendaPesquisaError
		,jsonpCallback: 'app.ajax.agendaPesquisaSuccess'
	});
	
};

app.actions.ordemPesquisa=function(filtro){

	var resultado = [];

	$.each(app.ajax.listaOrdens, function( index, obj ) {

		if(obj.title && filtro && obj.alerj_id && 

			(obj.title.toUpperCase().indexOf(filtro.toUpperCase()) > -1) ||
				obj.document.toUpperCase().indexOf(filtro.toUpperCase()) > -1
			){
			resultado.push(obj);
		}

	});


	$('.label_resultado').html('');
	$('.controle-resultado').html('');
	$('.label_resultado').html(resultado.length+' resultado(s) encontrado(s)');

	var templateResultado = ' <div class="resultado"><h2><a class="agenda-resultado" data-alerj-id="$$_ALERJ_ID_$$" >$$_TITULO_$$</a></h2>'+
							'<p>$$_DESCRICAO_$$</p></div>';

	$.each( resultado, function( i, obj ) { 
		if (i <=30){
			
			var item = templateResultado.replace('$$_TITULO_$$', obj.title);
			item = item.replace('$$_ALERJ_ID_$$', obj.alerj_id);

			var descricao = obj.document.substring(obj.document.toUpperCase().indexOf(filtro.toUpperCase()) - 30, obj.document.toUpperCase().indexOf(filtro.toUpperCase()) + 30); 
			descricao = descricao.replace(new RegExp('"Verdana"', 'g'), ' ');
			descricao = $.parseHTML( descricao.replace(new RegExp('"Arial"', 'g'), ' ') );
			item = item.replace('$$_DESCRICAO_$$', $(descricao[descricao.length -1]).text());

			$('.controle-resultado').append(item);
		}else{
			return;
		}
	});

	setTimeout(function(){
        $.mobile.loading('hide');
    },1000);
	 
	
};


app.actions.ordemDia=function(){

	setTimeout(function(){
       $.mobile.loading('show');
       $('.ui-datepicker-next').hide();
       $('.ui-datepicker-prev').hide();
    },10); 
	
	app.actions.ajax({
		type: 'GET'
		,url: '/schedule'
		,success: app.ajax.ordemDiaSuccess
		,error: app.ajax.ordemDiaError
		,jsonpCallback: 'app.ajax.ordemDiaSuccess'
	});
	
};

app.actions.ordemDiaInterna=function(){
	
	app.actions.ajax({
		type: 'GET'
		,url: '/schedule/'+app.ajax.ordemSelecinada
		,success: app.ajax.ordemDiaInternaSuccess
		,error: app.ajax.ordemDiaInternaError
		,jsonpCallback: 'app.ajax.ordemDiaInternaSuccess'
	});
	
};

app.actions.regimeInterno=function(){

	app.actions.ajax({
		type: 'GET'
		,url: '/documentsPages/Regimento%20Interno'
		,success: app.ajax.regimeInternoSuccess
		,error: app.ajax.regimeInternoError
		,jsonpCallback: 'app.ajax.regimeInternoSuccess'
	});
	
};

app.actions.regimeInternoInterna=function(){
	
	app.actions.ajax({
		type: 'GET'
		,url: '/documentsPages/page/'+app.ajax.regimeSelecionado
		,success: app.ajax.regimeInternoInternaSuccess
		,error: app.ajax.regimeInternoInternaError
		,jsonpCallback: 'app.ajax.regimeInternoInternaSuccess'
	});
	
};




app.actions.callbackJsonp=function(functionName, parseParameter, parameter ){

	var splitVector=functionName.split('\.');
	var currentFunction=window;
	for(var i=0;i<splitVector.length;i++ ){
		
		currentFunction=currentFunction[splitVector[i]];
	}
	if(currentFunction){
		if(parameter && parseParameter){
			parameter=$.parseJSON(parameter);
		}
		currentFunction.call(this,parameter);
	}

}

/**
 * Wrap do Ajax do jQuery, para lidar com requisicoes crossdomain
 */
app.actions.ajax=function(config){
	//setTimeout(function(){
   //    $.mobile.loading('show');
   // },1);    

	var _dataType,_jsonpCallback,_jsonp,_type,_url,_data,_errorCallback;
	if(app.crossdomain){
		_dataType='jsonp';
		_jsonpCallback="app.actions.callbackJsonp('"+config.jsonpCallback+"', true, '$JSON_param')";
		_jsonp='jsonp_callback';
		_type=app.actions.getType(config.type);
		if(config.data){
			_data='json='+escape(htmlEncode(config.data));
		}
		
		if(config.type!='GET'){
			_url=''+app.actions.getUrl()+'POST'+'/'+config.url
		}
		else{
			_url=app.actions.getUrl()+config.url
		}
	}
	else{
		_url=app.actions.getUrl()+config.url;
		_errorCallback=config.error;
	}

	$.ajax({
		type: _type || config.type
		,url: _url || config.url
		,dataType: config.dataType || _dataType
		,jsonpCallback: _jsonpCallback
		,jsonp: config.jsonp || _jsonp
		,data: _data || config.data
		,cache: false
		,success: config.success
		,error: _errorCallback
	});
}

/**
 * Wrap do Ajax do jQuery, para lidar com requisicoes crossdomain
 */
app.actions.ajaxPortal=function(config){
	
	//setTimeout(function(){
   //    $.mobile.loading('show');
  ///  },1); 

	var _dataType,_jsonpCallback,_jsonp,_type,_url,_data,_errorCallback;
	if(app.crossdomainPortal){
		_dataType='jsonp';
		_jsonpCallback='app.actions.callbackJsonp';
		_jsonp='jsonp_callback';
		_type="GET";
		if(config.data){
			_data='json='+escape(htmlEncode(config.data));
		}
		
		if(config.type!='GET'){
			_url=''+app.actions.getUrlPortal()+'POST'+'/'+config.url
		}
		else{
			_url=app.actions.getUrlPortal()+config.url
		}
	}
	else{
		_url=app.actions.getUrlPortal()+config.url;
		_errorCallback=config.error;
	}


	$.ajax({
		type: _type || config.type
		,url: _url || config.url
		,dataType: config.dataType || _dataType
		,jsonpCallback: _jsonpCallback
		,jsonp: config.jsonp || _jsonp
		,data: _data || config.data
		,cache: false
		,success: config.success
		,error: _errorCallback
	});
}

app.actions.getAction=function(){
	if(message.lastAjaxReq && message.lastAjaxReq.indexOf('(')>0){
		return message.lastAjaxReq.substring(0,message.lastAjaxReq.indexOf('('));
	}
	else if(message.lastAjaxReq){
		return message.lastAjaxReq;
	}
	else
		return message.action;
}

app.actions.getType=function (initialType){
	if(app.crossdomain){
		return "GET";
	}
	else initialType;
}

app.actions.getUrl=function(){
	if(app.crossdomain){
		return app.contextPath +app.remoteServicePath;
	}
	else{
		return app.contextPath +app.servicePath;
	}
}

app.actions.getUrlPortal=function(){
	if(app.crossdomainPortal){
		return app.contextPathPortal +app.remoteServicePathPortal;
	}
	else{
		return app.contextPathPortal +app.servicePathPortal;
	}
}

app.actions.navigateIndex = function( type, message ){
	$.mobile.changePage( app.media.util.indexMediaPage() , {transition:'slide', reverse:false, changeHash:true} );
}

function htmlEncode(value){
	String.prototype.replaceAll = function(stringToFind,stringToReplace){
	    var temp = this;
	    var index = temp.indexOf(stringToFind);
	        while(index != -1){
	            temp = temp.replace(stringToFind,stringToReplace);
	            index = temp.indexOf(stringToFind);
	        }
	        return temp;
	    }
	
	return !value ? value : String(value).replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;").replaceAll("{","%7B").replaceAll("}","%7D");
}