
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
