jQuery.unparam = function (value) {
    if (value) {
        var
                // Object that holds names => values. 
                params = {},
                // Get query string pieces (separated by &) 
                pieces = value.split('&'),
                // Temporary variables used in loop. 
                pair, i, l;
        // Loop through query string pieces and assign params. 
        for (i = 0, l = pieces.length; i < l; i++) {
            pair = pieces[i].split('=', 2);
            // Repeated parameters with the same name are overwritten. Parameters 
            // with no value get set to boolean true. 
            params[pair[0]] = (pair.length == 2 ? pair[1].replaceAll(/\+/g, ' ') : true);
        }
    } else {
        params = false;
    }

    return params;
};

jQuery.fn.jGrid = function (options) {
    var isto = this;
    var totalDeRegistros = 0;
    var opts = jQuery.extend({}, jQuery.fn.jGrid.defaults, options);
    var html = '';
    var objDataCache = {};
    var confAsync = false;
    var lista;
    var namespace = 'jGrid' + isto.id;

    GtCookie = {
        criar: function (name, value, days) {

            var expires;

            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toGMTString();

            } else {
                expires = "";
            }

            document.cookie = name + "=" + value + expires + "; path=/";
        },
        ler: function (name) {

            var nameEQ = name + "=";

            var ca = document.cookie.split(';');

            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];

                while (c.charAt(0) == ' ') {
                    c = c.substring(1, c.length);
                }

                if (c.indexOf(nameEQ) == 0) {
                    return c.substring(nameEQ.length, c.length);
                }
            }

            return null;
        },
        apagar: function (name) {
            GtCookie.criar(name, "", -1);
        }
    };

    var jGrid = {
        recuperaValorLinha: function (propriedade, valor) {
            var props = propriedade.split(".");
            var retorno = null;
            $.each(lista, function (index, value) {

                var propriedade = value[props[0]];
                if (propriedade == valor) {
                    retorno = value;
                    return true;
                }
                for (var t = 1; t < props.length; t++) {
                    if (propriedade != null) {
                        propriedade = propriedade[props[t]];
                    }
                    if (propriedade == valor) {
                        retorno = value;
                        return true;
                    }
                }
            });
            return retorno;
        },
        montaTbody: function (response) {
            lista = response.Lista;
            var limite = opts.limite;
            var html = '';
            var classCss, y, classe;
            totalDeRegistros = response.Total;
            if (response.Lista) {
                if (response.Lista.length < opts.limite) {
                    limite = response.Lista.length;
                }
            } else {
                limite = 0;
            }

            if (limite == false) {
                limite = response.Total;
            }
            if (limite > 0) {
                for (var i = 0; i < limite; i++) {
                    classCss = opts.onCreateLine(i, response[i]);
                    if (opts.tr_customizada != null) {
                        var classePersonalizada = opts.tr_customizada(response.Lista[i]);
                        if (classePersonalizada != "") {
                            classCss = classePersonalizada;
                        }
                    }
                    html += '<tr ' + classCss + 'id=' + i + '>';//cria cada linha da grid

                    y = 0;
                    for (var k in opts.colluns) {
                        if (opts.colluns[y].hasLink) {
                            html += '<td class="' + opts.colluns[y].classe_th + '" style="width:' + opts.colluns[y].width + 'px;"><div class="div_td" style="word-wrap: break-word; width:' + opts.colluns[y].width + 'px;"><div class="acoes">';
                            for (var x in opts.colluns[y].links) {
                                var insertLink = true;
                                if (opts.colluns[y].validacoes && opts.colluns[y].validacoes[x] != null) {
                                    insertLink = opts.colluns[y].validacoes[x](response.Lista[i]);
                                }
                                if (insertLink) {
                                    var link = opts.colluns[y].links[x];
                                    for (var j in opts.colluns[y].propertyName) {

                                        var props = opts.colluns[y].propertyName[j].split(".");

                                        var propriedade = response.Lista[i][props[0]];
                                        for (var t = 1; t < props.length; t++) {
                                            if (propriedade != null) {
                                                propriedade = htmlEncode(propriedade[props[t]]);
                                            }
                                        }

                                        if ((link.indexOf('radio') >= 0 || link.indexOf('checkbox') >= 0) && j == 0) {
                                            if (propriedade == "true" || propriedade == true) {
                                                link = link.replaceAll('{' + j + '}', "checked=" + propriedade)
                                            } else {
                                                link = link.replaceAll('{' + j + '}', propriedade)
                                            }
                                        } else {
                                            if ((propriedade == null || propriedade == "") && link.indexOf('img') >= 0) {
                                                link = "";
                                            } else {
                                                link = link.replaceAll('{' + j + '}', propriedade)
                                            }

                                        }
                                    }
                                    html += link;
                                } else if (opts.colluns[y].linkDesabilitado && opts.colluns[y].linkDesabilitado[x]) {
                                    html += opts.colluns[y].linkDesabilitado[x];
                                }
                            }
                            html += '</div></div></td>';
                        } else {
                            var propriedadeFinal = "";

                            if (opts.colluns[y].propertyName instanceof Array) {
                                for (var j in opts.colluns[y].propertyName) {
                                    if (j > 0) {
                                        propriedadeFinal += "</br>";
                                    }
                                    var props = opts.colluns[y].propertyName[j].split(".");

                                    var propriedade = response.Lista[i][props[0]];
                                    for (var t = 1; t < props.length; t++) {
                                        if (propriedade != null) {
                                            propriedade = propriedade[props[t]];
                                        }
                                    }
                                    if (propriedade != null) {
                                        propriedadeFinal += htmlEncode(propriedade);
                                    }
                                }
                            } else {
                                var props = opts.colluns[y].propertyName.split(".");

                                var propriedade = response.Lista[i][props[0]];
                                for (var t = 1; t < props.length; t++) {
                                    if (propriedade != null) {
                                        propriedade = propriedade[props[t]];
                                    }
                                }
                                if (propriedade != null) {
                                    propriedadeFinal += htmlEncode(propriedade);
                                }
                            }


                            var tooltip = "";
                            if (opts.colluns[y].tooltip) {
                                var props2 = opts.colluns[y].tooltip.split(".");
                                var propriedade2 = response.Lista[i][props2[0]];
                                for (var t = 1; t < props2.length; t++) {
                                    if (propriedade2 != null) {
                                        propriedade2 = propriedade2[props2[t]];
                                    }
                                }
                                tooltip = htmlEncode(propriedade2);
                            }
                            var classLinha = opts.colluns[y].classe_div_linha ? opts.colluns[y].classe_div_linha : "div_td";
                            html += '<td id=' + y + '><div class="' + classLinha + '" title="' + tooltip + '" style="width:' + opts.colluns[y].width + 'px;">' + propriedadeFinal + '</div></td>';// cria cada coluna

                        }
                        y++;
                    }
                    html += '</tr>';
                }

                jQuery(isto).find('tbody').html(html);
                jQuery('#sem_registro').remove();

            } else {

                if (!opts.isConsulta) {
                    if (namespace == 'jGridgrid_comentario' || namespace == 'jGridgrid_encaminha') {
                        $('#' + namespace + ' #sem_registro').remove();
                    } else {
                        $('#sem_registro').remove();
                    }
                    var msg = '<div class="sem_registros">' + opts.miExcessao + '</div>';
                    jQuery(isto).find('tbody').html("");
                    $(".controle_exibicao").remove();
                    jQuery(isto).parent().parent().find('#j-grid-paginacao').remove();
                    jQuery(isto).parent().parent().find('#j-grid-paginacao').remove(); //pq tem duas paginacoes
                    jQuery(isto).find('thead').remove();
                    jQuery(isto).html(msg);
                } else {
                    $(opts.div_grid).hide();
                    $(opts.elemento_mensagem).after(opts.miExcessao);
                }
            }

        },
        montaTbodyPesquisa: function (response) {
            lista = response.Lista;
            var limite = opts.limite;
            var html = '';
            var classCss, y, classe;
            totalDeRegistros = response.Total;
            if (response.Lista) {
                if (response.Lista.length < opts.limite) {
                    limite = response.Lista.length;
                }
            } else {
                limite = 0;
            }

            if (limite == false) {
                limite = response.Total;
            }
            jQuery("#paginacaoSuperior").html("");
            jQuery("#containerPesquisaErro").removeClass("erro");
            if (limite > 0) {
                for (var i = 0; i < limite; i++) {
                    if (limite > 0) {
                        html += '<div class="lista margin_bottom_25">';
                        if (response.Lista[i]["NmArquivoDestaque"] != null && response.Lista[i]["NmArquivoDestaque"] != "" && response.Lista[i]["NmArquivoDestaque"] != "null") {
                            html += '<div class="imagem">';
                            html += ' <a href="' + rootUrl + response.Lista[i]["NmLink"] + '" title="Foto da publicação ' + response.Lista[i]["NmTitulo"] + '"><img src="' + response.Lista[i]["NmArquivoDestaque"] + '" width="210" height="120" alt="Foto da publicação ' + response.Lista[i]["NmTitulo"] + '" title="Foto da publicação ' + htmlEncode(response.Lista[i]["NmTitulo"]) + '"></a>';
                            html += '</div>'
                        }
                        html += '<div class="conteudo">';

                        var dhDataItemFormatada = ""
                        console.log(response.Lista[i]);
                        if (response.Lista[i]["DhDataItemFormatada"] != "")
                            dhDataItemFormatada = "<span style=\"margin-left: 0px;\">" + response.Lista[i]["DhDataItemFormatada"] + "&nbsp;-&nbsp;</span>";

                        html += '<div class="subtitulo">' + dhDataItemFormatada + response.Lista[i]["NmTipoRegistro"] + '</div>';
                        html += '<h1><a href="' + rootUrl + response.Lista[i]["NmLink"] + '" title="' + response.Lista[i]["NmTitulo"] + '">' + htmlEncode(response.Lista[i]["NmTitulo"]) + '</a></h1>';
                        html += '<p>' + htmlEncode(response.Lista[i]["NmDescricao"]) + '</p>';
                        html += '</div>';
                        html += '</div>';

                        jQuery(isto).html(html);
                        jQuery('#sem_registro').remove();

                    }
                }
            } else {
                jQuery(isto).parent().parent().find('#j-grid-paginacao').remove();
                jQuery(isto).parent().parent().find('#j-grid-paginacao').remove(); //pq tem duas paginacoes
                if (response.Mensagem == null) {
                    jQuery("#paginacaoSuperior").html(opts.miExcessao);
                } else {
                    jQuery(".texto_erro").html(response.Mensagem);
                    jQuery("#containerPesquisaErro").addClass("erro");
                }
            }
        },
        montaTbodyVideos: function (response) {
            lista = response.Lista;
            var limite = opts.limite;
            var html = '';
            var classCss, y, classe;
            totalDeRegistros = response.Total;
            if (response.Lista) {
                if (response.Lista.length < opts.limite) {
                    limite = response.Lista.length;
                }
            } else {
                limite = 0;
            }

            if (limite == false) {
                limite = response.Total;
            }
            if (limite > 0) {
                for (var i = 0; i < limite; i++) {
                    if (limite > 0) {
                        html += '<div class="lista margin_bottom_25"><div class="conteudo">';
                        html += '<h1><a href="' + rootUrl + response.Lista[i]["NmLink"] + '" title="' + response.Lista[i]["NmTitulo"] + '">' + htmlEncode(response.Lista[i]["NmTitulo"]) + '</a></h1>';
                        html += '<p>' + htmlEncode(response.Lista[i]["NmDescricao"]) + '</p>';
                        html += '</div></div>';

                        jQuery(isto).html(html);
                        jQuery('#sem_registro').remove();

                    }
                }
            } else {
                jQuery(isto).html('<div class="lista margin_bottom_25">' + opts.miExcessao + '</div>');
            }

        },
        montaTbodyAudio: function (response) {
            lista = response.Lista;
            var limite = opts.limite;
            var html = '';
            var classCss, y, classe;
            totalDeRegistros = response.Total;
            if (response.Lista) {
                if (response.Lista.length < opts.limite) {
                    limite = response.Lista.length;
                }
            } else {
                limite = 0;
            }

            if (limite == false) {
                limite = response.Total;
            }
            if (limite > 0) {
                for (var i = 0; i < limite; i++) {
                    if (limite > 0) {
                        html += '<div class="lista sem_imagem margin_bottom_25"><div class="conteudo">';
                        html += '<div class="subtitulo">' + response.Lista[i]["DataHoraPublicacao"] + '<span>Por ' + htmlEncode(response.Lista[i]["NmCredito"]) + '</span></div>';
                        html += '<h1><a href="javascript: return false;" title="' + response.Lista[i]["NmTitulo"] + '">' + htmlEncode(response.Lista[i]["NmTitulo"]) + '</a></h1>';
                        html += '<div class="audio">';
                        // <!-- PLAYER -->
                        html += '<div id="audio_' + i + '" class="jquery_jplayer_1 jp-jplayer"></div>';
                        html += '<div id="jp_container_' + i + '" class="jp_container_' + i + ' jp-audio">';
                        html += '<div class="jp-type-single"> <div class="jp-gui jp-interface"> <ul class="jp-controls">';
                        html += '<li><a href="javascript:;" class="jp-play" tabindex="1" title="Play">Play</a></li>';
                        html += ' <li><a href="javascript:;" class="jp-pause" tabindex="1" title="Pause">Pause</a></li>';
                        html += ' <!--<li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>-->';
                        html += '   <li><a href="javascript:;" class="jp-mute" tabindex="1" title="Sem Áudio">Sem Áudio</a></li>';
                        html += '   <li><a href="javascript:;" class="jp-unmute" tabindex="1" title="Reativar Áudio">Reativar Áudio</a></li>';
                        html += '   <li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="Volume Máximo">Volume Máximo</a></li>';
                        html += '             </ul>';
                        html += '             <div class="controle_jp-volume-bar">';
                        html += '                   <div class="jp-volume-bar">';
                        html += '                      <div class="jp-volume-bar-value"></div>';
                        html += '                </div>';
                        html += '            </div>';
                        html += '            <div class="jp-time-holder">';
                        html += '                <div class="jp-current-time"></div>';
                        html += '                 <div class="jp-duration"></div>';
                        html += '             </div>';
                        html += '             <div class="jp-progress">';
                        html += '                <div class="jp-seek-bar">';
                        html += '                    <div class="jp-play-bar"></div>';
                        html += '                </div></div></div></div></div>';
                        // <!-- PLAYER --> 
                        html += ' </div></div></div>';
                        var audioScript = { id: i, caminho: response.Lista[i]["NmCaminhoAudio"] };
                        audios[i] = audioScript;

                        jQuery(isto).html(html);
                        jQuery('#sem_registro').remove();

                    }
                }
            } else {
                jQuery(isto).html('<div class="lista margin_bottom_25">' + opts.miExcessao + '</div>');

            }
        },
        montaTbodyGaleria: function (response) {
            lista = response.Lista;
            var limite = opts.limite;
            var html = '';
            var classCss, y, classe;
            totalDeRegistros = response.Total;
            if (response.Lista) {
                if (response.Lista.length < opts.limite) {
                    limite = response.Lista.length;
                }
            } else {
                limite = 0;
            }

            if (limite == false) {
                limite = response.Total;
            }

            if (limite > 0) {
                for (var i = 0; i < limite; i++) {
                    if (limite > 0) {
                        html += '<div class="conteudo margin_bottom_25">';
                        html += '<div class="subtitulo">' + response.Lista[i]["DataHoraPublicacao"] + '</div>';
                        html += '<h2><a href="' + rootUrl + response.Lista[i]["NmLink"] + '" title="' + response.Lista[i]["NmTitulo"] + '">' + htmlEncode(response.Lista[i]["NmTitulo"].toUpperCase()) + '</a></h2>';
                        html += '<p>' + htmlEncode(response.Lista[i]["NmDescricao"]) + '</p>';
                        html += '<div class="imagens image-set">';
                        var qtd = response.Lista[i]["ListaFotos"].length > 6 ? 6 : response.Lista[i]["ListaFotos"].length;
                        for (var j = 0; j < qtd; j++) {
                            var credito = response.Lista[i]["ListaFotos"][j]["DataFormatadaParaSite"];
                            var legenda = "";
                            if (response.Lista[i]["ListaFotos"][j]["NmLegenda"] != null) {
                                legenda = response.Lista[i]["ListaFotos"][j]["NmLegenda"];
                            }
                            if (response.Lista[i]["ListaFotos"][j]["NmCredito"] != null) {
                                credito += " | Por " + response.Lista[i]["ListaFotos"][j]["NmCredito"];
                            }
                            html += '<a creditos="' + credito + '" legendaImagem="' + legenda + '">';
                            html += '<img class="margem-imagens-tour" src="' + response.Lista[i]["CaminhoBase"] + "pequena_" + response.Lista[i]["ListaFotos"][j]["NmArquivo"] + '" width="100" height="55"></a>';
                        }
                        html += '</div>';
                        var fotos = response.Lista[i]["ListaFotos"].length > 1 ? 'FOTOS' : 'FOTO';
                        html += '<a href="' + rootUrl + response.Lista[i]["NmLink"] + '" class="quantidade">' + response.Lista[i]["ListaFotos"].length + '<span> ' + fotos + '</span></a>';
                        html += '</div>';

                        jQuery(isto).html(html);
                        jQuery('#sem_registro').remove();

                    }
                }
            } else {
                jQuery(isto).html('<div class="lista margin_bottom_25">' + opts.miExcessao + '</div>');
            }
        },
        montaTbodyNoticia: function (response) {
            lista = response.Lista;
            var limite = opts.limite;
            var html = '';
            var classCss, y, classe;
            totalDeRegistros = response.Total;
            if (response.Lista) {
                if (response.Lista.length < opts.limite) {
                    limite = response.Lista.length;
                }
            } else {
                limite = 0;
            }

            if (limite == false) {
                limite = response.Total;
            }
            if (limite > 0) {
                for (var i = 0; i < limite; i++) {
                    if (limite > 0) {
                        if (response.Lista[i]["NmCaminhoImagem"] != null && response.Lista[i]["NmCaminhoImagem"] != "" && response.Lista[i]["NmCaminhoImagem"] != "null") {
                            html += '<div class="lista margin_bottom_25">';
                            html += '<div class="imagem"><a href="' + rootUrl + response.Lista[i]["NmLink"] + '" title="Foto da notícia ' + response.Lista[i]["NmTitulo"] + '">';
                            html += '<img src="' + response.Lista[i]["NmCaminhoImagem"] + '" width="210" height="120" alt="Foto da notícia ' + response.Lista[i]["NmTitulo"] + '" title="Foto da notícia ' + response.Lista[i]["NmTitulo"] + '"></a></div>';
                        } else {
                            html += '<div class="lista sem_imagem margin_bottom_25">';
                        }

                        html += ' <div class="conteudo">';
                        var credito = response.Lista[i]["NmCredito"] != null && response.Lista[i]["NmCredito"] != "null" ? "Por " + htmlEncode(response.Lista[i]["NmCredito"]) : "";
                        html += ' <div class="subtitulo">' + response.Lista[i]["DataHoraPublicacao"] + '<span>' + credito + '</span></div>';
                        html += '<h1><a href="' + rootUrl + response.Lista[i]["NmLink"] + '" title="' + response.Lista[i]["NmTitulo"] + '">' + htmlEncode(response.Lista[i]["NmTitulo"]) + '</a></h1>';
                        html += ' <p>' + response.Lista[i]["NmDescricao"] + '</p>';
                        html += '</div></div>';

                        jQuery(isto).find('tbody').html(html);
                        jQuery('#sem_registro').remove();

                    }
                }
            } else {
                jQuery(isto).html('<div class="lista margin_bottom_25">' + opts.miExcessao + '</div>');
            }
        },
        montaTBodyDocumentoEletronico: function (response) {
            lista = response.Lista;
            var limite = opts.limite;
            var html = '';
            var classCss, y, classe;
            totalDeRegistros = response.Total;
            if (response.Lista) {
                if (response.Lista.length < opts.limite) {
                    limite = response.Lista.length;
                }
            } else {
                limite = 0;
            }

            if (limite == false) {
                limite = response.Total;
            }
            if (limite > 0) {
                for (var i = 0; i < limite; i++) {
                    if (limite > 0) {
                        var link = "javascript:DownloadArquivo('" + response.Lista[i]["NmLinkDownload"] + "','DO')";
                        html += '<div class="lista jornal margin_bottom_25">';
                        html += '<div class="capa"><a title="' + htmlEncode(response.Lista[i]["NmTitulo"]) + '"><img src="' + response.Lista[i]["NmCaminhoBase"] + response.Lista[i]["NmCaminhoImagem"] + '" width="85" height="120"></a></div>';
                        html += '<div class="conteudo"><div class="subtitulo">' + response.Lista[i]["DataHoraPublicacao"] + '</div>';
                        html += '<h1>' + htmlEncode(response.Lista[i]["NmTituloAudio"]) + '</h1>';
                        html += ' <div class="audio">';
                        if (response.Lista[i]["NmCaminhoAudio"] != "") {
                            html += '<div id="audio_' + i + '" class="jquery_jplayer_1 jp-jplayer"></div>';
                            html += '<div id="jp_container_' + i + '" class="jp_container_' + i + ' jp-audio">';
                            html += '<div class="jp-type-single">';
                            html += '<div class="jp-gui jp-interface">';
                            html += '<ul class="jp-controls">';
                            html += ' <li><a href="javascript:;" class="jp-play" tabindex="1" title="Play">Play</a></li>';
                            html += '<li><a href="javascript:;" class="jp-pause" tabindex="1" title="Pause">Pause</a></li>';
                            html += '   <!--<li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>-->';
                            html += ' <li><a href="javascript:;" class="jp-mute" tabindex="1" title="Sem Áudio">Sem Áudio</a></li>';
                            html += ' <li><a href="javascript:;" class="jp-unmute" tabindex="1" title="Reativar Áudio">Reativar Áudio</a></li>';
                            html += ' <li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="Volume Máximo">Volume Máximo</a></li>';
                            html += '  </ul> <div class="controle_jp-volume-bar">';
                            html += '  <div class="jp-volume-bar"> <div class="jp-volume-bar-value"></div>  </div></div>';
                            html += '  <div class="jp-time-holder"><div class="jp-current-time"></div><div class="jp-duration"></div></div>';
                            html += ' <div class="jp-progress"> <div class="jp-seek-bar"><div class="jp-play-bar"></div> </div></div>';
                            html += ' </div></div></div></div>';
                        }

                        html += '<a href="' + link + '" class="link margin_bottom_25" title="' + response.Lista[i]["NmTitulo"] + '">' + htmlEncode(response.Lista[i]["NmTitulo"]) + '</a>';
                        html += '</div> </div> </div>';

                        var audioScript = { id: i, caminho: response.Lista[i]["NmCaminhoAudio"] };
                        audios[i] = audioScript;

                        jQuery(isto).html(html);
                        jQuery('#sem_registro').remove();

                    }
                }
            } else {
                jQuery(isto).html('<div class="lista margin_bottom_25">' + opts.miExcessao + '</div>');
            }
        }
      , montaTBodyEvento: function (response) {
          lista = response.Lista;
          var limite = opts.limite;
          var html = '';
          var classCss, y, classe;
          totalDeRegistros = response.Total;
          if (response.Lista) {
              if (response.Lista.length < opts.limite) {
                  limite = response.Lista.length;
              }
          } else {
              limite = 0;
          }

          if (limite == false) {
              limite = response.Total;
          }

          if (limite > 0) {
              for (var i = 0; i < limite; i++) {
                  if (limite > 0) {
                      html += '<div class="controle_linha">';
                      html += '<p class="hora">' + response.Lista[i]["NmHora"] + '</p>';
                      html += '<h2>' + response.Lista[i]["NmTitulo"] + '</h2>';
                      html += '<p>' + response.Lista[i]["NmDescricao"] + '</p>';
                      html += '<a href="' + rootUrl + response.Lista[i]["NmLink"] + '">CONTINUAR</a>';
                      html += '</div>';

                      jQuery(isto).html(html);
                      jQuery('#sem_registro').remove();

                  }
              }
          } else {
              jQuery(isto).html('<div class="lista margin_bottom_25">' + opts.miExcessao + '</div>');
          }
      },
        montaTBodyBlog: function (response) {
            lista = response.Lista;
            var limite = opts.limite;
            var html = '';
            var classCss, y, classe;
            totalDeRegistros = response.Total;
            if (response.Lista) {
                if (response.Lista.length < opts.limite) {
                    limite = response.Lista.length;
                }
            } else {
                limite = 0;
            }

            if (limite == false) {
                limite = response.Total;
            }

            if (limite > 0) {

                for (var i = 0; i < limite; i++) {

                    if (limite > 0) {
                        html += '<div class="lista sem_imagem margin_bottom_25">';
                        html += '<div class="conteudo">';

                        var onclickTitulo = rootUrl + "Blog/Index?url=" + response.Lista[i]["UrlHiperlink"];
                        // var onclickTitulo = "window.open('" + response.Lista[i]["UrlHiperlink"] + "', '_blank')";

                        if (response.Lista[i]["NmDescricaoUltimoPost"] != null && response.Lista[i]["NmDescricaoUltimoPost"] != "" && response.Lista[i]["NmLink"] != "") {
                            var onclick = rootUrl + "Blog/Index?url=" + response.Lista[i]["UrlHiperlink"];
                            // var onclick = "window.open('" + response.Lista[i]["NmLink"] + "', '_blank')";
                        }
                        else {
                            response.Lista[i]["NmLink"] = 'javascript: return false;';
                            var onclick = "";
                        }

                        html += '<h1 class="margin_bottom_0"><a href="' + onclickTitulo + '" title="' + htmlEncode(response.Lista[i]["NmTitulo"]) + '"> ' + htmlEncode(response.Lista[i]["NmTitulo"]) + '</a></h1>';
                        html += '<div class="subtitulo margin_bottom_10">' + htmlEncode(response.Lista[i]["NmDescricao"]) + '</div>';
                        if ((response.Lista[i]["NmChaveBlog"] != null && response.Lista[i]["NmChaveBlog"] != '') && (response.Lista[i]["NmCodigoBlog"] != null && response.Lista[i]["NmCodigoBlog"] != '')) {

                            if (response.Lista[i]["NmDescricaoUltimoPost"] != null) {
                                html += '<p style="font-size:10px;"><strong>ÚLTIMO POST:' + response.Lista[i]["DataUltimaPublicacao"] + ' - ' + response.Lista[i]["HoraUltimaPublicacao"] + '</strong></p>';


                                var re = /(<([^>]+)>)/gi;
                                response.Lista[i]["NmDescricaoUltimoPost"] = response.Lista[i]["NmDescricaoUltimoPost"].replace(re, "");

                                if (response.Lista[i]["NmDescricaoUltimoPost"].length > 250) {
                                    html += '<p class="margin_bottom_5">' + response.Lista[i]["NmDescricaoUltimoPost"].substring(0, 247) + '...</p>';
                                }
                                else {
                                    html += '<p class="margin_bottom_5">' + response.Lista[i]["NmDescricaoUltimoPost"] + '</p>';
                                }
                            }

                        }
                        if (onclick != "") {
                            html += '<a  href="' + onclick + '" class="link margin_bottom_5">VISUALIZAR...</a>';
                        }
                        html += '</div>';
                        html += '</div>';

                        jQuery(isto).html(html);
                        jQuery('#sem_registro').remove();

                    }
                }
            } else {
                jQuery(isto).html('<div class="lista margin_bottom_25">' + opts.miExcessao + '</div>');
            }
        },
        //montaTBodyLinksUteis: function (response) {
        //    lista = response.Lista;
        //    var limite = opts.limite;
        //    var htmlOutros = '';
        //    var htmlOrgaos = '';
        //    var htmlServicosPublico = '';
        //    var classCss, y, classe;
        //    totalDeRegistros = response.Total;
        //    if (response.Lista) {
        //        if (response.Lista.length < opts.limite) {
        //            limite = response.Lista.length;
        //        }
        //    } else {
        //        limite = 0;
        //    }

        //    if (limite == false) {
        //        limite = response.Total;
        //    }

        //    if (limite > 0) {

        //        for (var i = 0; i < limite; i++) {

        //            if (limite > 0) {
        //                console.log(response.Lista[i]);
        //                html += '<div class="lista sem_imagem margin_bottom_25">';
        //                html += '<div class="conteudo">';
        //                if (response.Lista[i].NmTipoHiperlink == "OT") {
        //                    htmlOutros += '<p><b>Busca na internet</b></p>';
        //                    htmlOutros += '<p><a href="javascript:;" class="link" title="Busca Site">Busca Site</a></p>';
        //                    htmlOutros += '<p class="margin_bottom_10">Você pode reclamar, sugerir ou denunciar diretamente sobre os assuntos</p>';
        //                    htmlOutros += '<p><b>Acessibilidade</b></p>';
        //                    htmlOutros += '<p class="margin_bottom_30"><a href="javascript:;" class="link" title="Dos Vox">Dos Vox</a></p>';
        //                }
        //                else if (response.Lista[i].NmTipoHiperlink == "OG") {

        //                }
        //                html += '</div>';
        //                html += '</div>';

        //                jQuery(isto).html(html);
        //                jQuery('#sem_registro').remove();

        //            }
        //        }
        //    } else {
        //        jQuery(isto).html('<div class="lista margin_bottom_25">' + opts.miExcessao + '</div>');
        //    }
        //},
        __montaPaginacao_1: function (response, paginaAtual, limite) {

            if (response.Total > 0) {
                var html = '';
                var regIni = 0;
                var regFim = 0;

                var iniPage = paginaAtual - 2;
                if (iniPage < 1) {
                    iniPage = 1;
                }

                var numPage = iniPage + 5;
                var totalPage = Math.ceil(response.Total / opts.limite);

                if (numPage > totalPage) {
                    numPage = totalPage + 1;
                    iniPage = totalPage - 4;
                }

                if (iniPage < 1) {
                    iniPage = 1;
                }

                regIni = (paginaAtual * opts.limite) - opts.limite + 1;
                regFim = (paginaAtual * opts.limite) > response.Total ? response.Total : (paginaAtual * opts.limite);

                html += '<div id="j-grid-paginacao">';
                if (totalPage > 1) {
                    html += '<div class="exibindo">Exibindo ' + regIni + ' a ' + regFim + ' de ' + response.Total + '</div>';
                }
                html += '<div class="controle">';

                if (totalPage > 1) {

                    if (paginaAtual == 1) {
                        html += '<div class="icone"><a id="j-grid-inicio" href="javascript:return false;" title="Primeira" class="primeira desativado"></a></div>';
                        html += '<div class="icone"><a id="j-grid-aterior" href="javascript:return false;" title="Anterior" class="anterior desativado"></a></div>';
                    } else {
                        html += '<div class="icone"><a id="j-grid-inicio" href="javascript:return false;" title="Primeira" class="primeira j-grid-inicio"></a></div>';
                        html += '<div class="icone"><a id="j-grid-aterior" href="javascript:return false;" title="Anterior" class="anterior j-grid-aterior"></a></div>';
                    }

                    for (var i = iniPage; i < numPage; i++) {
                        if (i != paginaAtual) {
                            html += '<div class="botao"><a href="javascript:return false;" class="j-grid-paginas" title="' + i + '">' + i + '</a></div>';
                        } else {
                            html += '<div class="botao"><a href="javascript:return false;" title="' + i + '" class="ativo j-grid-paginas">' + i + '</a></div>';
                        }
                    }

                    if (paginaAtual == totalPage || totalPage == '0') {
                        html += '<div class="icone"><a id="j-grid-proximo" href="javascript:return false;" title="Próxima" class="proxima desativado"></a></div>';
                        html += '<div class="icone"><a id="j-grid-fim" href="javascript:return false;" title="Última" class="ultima desativado"></a></div>';
                    } else {
                        html += '<div class="icone"><a id="j-grid-proximo" href="javascript:return false;" title="Próxima" class="proxima j-grid-proximo"></a></div>';
                        html += '<div class="icone"><a id="j-grid-fim" href="javascript:return false;" title="Última" class="icone ultima j-grid-fim"></a></div>';
                    }
                }
                //   html += '</ul>';
                html += '</div><div id="divBotoes" class="controle_icone float_right"></div></div>';

                $(isto).parent().parent().find('.borda_inferior, .borda_superior').find('#j-grid-paginacao').remove();
                $(isto).parent().parent().find('.borda_inferior, .borda_superior').append(html);


                $(isto).parent().parent().find('.borda_inferior, .borda_superior').parent().find('.j-grid-paginas').each(function () {
                    jQuery(this).bind('click', function () {
                        jGrid.reload({
                            pagina: jQuery(this).text()
                        });
                    });
                });

                if (paginaAtual != 1) {
                    $(isto).parent().parent().find('.borda_inferior, .borda_superior').parent().find('.j-grid-inicio').click(function () {
                        jGrid.reload({
                            pagina: 1
                        });
                    });

                    $(isto).parent().parent().find('.borda_inferior, .borda_superior').parent().find('.j-grid-aterior').click(function () {
                        jGrid.reload({
                            pagina: paginaAtual - 1
                        });
                    });
                }

                if (paginaAtual != (totalPage) && totalPage != '0') {
                    $(isto).parent().parent().find('.borda_inferior, .borda_superior').parent().find('.j-grid-proximo').click(function () {
                        jGrid.reload({
                            pagina: paginaAtual + 1
                        });
                    });

                    $(isto).parent().parent().find('.borda_inferior, .borda_superior').parent().find('.j-grid-fim').click(function () {
                        jGrid.reload({
                            pagina: totalPage
                        });
                    });
                }
                if (paginaAtual > (totalPage) && totalPage != '0') {
                    jGrid.reload({
                        pagina: paginaAtual - 1
                    });
                }
            }

        },
        __montaPaginacao_2: function (response, paginaAtual, limite) {
            var html = '';

            var iniPage = paginaAtual - 2;
            if (iniPage < 1) {
                iniPage = 1;
            }

            var numPage = iniPage + 5;
            var totalPage = Math.ceil(response.Total / opts.limite);

            if (numPage > totalPage) {
                numPage = totalPage + 1;
                iniPage = totalPage - 4;
            }

            if (iniPage < 1) {
                iniPage = 1;
            }

            html += '<div class="base width_640 fundo_02" id="j-grid-paginacao">';
            html += '<div class="paginacao">';

            if (totalPage > 1) {

                if (paginaAtual == 1) {
                    html += '<div class="botao_out margin_left_5">&lt;&lt;</div>';
                    html += '<div class="botao_out margin_left_5">&lt;</div>';
                } else {
                    html += '<div class="botao margin_left_5"><a id="j-grid-inicio" href="javascript:;">&lt;&lt;</a></div>';
                    html += '<div class="botao margin_left_5"><a id="j-grid-aterior" href="javascript:;">&lt;</a></div>';
                }

                for (var i = iniPage; i < numPage; i++) {
                    if (i != paginaAtual) {
                        html += '<div class="botao margin_left_5" ><a class="j-grid-paginas" href="javascript:;">' + i + '</a></div>';
                    } else {
                        html += '<div class="botao_on margin_left_5">' + i + '</div>';
                    }
                }

                if (paginaAtual == totalPage || totalPage == '0') {
                    html += '<div class="botao_out margin_left_5">&gt;</div>';
                    html += '<div class="botao_out margin_left_5">&gt;&gt;</div>';
                } else {
                    html += '<div class="botao margin_left_5"><a id="j-grid-proximo" href="javascript:;">&gt;</a></div>';
                    html += '<div class="botao margin_left_5"><a id="j-grid-fim" href="javascript:;">&gt;&gt;</a></div>';
                }
            }
            html += '</div>';
            html += '</div>';

            $('#j-grid-paginacao').remove();
            $(isto).parent().append(html);

            jQuery(isto).parent().find('.j-grid-paginas').each(function () {
                jQuery(this).bind('click', function () {
                    jGrid.reload({
                        pagina: jQuery(this).text()
                    });
                });
            });

            if (paginaAtual != 1) {
                jQuery(isto).parent().find('#j-grid-inicio').click(function () {
                    jGrid.reload({
                        pagina: 1
                    });
                });

                jQuery(isto).parent().find('#j-grid-aterior').click(function () {
                    jGrid.reload({
                        pagina: paginaAtual - 1
                    });
                });
            }

            if (paginaAtual != (totalPage) && totalPage != '0') {
                jQuery(isto).parent().find('#j-grid-proximo').click(function () {
                    jGrid.reload({
                        pagina: paginaAtual + 1
                    });
                });

                jQuery(isto).parent().find('#j-grid-fim').click(function () {
                    jGrid.reload({
                        pagina: totalPage
                    });
                });

            }

        },
        __montaPaginacao_3: function (response, paginaAtual, limite) {
            var html = '';

            var iniPage = paginaAtual - 2;
            if (iniPage < 1) {
                iniPage = 1;
            }

            var numPage = iniPage + 5;
            var totalPage = Math.ceil(response.Total / opts.limite);

            if (numPage > totalPage) {
                numPage = totalPage + 1;
                iniPage = totalPage - 4;
            }

            if (iniPage < 1) {
                iniPage = 1;
            }

            html += '<div class="base fundo_02" id="j-grid-paginacao" style="min-height: 24px; display:none;">';
            html += '<div class="paginacao">';

            if (totalPage > 1) {
                if (paginaAtual == 1) {
                    html += '<div class="botao_out margin_left_5">&lt;&lt;</div>';
                    html += '<div class="botao_out margin_left_5">&lt;</div>';
                } else {
                    html += '<div class="botao margin_left_5"><a id="j-grid-inicio" href="javascript:;">&lt;&lt;</a></div>';
                    html += '<div class="botao margin_left_5"><a id="j-grid-aterior" href="javascript:;">&lt;</a></div>';
                }

                for (var i = iniPage; i < numPage; i++) {
                    if (i != paginaAtual) {
                        html += '<div class="botao margin_left_5" ><a class="j-grid-paginas" href="javascript:;">' + i + '</a></div>';
                    } else {
                        html += '<div class="botao_on margin_left_5">' + i + '</div>';
                    }
                }

                if (paginaAtual == totalPage || totalPage == '0') {
                    html += '<div class="botao_out margin_left_5">&gt;</div>';
                    html += '<div class="botao_out margin_left_5">&gt;&gt;</div>';
                } else {
                    html += '<div class="botao margin_left_5"><a id="j-grid-proximo" href="javascript:;">&gt;</a></div>';
                    html += '<div class="botao margin_left_5"><a id="j-grid-fim" href="javascript:;">&gt;&gt;</a></div>';
                }
            }
            html += '</div>';
            html += '</div>';

            $('#j-grid-paginacao').remove();
            $(isto).parent().append(html);

            jQuery(isto).parent().find('.j-grid-paginas').each(function () {
                jQuery(this).bind('click', function () {
                    jGrid.reload({
                        pagina: jQuery(this).text()
                    });
                });
            });

            if (paginaAtual != 1) {
                jQuery(isto).parent().find('#j-grid-inicio').click(function () {
                    jGrid.reload({
                        pagina: 1
                    });
                });

                jQuery(isto).parent().find('#j-grid-aterior').click(function () {
                    jGrid.reload({
                        pagina: paginaAtual - 1
                    });
                });
            }

            if (paginaAtual != (totalPage) && totalPage != '0') {
                jQuery(isto).parent().find('#j-grid-proximo').click(function () {
                    jGrid.reload({
                        pagina: paginaAtual + 1
                    });
                });

                jQuery(isto).parent().find('#j-grid-fim').click(function () {
                    jGrid.reload({
                        pagina: totalPage
                    });
                });
            }
        },
        montaTfoot: function (response, paginaAtual) {
            paginaAtual = (paginaAtual) ? paginaAtual : 1;
            response.Total = (response.Total) ? response.Total : 0;

            var limite = opts.limite * paginaAtual;
            if (limite > response.Total) {
                limite = response.Total;
            }

            if (opts.tipoPaginacao == '1') {
                this.__montaPaginacao_1(response, paginaAtual, limite);
            } else if (opts.tipoPaginacao == '0') {

            } else if (opts.tipoPaginacao == '3') {
                this.__montaPaginacao_3(response, paginaAtual, limite);
            } else {
                this.__montaPaginacao_2(response, paginaAtual, limite);
            }

        },
        __detectOrder: function (data, cache) {
            var order;

            if (data && data.order) {
                var orderUrl = (cache) ? cache.order.split(' ') : ['1', 'DESC'];
                order = (orderUrl[0] == data.order && orderUrl[1] == 'ASC') ? data.order + ' DESC' : data.order + ' ASC';
            } else {
                order = (cache.order) ? cache.order : opts.defaultOrderCollum;
            }

            jQuery(isto).find('.j-grid-order-asc, .j-grid-order-desc').removeClass('j-grid-order-asc j-grid-order-desc ativo');


            var orderNow = order.split(' ');
            if (orderNow[1] == 'ASC') {
                //img asc
                jQuery(isto).find('#j-grid-order-' + orderNow[0] + '').addClass('j-grid-order-asc ativo');
            } else {
                //img des
                jQuery(isto).find('#j-grid-order-' + orderNow[0] + '').addClass('j-grid-order-desc ativo');
            }

            return order;

        },
        __setStorage: function (objData) {

            var dataSer = jQuery.param(objData);

            if (opts.cacheUrl) {
                window.location.hash = dataSer;
            }

            if (opts.cacheCookie) {
                GtCookie.criar(namespace, dataSer, 0);
            }

            return dataSer;
        },
        __descSort: function (property) {
            return function (a, b) {
                a = a[property].toLowerCase();
                b = b[property].toLowerCase();
                return (a < b) ? 1 : ((a > b) ? -1 : 0);
            };
        },
        __ascSort: function (property) {
            return function (a, b) {
                a = a[property].toLowerCase();
                b = b[property].toLowerCase();
                return (a > b) ? 1 : ((a < b) ? -1 : 0);
            };
        },
        __renderGrid: function (data) {

            var dataSerialized = this.__setStorage(objDataCache);
            var dataAsync = this.confAsync;

            if (!jQuery.isFunction(opts.url) && opts.url != false) {

                jQuery.ajax({
                    cache: false,
                    url: opts.url,
                    type: 'get',
                    data: dataSerialized,
                    dataType: 'json',
                    async: dataAsync,
                    beforeSend: function () {
                        if (opts.beforeSend) {
                            opts.beforeSend();
                        }
                    },
                    success: function (response) {
                        if (opts.evento_pre_render != null && opts.evento_pre_render != '') {
                            opts.evento_pre_render(response.Lista);
                        }
                        if (opts.tipoCorpo == '1') {
                            jGrid.montaTbody(response);
                        } else if (opts.tipoCorpo == '2') {
                            jGrid.montaTbodyVideos(response);
                        } else if (opts.tipoCorpo == '3') {
                            jGrid.montaTbodyAudio(response);
                        } else if (opts.tipoCorpo == '4') {
                            jGrid.montaTbodyGaleria(response);
                        } else if (opts.tipoCorpo == '5') {
                            jGrid.montaTbodyNoticia(response);
                        } else if (opts.tipoCorpo == '6') {
                            jGrid.montaTBodyDocumentoEletronico(response);
                        } else if (opts.tipoCorpo == '7') {
                            jGrid.montaTBodyEvento(response);
                        } else if (opts.tipoCorpo == '8') {
                            jGrid.montaTBodyBlog(response);
                        } else if (opts.tipoCorpo == '9') {
                            jGrid.montaTBodyLinksUteis(response);
                        }
                        else {
                            jGrid.montaTbodyPesquisa(response);
                        }

                        jGrid.montaTfoot(response, objDataCache.pagina);

                        if (opts.success) {
                            opts.success(isto, response);
                        }

                        if (data && data.callback) {
                            data.callback(response);
                        }
                    },
                    complete: function (response) {
                        if (opts.complete) {
                            opts.complete(response);
                        }
                    }
                });

            } else if (jQuery.isFunction(opts.url)) {
                var arrObj = opts.url();
                var response = {
                    total: 0,
                    data: []
                };

                if (arrObj != null) {

                    var order = objDataCache.order.split(" ");
                    if (order[1] == 'ASC') {
                        arrObj.sort(this.__ascSort(order[0]));
                    } else {
                        arrObj.sort(this.__descSort(order[0]));
                    }

                    response.Total = arrObj.length;

                    var inicio = opts.limite * (objDataCache.pagina - 1);
                    var fim = inicio + opts.limite;
                    if (fim > response.Total) {
                        fim = response.Total;
                    }

                    for (var i = inicio; i < fim; i++) {
                        response.data.push(arrObj[i]);
                    }
                }



                jGrid.montaTbody(response);
                jGrid.montaTfoot(response, objDataCache.pagina);

                if (opts.success) {
                    opts.success();
                }
            }
        },
        totalDeRegistrosGrid: function () {
            return totalDeRegistros;
        },
        reload: function (data) {

            if (data && data.consultar) {
                if (data.data && opts.iniReload) {
                    for (i in data.data) {
                        if (data.data[i] != '') {
                            objDataCache[i] = decodeURIComponent(data.data[i]);
                        } else {
                            delete objDataCache[i];
                        }
                    }
                } else {
                    for (i in opts.data) {
                        if (opts.data[i] != '') {
                            objDataCache[i] = unescape(opts.data[i]);
                        } else {
                            delete objDataCache[i];
                        }
                    }
                }

                objDataCache.pagina = 1;
            }

            if (data) {
                if (data.pagina && !data.consultar) {
                    objDataCache.pagina = parseInt(data.pagina);
                }

                objDataCache.limite = (data.limite) ? data.limite : opts.limite;
                objDataCache.order = this.__detectOrder(data, objDataCache);

                objDataCache.consultar = true;
            }

            this.__renderGrid(data);
        }
    };

    html += '<table id="j-grid-table" class="table table-hover table-striped" width="' + opts.width + '" style="' + opts.style + '" cellpadding="0" cellspacing="0" border="0">';
    html += '<thead>';
    html += '<tr class="border_bottom_0px">';

    var classe, order, classe_div;
    var count_ordem = 0;
    if (opts.collunsPai.length > 0) {

        for (var i in opts.collunsPai) {
            classe = (opts.collunsPai[i].classe_th) ? 'class="' + opts.collunsPai[i].classe_th + '"' : '';
            classe_div = (opts.collunsPai[i].classe_div) ? 'class="' + opts.collunsPai[i].classe_div + '"' : '';
            if (opts.collunsPai[i].hasOrder) {
                count_ordem++;
            }
            height = (opts.collunsPai[i].height) ? ' height="' + opts.collunsPai[i].height + '"' : '';
            html += '<th ' + classe + ' width="' + opts.collunsPai[i].width + '" ' + height + ' colspan="' + opts.collunsPai[i].colspan + '"><div ' + classe_div + ' style="width:' + opts.collunsPai[i].width + 'px;">' + opts.collunsPai[i].header + '</div></th>';
        }
        count_ordem = 0;

        html += '</tr><tr class="border_bottom_0px">';
    }
    for (var i in opts.colluns) {
        classe = (opts.colluns[i].classe_th) ? 'class="' + opts.colluns[i].classe_th + '"' : '';
        classe_div = (opts.colluns[i].classe_div) ? 'class="' + opts.colluns[i].classe_div + '"' : '';
        if (opts.colluns[i].hasOrder) {
            count_ordem++;
        }
        height = (opts.colluns[i].height) ? ' height="' + opts.colluns[i].height + '"' : '';
        html += '<th ' + classe + ' width="' + opts.colluns[i].width + '" ' + height + '><div ' + classe_div + ' style="width:' + opts.colluns[i].width + ';">' + opts.colluns[i].header + '</div></th>';
    }
    html += '</tr>';


    if (count_ordem > 0) {
        var order_ = "";
        html += '<tr class="ordenacao">';
        for (var k in opts.colluns) {
            order_ = (opts.colluns[k].hasOrder) ? '' : 'class="desativado"'; //verifica se tem ordenacao na coluna
            order_ = (opts.colluns[k].order) ? 'class=""' : order_; //adiciona qual coluna esta previamente ordenada
            height = (opts.colluns[k].height) ? opts.colluns[k].height : '';
            classe = (opts.colluns[k].classe_th) ? 'class="' + opts.colluns[k].classe_th + '"' : '';

            html += '<td><a  id="j-grid-order-' + (parseInt(k) + 1) + '" href="javascript:;"' + order_ + '></a></td>';

        }
        html += '</tr>';
    }


    html += '</thead>';

    html += '<tbody>';
    html += '</tbody>';

    html += '<tfoot>';
    html += '</tfoot>';

    html += '</table>';

    jQuery(this).html(html);

    jQuery(isto).find('.ordenacao td a').each(function (i) {
        if (opts.colluns[i] && opts.colluns[i].hasOrder) {
            jQuery(this).bind('click', function () {


                jGrid.reload({
                    pagina: 1,
                    order: (i + 1)
                });
            });
        }
    });


    var param_hash = {};
    if (opts.cacheUrl || opts.cacheCookie) {
        param_hash = jQuery.unparam(window.location.hash.substring(1));
    }

    var hash = {};
    if (param_hash.consultar) {

        var cookieSer = GtCookie.ler(namespace);

        if (cookieSer) {
            hash = jQuery.unparam(cookieSer);


            if (opts.cacheUrl) {
                window.location.hash = cookieSer;
            }
        }
    }

    if (opts.iniReload || hash.consultar) {

        /*popula inputs*/
        //for (i in hash) {
        //    if (hash[i] && jQuery.inArray(i, ['pagina', 'limite', 'order']) == -1 && $("#" + i)) {
        //        $("#"+i).val(decodeURIComponent(hash[i]));
        //    }
        //}

        /*popula inputs*/

        var objDataUrl = {
            consultar: true
        };


        if (hash) {
            objDataCache = hash;
            if (opts.isConsulta) {
                objDataUrl.data = hash;
            }
        }

        if (hash[0] == undefined && opts.isConsulta) {
            objDataUrl.data = param_hash;
        }

        if (hash.pagina) {
            objDataUrl.pagina = hash.pagina;
        }

        if (hash.limite) {
            objDataUrl.limite = hash.limite;
        }

        jGrid.reload(objDataUrl);

    } else {
        var objDataUrl = {
            consultar: true
        };
        jGrid.reload(objDataUrl);
        jGrid.montaTfoot([], 1);
        GtCookie.apagar(namespace);
    }

    return jGrid;
};

jQuery.fn.jGrid.defaults = {
    defaultOrderCollum: "1 ASC"
            ,
    limite: 10
       ,
    tipoPaginacao: 1,

    tr_customizada: null,

    cacheUrl: true
            ,
    cacheCookie: true
            ,
    url: true
            ,
    success: false
            ,
    iniReload: true
            ,
    tipoPaginacao: "1",

    tipoCorpo: "2"
            ,
    width: "100%"
            ,
    colluns: []
            ,
    collunsPai: []
            ,
    data: {}
    ,
    complete: false
            ,
    miExcessao: "<div class='mensagem erro margin_top_20 margin_bottom_10'>Resultado não encontrado.</div>"
    ,
    div_grid: ".tabela" //utilizado para esconder(Se nao ouver resultados) ou exibir a grid
            ,
    isConsulta: true //indica se é pagina de consulta(esconde grid vazia) ou inclusao, exibe grid
    ,
    elemento_mensagem: "#referenciaGridMensagemNenhumRegistro" // mensagem sera incluida após esse elemento
    ,
    evento_pre_render: null,  //funcão que é executada antes da montagem da grid e recebe o resultado da consulta para edição

    style: "",


    onCreateLine: function (i, dataLine) {
        return (i % 2 == 0) ? 'class="tr_escura"' : 'class="tr_clara"';
    }
};

function htmlEncode(value) {
    if (value) {
        return jQuery('<div />').text(value).html();
    } else {
        return '';
    }
}

function htmlDecode(value) {
    if (value) {
        return $('<div />').html(value).text();
    } else {
        return '';
    }
}

String.prototype.replaceAll = function (target, replacement) {
    return this.split(target).join(replacement);
};