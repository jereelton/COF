<?php

session_start();

header("Content-Type: text/xml");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jun 2015 05:00:00 GMT");

if( isset( $_POST[ 'carregar_listas_salvas' ] ) && $_POST[ 'carregar_listas_salvas' ] == "carregarListasXml" ) {
	
	$retorno_xml = carregar_listas_salvas();
	
	if( $retorno_xml <> false ) {
		
		echo $retorno_xml;
		
	} else {
		
		$retorno_xml  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$retorno_xml .= "<lista_listas_salvas>\n";
		$retorno_xml .= "	<lista_xml_salva>\n";
		$retorno_xml .= "		<acessar_lista>Nada encontrado</acessar_lista>\n";
		$retorno_xml .= "		<nome_lista></nome_lista>\n";
		$retorno_xml .= "		<qtde_itens></qtde_itens>\n";
		$retorno_xml .= "		<total_compra></total_compra>\n";
		$retorno_xml .= "		<limite_compra></limite_compra>\n";
		$retorno_xml .= "		<saldo_compra></saldo_compra>\n";
		$retorno_xml .= "		<xxx_compra></xxx_compra>\n";
		$retorno_xml .= "	</lista_xml_salva>\n";
		$retorno_xml .= "</lista_listas_salvas>\n";
		
		echo $retorno_xml;
		
	}

} else {
	
	die( "Erro na passagem dos parametros : _POST" );
	
	}

function carregar_listas_salvas() {
	
	$local_listas  = "../listas";
	$listas_salvas = glob( $local_listas . "/*.xml", GLOB_BRACE );
	
	if( count( $listas_salvas ) < 1 ) {
		
		return false;
		
	}
	
	rsort( $listas_salvas );
	
	// Inicia o conteudo xml
	$conteudo_xml   = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$conteudo_xml  .= "<lista_listas_salvas>\n";
	
	foreach( $listas_salvas as $lista ) {
		
		$url_lista     = $lista;
		$acessar_lista = str_replace( ".xml" , "", basename( $url_lista ) );
		$nome_lista    = str_replace( "_" , " ", basename( $url_lista ) );
		$nome_lista    = str_replace( ".xml" , " ", $nome_lista );
		$array_xml     = simplexml_load_file( $url_lista );
		
		$qtde_itens    = "";
		$total_compra  = "";
		$limite_compra = "";
		$saldo_compra  = "";
		$xxx_compra    = "";
		
		foreach( $array_xml -> saldos as $item ) {
			
			#$item -> total_compra;
			#$item -> saldo_compra;
			#$item -> qtde_itens;
			#$item -> dinheiro_aplicado;
			
			$qtde_itens    = $item -> qtde_itens;
			$total_compra  = $item -> total_compra;
			$limite_compra = $item -> dinheiro_aplicado;
			$saldo_compra  = $item -> saldo_compra;
			$xxx_compra    = "0,00";
			
		}
		
		$conteudo_xml .= "	<lista_xml_salva>\n";
		$conteudo_xml .= "		<acessar_lista>" . $acessar_lista . "</acessar_lista>\n";
		$conteudo_xml .= "		<nome_lista>"    . $nome_lista    . "</nome_lista>\n";
		$conteudo_xml .= "		<qtde_itens>"    . $qtde_itens    . "</qtde_itens>\n";
		$conteudo_xml .= "		<total_compra>"  . $total_compra  . "</total_compra>\n";
		$conteudo_xml .= "		<limite_compra>" . $limite_compra . "</limite_compra>\n";
		$conteudo_xml .= "		<saldo_compra>"  . $saldo_compra  . "</saldo_compra>\n";
		$conteudo_xml .= "		<xxx_compra>"    . $xxx_compra    . "</xxx_compra>\n";
		$conteudo_xml .= "	</lista_xml_salva>\n";
	
	}
	
	$conteudo_xml .= "</lista_listas_salvas>\n";
	
	return $conteudo_xml;
	
}

?>

