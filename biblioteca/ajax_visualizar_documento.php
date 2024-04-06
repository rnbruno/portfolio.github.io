<?php
                    // chamar o arquivo de funções
require_once "../src/tecnico/conf/constantesBanco.php";
require_once "../src/tecnico/conf/funcoesSemSession.php";
require_once PATH_CLASSES . "Biblioteca2.php";


$retorno['sucesso'] = false;
$retorno['mensagem'] = toUtf("Erro ao inserir");
$retorno['debug'] = "";

if ((!is_null(safepost('acervo_id'))) && (safepost('acervo_id') != "")) {
	$acervo_id = safepost('acervo_id');
} else {
	$acervo_id = "";
}

try {
	$pesquisa_com_item = new Biblioteca2($pdo);
	$resultado_geral = $pesquisa_com_item->BuscarTitulosPorAcervoId($acervo_id);
    $retorno_dados = array();
	$retorno_dados['buscar_autocomplete'] = array();

    foreach ($resultado_geral as $key => $valor) {

		$retorno_dados['buscar_autocomplete'] = [

			'acervo_id' => toUtf($valor['acervo_id']),
			'label' => toUtf($valor['titulo'] ),
			'tipo_link' => toUtf($valor['tipo_link'] ),
			'descricao_n2' => toUtf($valor['descricao_n2'] ),
			'descricao' => toUtf($valor['descricao'] ),
			'autor' => toUtf($valor['autor'] ),
			'ano' => toUtf($valor['ano'] ),
			'palavra_chave' => toUtf($valor['palavra_chave'] ),
	        'link' => toUtf(DOCUMENTOS_URL. "biblioteca". DIRECTORY_SEPARATOR. $valor['link_documento'] )
		];
	}


} catch (Exception $e) {

}
echo json_encode($retorno_dados['buscar_autocomplete']);
?>