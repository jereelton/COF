<?php

session_start();

header("Content-Type: text/xml");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jun 2015 05:00:00 GMT");

if( isset( $_POST[ 'deletar_arquivo' ] ) && $_POST[ 'deletar_arquivo' ] <> "" ) {
	
	$nome_arquivo = strtolower( str_replace( " ", "_", trim( $_POST[ 'deletar_arquivo' ] ) ) );
	$retorno_xml  = deletar_arquivo_xml( $nome_arquivo );
	$xml          = "";
	$resposta     = "";
	
	if( $retorno_xml == false ) {
		
		$resposta = "falhou";
		
	} else {
		
		$resposta = "sucesso";
		
		}
		
	$xml  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$xml .= "<arquivo_deletado>\n";
	$xml .= "	<resposta>" .$resposta. "</resposta>\n";
	$xml .= "</arquivo_deletado>\n";
	
	echo $xml;

} else {
	
	echo "Erro na passagem dos parametros : _POST";
	
	}

function deletar_arquivo_xml( $nome_arquivo ) {
	
	if( isset($_SESSION[ 'nome_lista' ]) && $_SESSION[ 'nome_lista' ] == $nome_arquivo ) {
		
		# Tentando deletar arquivo que esta aberto, nao eh permitido !
		return false;
		
	}
	
	if( ! rename( "../listas/" . $nome_arquivo . ".xml", "../listas/removidos/" . $nome_arquivo . ".xml" ) ) {
		
		return false;
		
	}
	
	return true;
	
}

?>
