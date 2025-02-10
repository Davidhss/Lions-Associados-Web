$(".menu > ul > li").click(function (e) {
    // remover ativo de já ativo
    $(this).siblings().removeClass("active")
    // adicionar ativo a clicado
    $(this).toggleClass("active");
    // se tiver submenu abra-o
    $(this).find("ul").slideToggle();
    // Fechar outro submenu se houver algum aberto
    $(this).siblings().find("ul").slideUp();
    // Remover classe ativa de itens de submenu
    $(this).siblings().find("ul").find("li").removeClass("active");
});
