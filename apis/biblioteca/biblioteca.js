
function abrir_doc(id) {
    let novo_id = id.replace("accordion-biblioteca-", "");
    let item_2 = 'arquivo_' + novo_id;
    let item = 'accordion_biblioteca_' + novo_id;
    let href = $("#" + item).attr("href");
    $("#respostas_" + novo_id).html("<iframe name='" + item_2 + "' id='" + item_2 + "' href='" + href + "' width='100%' height='100%'> </iframe>");
    $("#arquivo_" + novo_id).attr("src", href);
};


$(document).ready(function () {
    // you can remove this if you want, it will stop the carousel transtioning automatically. 
    $('#slideCarousel').carousel({
        interval: 10000
    });
});




$('.collapse').on('show.bs.collapse', function () {
    id = $(this).prop("id");
    if ($("#controler_" + id).val() == 0) {
        $('#' + id + ' i').toggleClass('fa-chevron-right fa-chevron-down');
        // Cria a ul dinamicamente e adiciona abaixo do label
        var ul = $('<ul>').addClass('submenu lista_').attr('id', 'ul_' + id);
        let idSemPrefixo = id.replace("sub_1_", "");
        let nivel_2 = 0;
        if (id.includes('final')) {
            nivel_2 = id.replace("final_1_", "");
            var id = $('#' + id).parent("div").attr("id");
            idSemPrefixo = id.replace("sub_1_", "");
        }

        $.ajax({
            type: "POST",
            dataType: 'json',
            url: 'ajax_lista_left.php',
            data: {
                tipo_material_id: idSemPrefixo,
                nivel_2 : nivel_2,
            },
            async: false,
            success: function (data) {

                // Verificando se `data` � um array e se tem pelo menos um elemento
                if (Array.isArray(data) && data.length > 0) {
                    // Iterando sobre os dados recebidos
                    data.forEach(function (element) {
                        var link = $("<a>")
                            .attr("href", info + "biblioteca/" + element.link)
                            .attr("target", "arquivo_" + element.acervo_id);
                        // Criando um novo item de lista <li> e anexando-o � <ul>
                        var li = $("<li>").attr("onclick", "visualizar_documento(" + element.acervo_id + ")").text(element.label).addClass("text-truncate").css("max-width", "290px").attr("title", element.label).append(link);
                        var icon = $("<i>").addClass("fas fa-angle-double-right textbg-purple-light-3 mr-2");
                        li.prepend(icon);
                        ul.append(li);
                    });
                    $('#' + id).addClass("item_ativo");
                } else {
                    // Se `data` estiver vazio ou n�o for um array, voc� pode lidar com isso aqui
                    console.log("Dados vazios ou em formato incorreto.");
                    var li = $("<li>").text("O item est� vazio");
                    ul.append(li);
                }
            },
            error: function () {
                console.log('erro');
            }
        });
        $(this).append(ul);
    }
    $("#controler_" + $(this).prop("id")).val(1);
    $(this).prev().find('i').removeClass('fa-chevron-right').addClass('fa-chevron-down');
});

$('.collapse').on('hide.bs.collapse', function () {
    $(this).prev().find('i').removeClass('fa-chevron-down').addClass('fa-chevron-right');
});

function visualizar_documento(id) {

    $.ajax({
        type: "POST",
        dataType: 'json',
        url: 'ajax_listar_itens.json',
        data: {
            acervo_id: id,
        },
        async: false,
        success: function (data) {
            // Verificando se `data` � um array e se tem pelo menos um elemento
            let historico = "";
            if (data.descricao_n2 != "") {
                historico = data.descricao.toUpperCase() + " > " + data.descricao_n2.toUpperCase() + " > " + data.label.toUpperCase();
            } else {
                historico = data.descricao.toUpperCase() + " > " + data.label.toUpperCase();
            }
            if (data.tipo_link == "link") {
                link_historico = data.link.split("biblioteca/");
                link_historico = link_historico[1];
            } else {
                link_historico = data.link;
            }
            var larguraDiv = $('#container_esquerdo').height();
            height_div_esquerdo = parseFloat(larguraDiv)*0.65;
            height_div_esquerdo = height_div_esquerdo.toString()+'px';
            $("#visualizacao").html("<div class='bg-white-light-3 historico-a texto-com-linha p-3'><b>IN�CIO >" + historico + "</b></div><div class='bg-white-light-3'><button onclick='location.reload()' class='botao-voltar'><i class='fas fa-arrow-left'></i>    <b>Voltar</b></button></div><ul class='ul-a bg-white-light-3'><li class='li-a'>T�tulo: " + data.label + "</li><li class='li-a'>Autor: " + data.autor + "</li><li class='li-a'>Ano: " + data.ano + "</li><li class='li-a'>Palavra-chave: " + data.palavra_chave + "</li></ul><iframe name='" + id + "' id='arquivo_" + id + "' src='" + link_historico + "' width='100%' height='"+height_div_esquerdo +"'> </iframe>");
            acessoItem(id);
        },
        error: function () {
            console.log('erro');
        }
    });



}

$(function () {
    $("#search").click(function () {
        // Define o valor do campo de entrada como vazio
        $(this).val("");
    });
    var atribute = [];
    $.widget("custom.catcomplete", $.ui.autocomplete, {
        _create: function () {
            this._super();
            this.widget().menu("option", "items", "> :not(.ui-autocomplete-category)");
        },
        _renderMenu: function (ul, items) {
            var that = this,
                currentCategory = "";
            $.each(items, function (index, item) {
                var li;
                if (item.category != currentCategory) {
                    ul.append("<li style='color:#663399' class='ui-autocomplete-category'><b>" + item.category + "</b></li>");
                    currentCategory = item.category;
                }
                li = that._renderItemData(ul, item);
                if (item.category) {
                    li.attr("aria-label", item.category + " : " + item.label);
                }
                li.on("click", function () {
                    // Chama sua fun��o com o item selecionado como argumento
                    autoCompleteCategoria(item);
                  

                });
            });

        },

    });

    $("#search").catcomplete({
        
        delay: 20,
        source:"ajax_listar_itens.json?term="+$("#search").val(),
        minLength: 3, // Define o tamanho m�nimo do termo como 3 caracteres
        select: function(event, ui){
            return false;
        },
    });
});
function autoCompleteCategoria(item) {
    let historico = "";
    if (item.descricao_n2 != "") {
        historico = item.descricao.toUpperCase() + " > " + item.descricao_n2.toUpperCase() + " > " + item.label.toUpperCase();
    } else {
        historico = item.descricao.toUpperCase() + " > " + item.label.toUpperCase();
    }
    if (item.tipo_link == "link") {
        link_historico = item.link.split("biblioteca/");
        link_historico = link_historico[1];
    } else {
        link_historico = item.link;
    }
    var larguraDiv = $('#container_esquerdo').height();
    height_div_esquerdo = parseFloat(larguraDiv)*0.65;
    height_div_esquerdo = height_div_esquerdo.toString()+'px';
    $("#visualizacao").html("<div class='bg-white-light-3 historico-a texto-com-linha p-3'><b>IN�CIO >" + historico + "</b></div><div class='bg-white-light-3'><button onclick='location.reload()' class='botao-voltar'><i class='fas fa-arrow-left'></i>    <b>Voltar</b></button></div><ul class='ul-a bg-white-light-3'><li class='li-a'>T�tulo: " + item.label + "</li><li class='li-a'>Autor: " + item.autor + "</li><li class='li-a'>Ano: " + item.ano + "</li><li class='li-a'>Palavra-chave: " + item.palavra_chave + "</li></ul><iframe name='" + item.acervo_id + "' id='arquivo_" + item.acervo_id + "' src='" + link_historico + "' width='100%' height='"+height_div_esquerdo +"'> </iframe>");
}
function acessoItem(acervo_id) {
    $.ajax({
        url: 'ajax_inserir_acesso.php',
        dataType: 'html',
        type: 'POST',
        data: {
            acervo_id: acervo_id,
            tipo: 1,
        },
    });
}




