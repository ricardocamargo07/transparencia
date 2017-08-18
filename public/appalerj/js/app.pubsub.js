/**
 * Arquivo geral de funções para manipulação de eventos.
 * 
 */


/**
 * Faz a chama da para a pesquisa
 */
app.bus.subscribe( "*.pesquisa",app.actions.search );