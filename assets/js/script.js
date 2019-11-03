$(function () {
    setInterval(updateArea, 100);
});

function updateArea() {
    var alturaTela = $(window).height();
    var posY = $('.cursoLeft').offset().top;
    var altura = alturaTela - posY;
    $('.cursoLeft, .cursoRight').css('height', altura + 'pX');
    
    //ajustar tamanho do video
    var ratio = 1920/1080;
    var videoLargura = $("#video").width();
    var videoAltura = videoLargura / ratio;
    
    $("#video").css("height",videoAltura+'px');
}

function marcarAssistida(obj){
    var id = $(obj).attr("data-id");
    $.ajax({
        type: 'GET',
        url:"/projeto_ead/ajax/marcarAssistida/"+id,
        success: function(){
            $(obj).html("Assistida");
            $(obj).attr("disabled","didabled");
        }
    });
}
