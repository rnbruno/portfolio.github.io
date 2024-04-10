

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


