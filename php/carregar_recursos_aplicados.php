<?php

session_start();

header("Content-Type: text/xml");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jun 2015 05:00:00 GMT");

if( isset( $_POST[ 'carregar_recursos_aplicados' ] ) && $_POST[ 'carregar_recursos_aplicados' ] == "carregarRecursosXml" ) {
	
	$retorno_xml = carregar_recursos_salvos();
	
	if( $retorno_xml <> false ) {
		
		echo $retorno_xml;
		
	} else {
		
		$retorno_xml  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$retorno_xml .= "<recursos_aplicados\n";
		$retorno_xml .= "	<recurso>\n";
		$retorno_xml .= "		<nome>Nada encontrado</nome>\n";
		$retorno_xml .= "		<valor>0,00</valor>\n";
		$retorno_xml .= "	</recurso>\n";
		$retorno_xml .= "</recursos_aplicados>\n";
		
		echo $retorno_xml;
		
	}

} else {
	
	die( "Erro na passagem dos parametros : _POST" );
	
	}

function carregar_recursos_salvos() {
	
	$local_listas = "../listas";
	$lista_aberta = $local_listas . "/" . $_SESSION[ 'nome_lista' ] . ".xml";
	
	// Inicia o conteudo xml
	$conteudo_xml   = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$conteudo_xml  .= "<recursos_aplicados>\n";
	
	$array_recursos_xml = simplexml_load_file( $lista_aberta );
	
	foreach( $array_recursos_xml -> recurso as $item ) {
		
		#$item -> nome;
		#$item -> valor;
		
		$nome_recurso  = $item -> nome;
		$valor_recurso = $item -> valor;
		
		$conteudo_xml .= "	<recurso>\n";
		$conteudo_xml .= "		<nome>"  . $nome_recurso  . "</nome>\n";
		$conteudo_xml .= "		<valor>" . $valor_recurso . "</valor>\n";
		$conteudo_xml .= "	</recurso>\n";
		
	}
	
	$conteudo_xml .= "</recursos_aplicados>\n";
	
	return $conteudo_xml;
	
}

?>

