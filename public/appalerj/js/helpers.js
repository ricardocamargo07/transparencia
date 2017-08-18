var tvAlerjPlayer;
var done = false;

function loadData() {
    jQuery.get(
        app.apiPortal + '/tv',
        {},
        function(result) {
            window.app.tv.video.id = result.video.id;
        }
    );
}

function validateEmail(email){
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

function adjustIframes()
{
    $('iframe').each(function(){
        var
            $this       = $(this),
            proportion  = $this.data( 'proportion' ),
            w           = $this.attr('width'),
            actual_w    = $this.width();

        alert(proportion);

        if ( ! proportion )
        {
            proportion = $this.attr('height') / w;
            $this.data( 'proportion', proportion );
        }

        if ( actual_w != w )
        {
            $this.css( 'height', Math.round( actual_w * proportion ) + 'px' );
        }
    });
}

function bootAloAlerj() {
    $('#faleconosco-page').on('click', '#enviar', function(e) {

        var validacao = true;

        if ($('#nome').val() == ''){
            validacao = false;
        }

        if ($('#email').val() == ''){
            validacao = false;
        }

        if ($('#ddd').val() == ''){
            validacao = false;
        }

        if ($('#telefone').val() == ''){
            validacao = false;
        }

        if ($('#mensagem').val() == ''){
            validacao = false;
        }

        if (!validacao){
            alert('Por favor, preencha todos os campos para enviar a mensagem!');
        }else{


            if (!validateEmail($('#email').val())){
                alert('E-mail inválido!');
                return;

            }else{

                setTimeout(function(){
                    $.mobile.loading('show');
                },500);

                var data = 'Nome='+$('#nome').val()+'&Email='+$('#email').val()+'&Telefone='+$('#ddd').val()+'-'+$('#telefone').val()+'&Mensagem=' + $('#mensagem').val();

                app.actions.faleconosco(data);
            }

        }

    });

    $( "#faleconosco-page" ).on( "swiperight", function(){

        $( ":mobile-pagecontainer" ).pagecontainer( "change", "inicio.html", { role: "page", transition: 'slide', reverse: 'true' } );
    } );

    $('#ddd').keydown(function (e) {

        var inputLength = $(this).val().length;

        if(inputLength >= 2 && e.keyCode >= 48 && e.keyCode <= 57) {
            e.preventDefault();
            return false;
        }
    });

    $('#telefone').keydown(function (e) {

        var inputLength = $(this).val().length;

        if(inputLength >= 9 && e.keyCode >= 48 && e.keyCode <= 57) {
            e.preventDefault();
            return false;
        }
    });
}

function playTvAlerj() {
    // 2. This code loads the IFrame Player API code asynchronously.
    var tag = document.createElement('script');

    tag.src = "https://www.youtube.com/iframe_api";
    var scriptTag = document.getElementsByTagName('script')[0];
    scriptTag.parentNode.insertBefore(tag, scriptTag);

    jQuery('.voltar > a').on('click', function () {
        console.log('voltar play tv');
    });

    tvAlerjPlayer.playVideo();
}

function pauseTvAlerj() {
    if (typeof tvAlerjPlayer !== 'undefined') {
        tvAlerjPlayer.stopVideo();
    }
}

function onYouTubeIframeAPIReady() {
    // 3. This function creates an <iframe> (and YouTube player)
    //    after the API code downloads.

    tvAlerjPlayer = new YT.Player('video-player', {
        height: '100%',
        width: '100%',
        videoId: app.tv.video.id,
        events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
        }
    });
}

// 4. The API will call this function when the video player is ready.
function onPlayerReady(event) {
    event.target.playVideo();
}

// 5. The API calls this function when the player's state changes.
//    The function indicates that when playing a video (state=1),
//    the player should play for six seconds and then stop.
function onPlayerStateChange(event) {
    if (event.data == YT.PlayerState.PLAYING && !done) {
        done = true;
    }
}

function bootHome() {
    $( "#inicio-page"  ).on( "click", ".menu-tvalerj", function() {

        $( ":mobile-pagecontainer" ).pagecontainer( "change", "tvalerj.html", { role: "page", transition: 'slide'  } );

        playTvAlerj();

    });

    $( "#inicio-page"  ).on( "click", ".menu-radioalerj", function() {

        $( ":mobile-pagecontainer" ).pagecontainer( "change", "radioalerj.html", { role: "page", transition: 'slide'  } );

        playRadioAlerj();

    });

    $( "#inicio-page"  ).on( "click", ".menu-deputado", function() {

        app.ajax.scrollTopDeputado = 0;

        $( ":mobile-pagecontainer" ).pagecontainer( "change", "deputados.html", { role: "page", transition: 'slide'  } );

    });

    $( "#inicio-page"  ).on( "click", ".menu-mesadiretora", function() {

        app.ajax.scrollTopDeputado = 0;

        $( ":mobile-pagecontainer" ).pagecontainer( "change", "mesadiretora.html", { role: "page", transition: 'slide'  } );

    });

    $( "#inicio-page"  ).on( "click", ".menu-linhadireta", function() {

        app.ajax.scrollTopDeputado = 0;

        $( ":mobile-pagecontainer" ).pagecontainer( "change", "linhadireta.html", { role: "page", transition: 'slide'  } );

    });

    $( "#inicio-page"  ).on( "click", ".menu-partidos", function() {

        app.ajax.scrollTopDeputado = 0;

        $( ":mobile-pagecontainer" ).pagecontainer( "change", "partidos.html", { role: "page", transition: 'slide'  } );

    });

    $( "#inicio-page"  ).on( "click", ".menu-ordem", function() {

        app.ajax.mesAnoOrdem = '';
        dataOrdemSelecionada = null;

        $( ":mobile-pagecontainer" ).pagecontainer( "change", "ordemdodia.html", { role: "page", transition: 'slide'  } );

    });


    $( "#inicio-page"  ).on( "click", ".menu-regimento", function() {


        app.ajax.scrollTopRegimento = 0;

        $( ":mobile-pagecontainer" ).pagecontainer( "change", "regimentointerno.html", { role: "page", transition: 'slide' } );

    });


    $( "#inicio-page"  ).on( "click", ".menu-noticias", function() {


        $( ":mobile-pagecontainer" ).pagecontainer( "change", "noticias.html", { role: "page", transition: 'slide'  } );

    });


    $( "#inicio-page"  ).on( "click", ".menu-aloalerj", function() {


        $( ":mobile-pagecontainer" ).pagecontainer( "change", "faleconosco.html", { role: "page", transition: 'slide'   } );

    });

    $( "#inicio-page"  ).on( "click", ".menu-agenda", function() {

        app.ajax.mesAnoAgenda = '';


        $( ":mobile-pagecontainer" ).pagecontainer( "change", "agenda.html", { role: "page" , transition: 'slide'  } );

    });

    $( "#inicio-page"  ).on( "click", ".menu-transparencia", function() {

        $( ":mobile-pagecontainer" ).pagecontainer( "change", "transparencia.html", { role: "page" , transition: 'slide'  } );

    });

    $( "#inicio-page"  ).on( "click", ".menu-licitacoes", function() {

        $( ":mobile-pagecontainer" ).pagecontainer( "change", "transparencia.html", { role: "page" , transition: 'slide'  } );

    });

    $( "#inicio-page"  ).on( "click", ".menu-leiseprojetos", function() {

        $( ":mobile-pagecontainer" ).pagecontainer( "change", "leiseprojetos.html", { role: "page" , transition: 'slide'  } );

    });

    $( "#inicio-page"  ).on( "click", ".menu-portal", function() {

        $( ":mobile-pagecontainer" ).pagecontainer( "change", "portal.html", { role: "page" , transition: 'slide'  } );

    });

    $( "#inicio-page"  ).on( "click", ".menu-carteirada", function() {

        $( ":mobile-pagecontainer" ).pagecontainer( "change", "carteiradadobem.html", { role: "page", transition: 'slide'   } );

    });

    $( "#inicio-page"  ).on( "click", ".menu-comissoes", function() {

        $(":mobile-pagecontainer").on("pagecontainerchange", function( event, ui ) {
            bootComissoes();
        } );

        $(":mobile-pagecontainer").pagecontainer( "change", "comissoes.html", {
            role: "page",

            transition: 'slide',
        });

    });

    // enable swipe for android
    $.event.special.swipe.scrollSupressionThreshold = 10;
    $.event.special.swipe.horizontalDistanceThreshold = 30;
    $.event.special.swipe.durationThreshold = 500;
    $.event.special.swipe.verticalDistanceThreshold = 75;

    var ratio = window.devicePixelRatio || 1;
    var w = screen.width * ratio;
    var h = screen.height * ratio;

    $(document).on( "pagebeforeshow", function() {
        $(document).on('click', '.voltar > a', function(e){
            pauseTvAlerj();
        });
    });

    $(window).on('resize load',adjustIframes);
}

function bootComissoes()
{
    console.log('boot comissoes');

    $( "#comissoes-page"  ).on( "click", ".menu-comissoes-oquesao", function() {

        console.log('o que são!');

        $( ":mobile-pagecontainer" ).pagecontainer( "change", "comissoes-oquesao.html", { role: "page", transition: 'slide'   } );

    });

    $( "#comissoes-page"  ).on( "click", ".menu-comissoes-permanentes", function() {

        $( ":mobile-pagecontainer" ).pagecontainer( "change", "comissoes-permanentes.html", { role: "page", transition: 'slide'   } );

    });

    $( "#comissoes-page"  ).on( "click", ".menu-comissoes-cpi", function() {

        $( ":mobile-pagecontainer" ).pagecontainer( "change", "comissoes-cpi.html", { role: "page", transition: 'slide'   } );

    });

    $( "#comissoes-page"  ).on( "click", ".menu-comissoes-especiais", function() {

        $( ":mobile-pagecontainer" ).pagecontainer( "change", "comissoes-especiais.html", { role: "page", transition: 'slide'   } );

    });

    $( "#comissoes-page"  ).on( "click", ".menu-comissoes-representacao", function() {

        $( ":mobile-pagecontainer" ).pagecontainer( "change", "comissoes-representacao.html", { role: "page", transition: 'slide'   } );

    });
}
