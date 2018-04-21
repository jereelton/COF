<?php

session_start();

header("Content-Type: text/xml");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jun 2015 05:00:00 GMT");

if( isset( $_POST[ 'pesquisar_produto' ] ) ) {
	
	$pesquisa = pesquisar_produto_xml( strtolower( trim( $_POST[ 'pesquisar_produto' ] ) ) );
	
	if( $pesquisa == false ) {
		
		$xml  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$xml .= "<retorno_pesquisa>\n";
		$xml .= "	<resposta>Nada encontrado</resposta>\n";
		$xml .= "</retorno_pesquisa>\n";
		
	} else {
		
		$xml  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$xml .= "<retorno_pesquisa>\n";
		
		foreach( $pesquisa as $item ) {
			
			$xml .= "	<resposta>" .$item. "</resposta>\n";
			
		}
		
		$xml .= "</retorno_pesquisa>\n";
		
	}
	
	echo $xml;

} else {
	
	die( "Erro na passagem dos parametros : _POST" );
	
	}
	
function pesquisar_produto_xml( $chave ) {
	
	// Uso de session para abrir o arquivo correto
	$nome_lista_xml = str_replace( " ", "_", trim( $_SESSION[ 'nome_lista' ] ) ).".xml";
	$array_xml      = simplexml_load_file( "../listas/".$nome_lista_xml );
	
	$index = 0;
	$array_info_produto = array();

	if( count( $array_xml -> produto ) > 0 ) {
		
		foreach( $array_xml -> produto as $atributos ) {
			
			// Se encontrar alguma ocorrencia da chave na string atributos->nome_produto
			if ( stristr( strtolower( $atributos -> nome_produto ) , $chave ) ) {
				
				$nome_produto   = strtolower( $atributos -> nome_produto );
				$qtde_produto   = $atributos -> qtde_produto;
				$preco_produto  = $atributos -> preco_produto;
				$total_produto  = $atributos -> total_produto;
				$indice_produto = $atributos -> indice_produto;
				
				$array_info_produto[ $index ] = $nome_produto.':'.$qtde_produto.':'.$preco_produto.':'.$total_produto.':'.$indice_produto;
				
				$index    += 1;
			
			}
			
		}
		
	}
	
	if( count( $array_info_produto ) > 0 ) {
		
		return $array_info_produto;
		
	} else {
	
		return false;
		
	}
	
}

?>
