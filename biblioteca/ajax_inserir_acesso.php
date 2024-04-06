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
if ((!is_null(safepost('tipo'))) && (safepost('tipo') != "")) {
	$tipo = safepost('tipo');
} else {
	$tipo = "";
}

function get_client_ip_env()
{
	$ipaddress = '';
	if (getenv('HTTP_CLIENT_IP'))
		$ipaddress = getenv('HTTP_CLIENT_IP');
	else if (getenv('HTTP_X_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	else if (getenv('HTTP_X_FORWARDED'))
		$ipaddress = getenv('HTTP_X_FORWARDED');
	else if (getenv('HTTP_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_FORWARDED_FOR');
	else if (getenv('HTTP_FORWARDED'))
		$ipaddress = getenv('HTTP_FORWARDED');
	else if (getenv('REMOTE_ADDR'))
		$ipaddress = getenv('REMOTE_ADDR');
	else
		$ipaddress = 'UNKNOWN';

	return $ipaddress;
}
$ip2 = get_client_ip_env();

try {
	if($tipo==1){
		$pesquisa_com_item = new Biblioteca2($pdo);
		$resultado_geral = $pesquisa_com_item->acessoAcervo($acervo_id, $ip2);
	}else if($tipo ==2){
		$pesquisa_com_item = new Biblioteca2($pdo);
		$resultado_geral = $pesquisa_com_item->AcessoBibliotecaExterna($ip2);
	}

} catch (Exception $e) {
}

