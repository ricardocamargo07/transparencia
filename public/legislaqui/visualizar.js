function DownloadArquivo(caminho, tipoDocumentoEletronico) {
    window.location = rootUrl + 'Visualizar/DownloadArquivo?caminho=' + caminho + '&tipoDocumentoEletronico=' + tipoDocumentoEletronico;
}
function redirecionaUrlExterna(url, isExibeAlerta, idCampo) {
    if (url.indexOf("http") < 0) {
        url = 'http://' + url;
    }
    if (isExibeAlerta == "true" || isExibeAlerta == "True") {
        AdicionaConfirmacao(idCampo, "Você será redirecionado para um site externo, deseja continuar?", url);
    } else {
        window.location = url;
    }
}

$(function () {
    $(document).ready(function () {
        var total = $(".painel_interno ul li").length;
        if (total == 1) {
            $('.painel_interno .paginacao').addClass('display_none');
        }
    });

    //Disque
    $(".telefoneDisque").each(function () {
        var phone, element;
        element = $(this).html();
        phone = element.replace(/\D/g, '');
        if (phone.indexOf("0800") == 0) {
            $(this).html($.mask.string(phone, '9999-999-9999?'));
        }
        else {
            if (phone.length > 10) {
                $(this).html($.mask.string(phone, '(99) 99999-9999?'));
            } else {
                $(this).html($.mask.string(phone, '(99) 9999-99999?'));
            }
        }
    });

    $('body').removeClass("background_color_ffffff");

    function onAfter(curr, next, opts) {
        var index = opts.currSlide;
        $('.paginacao span.atual').text(index + 1)
        $('.paginacao span.total').text(opts.slideCount)

        if (index == 0) {
            $('.prev').addClass('inativo');
        } if (index > 0) {
            $('.prev').removeClass('inativo');
        }
        if (index == opts.slideCount - 1) {
            $('.next').addClass('inativo');
        } else {
            $('.next').removeClass('inativo');
        }
    }

    $('.painel_interno ul').cycle({
        fx: 'fade',
        speed: 500,
        timeout: 0,
        next: '.next',
        prev: '.prev',
        after: onAfter
    })
    
});




//<![CDATA[
$(document).ready(function () {
    if (typeof audios !== 'undefined') {
        $.each(audios, function (key, value) {
            adicionaCaminhoMusica(value.id, value.caminho);
        });
    }

});

function adicionaCaminhoMusica(idDiv, caminhoMusica) {
    $("#audio_" + idDiv).jPlayer({
        ready: function (event) {
            $(this).jPlayer("setMedia", {
                mp3: caminhoMusica
            });
        },
        play: function () { $(this).jPlayer("pauseOthers"); },
        cssSelectorAncestor: "#jp_container_" + idDiv,
        swfPath: caminhoJPlayer,
        supplied: "mp3",
        wmode: "window",
        smoothPlayBar: true,
        keyEnabled: true,
        remainingDuration: true,
        toggleDuration: true
    });
}

function adicionaHttpNaUrl(url) {
    var http = "http://";
    var inicioUrl = str.substring(0, 6);
    if (inicioUrl.indexOf(http) == -1) {
        url = http + url;
    }

    return url;
}
function AdicionaConfirmacao(seletor, msg, url) {

    var dialog = $(document.createElement('div'));
    dialog.className = "conteudo_alerta";
    dialog.html("<p class='margin_bottom_10'>" + msg + "</p>");
    dialog.dialog({
        dialogClass: "alerta",
        title: 'ATENÇÃO',
        width: 500,
        modal: true,
        buttons: {
            "CANCELAR": function () {
                $(this).dialog("close");
                return false;
            },
            "CONFIRMAR": function () {
                $(this).dialog("close");
                window.location = url;
                return true;
            }
        }
    });
}