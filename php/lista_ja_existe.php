<?php

session_start();

header("Content-Type: text/xml");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jun 2015 05:00:00 GMT");

if( isset( $_POST[ 'lista_ja_existe' ] ) && $_POST[ 'lista_ja_existe' ] <> "" ) {
	
	$nome_lista  = strtolower( str_replace( " ", "_", trim( $_POST[ 'lista_ja_existe' ] ) ) );
	$resposta    = "nao";
	
	if( file_exists( "../listas/" . $nome_lista . ".xml" ) ) {
		
		$resposta = "sim";
	}
	
	$xml  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$xml .= "<lista_existe>\n";
	$xml .= "	<resposta>" .$resposta. "</resposta>\n";
	$xml .= "</lista_existe>\n";
	
	echo $xml;

} else {
	
	echo "Erro na passagem dos parametros : _POST";
	
	}

?>
