$(document).ready(function () {
    $(".menu li").hover(
          function () {
              var im = $(this);
              var isFechado = !im.find(".submenu").is(":visible");

              im.parent().find(".submenu").css('display', 'none');

              if (isFechado) {
                  im.find(".submenu").css('display', 'block');
              }
          }
    )
    $(".submenu").hover(
		   function () {
		       var sm = $(this);
		       var parent = sm.parent().find("a").first();
		       parent.addClass("submenu_ativo");
		   },
		   function () {
		       var sm = $(this);
		       var parent = sm.parent().find("a").first();
		       parent.removeClass("submenu_ativo");
		   }
	);


    $(".menu ul li.filho_pai").hover(
		function () {
		    var im = $(this);
		    var isFechado = !im.find(".submenu_filho_pai").is(":visible");

		    im.parent().find(".submenu_filho_pai").css('display', 'none');

		    if (isFechado) {
		        im.find(".submenu_filho_pai").css('display', 'block');
		    }
		}
	);
    $(".submenu_filho_pai").hover(
		   function () {
		       var sm = $(this);
		       var parent = sm.parent().find("a").first();
		       parent.addClass("filho_pai_ativo");
		   },
		   function () {
		       var sm = $(this);
		       var parent = sm.parent().find("a").first();
		       parent.removeClass("filho_pai_ativo");
		   }
	);
});


$(document).ready(function () {
    $(".menu_movel li").mousedown(function (e) {
        var im = $(this);
        $(".menu_movel li.pai a.titulo").removeClass("submenu_ativo");

        if (im.find(".submenu_movel").is(":visible")) {
            im.find(".submenu_movel").css('display', 'none');
        } else {
            $(".submenu_movel").css('display', 'none');
            im.find(".submenu_movel").css('display', 'block');
            im.find("a.titulo").addClass("submenu_ativo");
        }
    });
});

function enableSubMenus() {
    var lis = document.getElementsByTagName('li');
    for (var i = 0, li; li = lis[i]; i++) {
        var link = li.getElementsByTagName('a')[0];
        if (link) {
            link.onfocus = function () {
                var div = this.parentNode.getElementsByTagName('div')[0];
                if (div)
                    div.style.display = 'block';
            }
            var ul = link.parentNode.getElementsByTagName('ul')[0];
            if (ul) {
                var ullinks = ul.getElementsByTagName('a');
                var ullinksqty = ullinks.length;
                var lastItem = ullinks[ullinksqty - 1];
                if (lastItem) {
                    lastItem.onblur = function () {
                        this.parentNode.parentNode.style.display = '';
                    }
                }
            }
        }
    }
}
window.onload = enableSubMenus;