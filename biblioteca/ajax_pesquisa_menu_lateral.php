
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
								

?>