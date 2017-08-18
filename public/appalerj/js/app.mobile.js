/*
 * Manter na versao 1.0a2
 */
$( document ).bind( "mobileinit", function( ){
	
	//desabilita o modo nativo do select menu
	$.mobile.selectmenu.prototype.options.nativeMenu = false;
	
	// Desabilita o envio de formulario padrao!
	$.mobile.ajaxFormsEnabled = false;
	
	// Habilita os campos HTML5!
	$.extend( $.mobile.page.prototype.options.degradeInputs, {
		"color": false,
		"date": true,
		"datetime": true,
		"datetime-local": true,
		"email": false,
		"month": false,
		"number": false,
		"range": false,
		"search": false,
		"tel": false,
		"time": false,
		"url": false,
		"week": false
	});
	
	$.mobile.loadingMessage = "Carregando";
	$.mobile.loadingMessageTheme = 'a';
    $.mobile.loadingMessageTextVisible = true;
	$.mobile.pageLoadErrorMessage = "Erro ao Carregar Pagina"
	
	// Criar mecanismo de roteamento do BUS adicionando SANDBOX na execucao de scripts via AJAX.

	$( ".plc-page" ).live( "pagebeforecreate", function( event, ui ){
	//	console.log( "pagebefore-CREATE: Page PLC " + event.target.id, event, ui );
		plc.form.buildFormLayout( event.target );
	});	
	
	
	$( "[data-role=page]" ).live( "pagebeforecreate", function( event, ui ){
//		console.log( "pagebefore-CREATE:" + event.target.id, event, ui );
	});

	$( "[data-role=page]" ).live( "pagecreate", function( event, ui ){
	//	console.log( "page-CREATE:" + event.target.id, event, ui );
		
		document.addEventListener("backbutton", function(e){
		    if($.mobile.activePage.is('#login-page')){
		        e.preventDefault();
		        navigator.app.exitApp();
		    }
		    else if($.mobile.activePage.is('#index-page')){
		    	f_logout();
		    }
		    else {
		    	history.go(-1);
		        navigator.app.backHistory();
		    }
		}, false);
		
	});

	
	
	
});
