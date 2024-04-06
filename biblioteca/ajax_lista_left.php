<?php
                    // chamar o arquivo de fun��es
require_once "../src/tecnico/conf/constantesBanco.php";
require_once "../src/tecnico/conf/funcoesSemSession.php";
require_once PATH_CLASSES . "Biblioteca2.php";


$retorno['sucesso'] = false;
$retorno['mensagem'] = toUtf("Erro ao inserir");
$retorno['debug'] = "";

if ((!is_null(safepost('tipo_material_id'))) && (safepost('tipo_material_id') != "")) {
	$tipo_material_id = safepost('tipo_material_id');
} else {
	$tipo_material_id = "";
}
if ((!is_null(safepost('nivel_2'))) && (safepost('nivel_2') != "")) {
	$nivel_2 = safepost('nivel_2');
} else {
	$nivel_2 = 0;
}

try {
	if($nivel_2 == 0){
		$pesquisa_com_item = new Biblioteca2($pdo);
		$resultado_geral = $pesquisa_com_item->BuscarTitulosPorTipoMaterialId($tipo_material_id);
		$retorno_dados = array();
		$retorno_dados['buscar_autocomplete'] = array();
	}else{
		$pesquisa_com_item = new Biblioteca2($pdo);
		$resultado_geral = $pesquisa_com_item->BuscarTitulosPorTipoMaterialIdNivel2($tipo_material_id, $nivel_2);
		$retorno_dados = array();
		$retorno_dados['buscar_autocomplete'] = array();
	}

    foreach ($resultado_geral as $key => $valor) {
		// if ($valor['cpf'] != '') {
		// 	# code...
		// 	$complemento = " - CPF:{$valor['cpf']}";
		// } else {
		// 	$complemento = " - CNPJ:{$valor['cnpj']}";
		// }
		$retorno_dados['buscar_autocomplete'][$key] = [

			'acervo_id' => toUtf($valor['acervo_id']),
			'label' => toUtf($valor['titulo'] ),
            'link' => toUtf($valor['link_documento'] )
		];
	}
	// echo "<pre>";

} catch (Exception $e) {

}
echo json_encode($retorno_dados['buscar_autocomplete']);
?>