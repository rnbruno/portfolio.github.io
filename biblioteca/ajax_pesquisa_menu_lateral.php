<?php
                    // chamar o arquivo de funções
require_once "../src/tecnico/conf/constantesBanco.php";
require_once "../src/tecnico/conf/funcoesSemSession.php";
require_once PATH_CLASSES . "Biblioteca2.php";


$retorno['sucesso'] = false;
$retorno['mensagem'] = toUtf("Erro ao inserir");
$retorno['debug'] = "";

if ((!is_null(safepost('tipo_marcados'))) && (safepost('tipo_marcados')[0] != "")) {
	$tipo_marcados = safepost('tipo_marcados');
} else {
	$tipo_marcados = [""];
}

if ((!is_null(safepost('nivel_2'))) && (safepost('nivel_2')[0] != "")) {
	$nivel_2 = safepost('nivel_2');
} else {
	$nivel_2 = [""];
}

if ((!is_null(safepost('termo_pesquisa'))) && (safepost('termo_pesquisa') != "")) {
	$termo_pesquisa = toIso(safepost('termo_pesquisa'));
} else {
	$termo_pesquisa = "";
}

if(!isset($tipo_marcados)){
    $tipo_marcados = "";
}else if(count($tipo_marcados)>1){
    $retorno['mensagem'] = toUtf("Mais que 1");
    $tipo_marcados = join(", ", $tipo_marcados);
}else{
    $tipo_marcados = $tipo_marcados[0];
}

if ((!is_null(safepost('botao_mostrar'))) && (safepost('botao_mostrar') != "")) {
	$botao_mostrar = intval(safepost('botao_mostrar'));
} else {
	$botao_mostrar = 15;
}

if(!isset($nivel_2)){
    $nivel_2 = "";
}else if(count($nivel_2)>1){
    $retorno['mensagem'] = toUtf("Mais que 1");
    $nivel_2 = join(", ", $nivel_2);
}else{
    $nivel_2 = $nivel_2[0];
}


try {
	$pdo->beginTransaction();

    $pesquisa_com_item = new Biblioteca($pdo);
	$limit = 15;
	$resultado_geral = $pesquisa_com_item->BuscarBibliotecaComItem("", "", "", "", $tipo_marcados, "", "", $nivel_2, $botao_mostrar,15);
    $quantidade_registros = 0;
    $quantidade_registros = $resultado_geral["buscar_quantidade"]["quantidade_acervo"];
    if($botao_mostrar>$quantidade_registros){
        $botao_mostrar = $quantidade_registros;
    }
?>
    <h5 class="text-center">
        <span class=" p-2 col-xl-10">Mostrar    <button class="btn btn-light badge badge-light" style="font-size: 15px">15</button> |<button class="btn btn-link">50</button>|<button class="btn btn-link">100</button></span>
        <span class="text-left" style="font-size:smaller"><span>&nbsp;</span>Resultados</i>&nbsp;<em><?=$botao_mostrar?></em><span>&nbsp;</span>de&nbsp;<span><em><?=$quantidade_registros?></em></spam>
    </h5>

    <div>
        <div class="">
            <?php
            if (count($resultado_geral["buscar_arquivos"]) > 0) {
                foreach ($resultado_geral["buscar_arquivos"] as $item) {
            ?>
                    <button class="card col-xl-12 accordion-biblioteca accordion-multimidia card-header d-flex" id="accordion-biblioteca-<?= $item["acervo_id"] ?>">
                        <span class="badge rounded-pill" style="background-color:#fff;"></span><a target="arquivo_<?= $item["acervo_id"] ?>" href="<?= $item["link_editado"] ?>" id="accordion_biblioteca_<?= $item["acervo_id"] ?>">
                            <?= $item["titulo"] ?></a>
                            <p><em>Autor: <?=$item["autor"] ?></em><span class="font-weight-light" style="font-size:20px">&nbsp;&nbsp;Ano: <?=$item["ano"] ?></span></p>
                            <span class="font-weight-light" style="font-size:17px">Palavras-Chave: <?= $item["palavra_chave"] ?></p>
                        </button>
                    <div class="respostas visualizador vh-100" id="respostas_<?= $item["acervo_id"] ?>">
                    </div>
                    </br>
            <?php }
            } else{
            ?>
                    <button class="card col-xl-12 accordion-biblioteca accordion-multimidia card-header d-flex text-center">
                    <!-- <span class="badge rounded-pill" style="background-color:#fff;"> -->
                       Sem Registros
                       
                    </button>
            <?
            }?>
        </div>
    </div>
    <script type="text/javascript" src="biblioteca_.js"></script>
    <?php
								



    $pdo->commit();
	// echo json_encode($retorno);
} catch (Exception $e) {
	$pdo->rollback();
	// echo json_encode($retorno);
}
?>