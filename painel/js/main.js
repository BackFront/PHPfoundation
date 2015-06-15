$(document).ready(function() {
    $('.ctr-menu').click(function() {
        var cls = $('aside').attr('data-view');
        if (cls == 'show') {
            $('aside').attr('data-view', 'hide');
            $('aside').hide('fast');
            $('main, .nav-opt').attr("style", "width: 100%;");
        } else if (cls == 'hide') {
            $('aside').attr('data-view', 'show');
            $('aside').show('fast');
            $('main, .nav-opt').attr("style", "");
        }
    });

    //Mouse wheel
    $(function() {
        $("main").mousewheel(function(event, delta) {
            this.scrollLeft -= (delta * 80);
            event.preventDefault();
        });
    });
    //Clique scroll desabilitado
    //$(".container").draggable({axis: "x", containment: "body", scroll: false});

    //Scroll Personalizado
    $(function() {
        $('main').perfectScrollbar({suppressScrollY: true});
    });

    //Abre um novo elemento na tela  
    $(document).on("click",".newElement",function() {
        var File = $(this).attr('data-fileOpen') + '.tpl.php';
        
        var IdContent = $(this).attr('href');
        
        $.get(File, { IdContent : IdContent }).done(function(data) {
            $('.painel.content').append(data);
            $('.a').show('fast');
            $("main").animate({
                scrollLeft: $(".ps-container").width()
            }, 500);
        });
        return false;
    });

    //Abre um novo elemento no rodape da tela
    $(document).on("click",".newElementBottom",function() {
        var File = $(this).attr('data-fileOpen') + '.tpl.php';
        $.get(File, function(data) {
            $('main').append(data);
            $('.a').show('fast');
        });
        return false;
    });
    
    //CLOSE BOX
    $(document).on('click','.close-box',function(){
       $(this).parent().parent('.a').hide(500, function() {
            $(this).remove();
            $("main").animate({
                scrollLeft: $(".ps-container").width()
            }, 500);
        }); 
        return false;
    });
    
});
