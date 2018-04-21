<?php

session_start();

header("Content-Type: text/xml");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jun 2015 05:00:00 GMT");

if( isset( $_POST[ 'criar_nova_lista' ] ) ) {
	
	$nome_lista  = strtolower( str_replace( " ", "_", trim( $_POST[ 'criar_nova_lista' ] ) ) );
	$retorno_xml = criar_arquivo_xml( $nome_lista );
	$xml         = "";
	$resposta    = "";
	
	if( $retorno_xml == false ) {
		
		$resposta = "falhou";
		
	} else {
		
		$resposta = "sucesso";
		$_SESSION[ 'nome_lista' ] = $nome_lista;
		
		}
		
	$xml  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$xml .= "<lista_criada>\n";
	$xml .= "	<resposta>" .$resposta. "</resposta>\n";
	$xml .= "</lista_criada>\n";
	
	echo $xml;

} else {
	
	echo "Erro na passagem dos parametros : _POST";
	
	}

function criar_arquivo_xml( $nome_lista ) {
	
	$arquivo_xml = fopen( "../listas/" . $nome_lista . ".xml", "w+" );
	
	$conteudo_xml   = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$conteudo_xml  .= "<lista_produtos>\n";
	$conteudo_xml .= "	<saldos>\n";
	$conteudo_xml .= "		<total_compra>0,00</total_compra>\n";
	$conteudo_xml .= "		<saldo_compra>0,00</saldo_compra>\n";
	$conteudo_xml .= "		<qtde_itens>0</qtde_itens>\n";
	$conteudo_xml .= "		<dinheiro_aplicado>0,00</dinheiro_aplicado>\n";
	$conteudo_xml .= "		<contador>1</contador>\n";
	$conteudo_xml .= "	</saldos>\n";
	$conteudo_xml .= "	<recurso>\n";
	$conteudo_xml .= "	</recurso>\n";
	$conteudo_xml .= "</lista_produtos>\n";
	
	if( ! fwrite( $arquivo_xml, $conteudo_xml ) ) {
		
		return false;
		
	}
	
	// Este comando nao funciona caso nao seja root
	//chmod( "../listas/" . $nome_lista . ".xml", 0755 );
	
	fclose( $arquivo_xml );
	
	return true;
	
}

?>
