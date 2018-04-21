<?php

session_start();

header("Content-Type: text/xml");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jun 2015 05:00:00 GMT");

include("log.php");
include("calculo_monetario_full.php");

if( isset( $_POST[ 'aplicar_dinheiro' ] ) ) {
	
	# params = "aplicar_dinheiro=" + total_compra + ":" + valor_recurso_aplicado + ":" + id_recurso_aplicado + ":" + total_recursos_atuais;;
	
	log_sistema( "----------------------------------------------------------------" );
	log_sistema( "[ Aplicar Recurso ]" );
	log_sistema( "Dados Recebidos: " . $_POST[ 'aplicar_dinheiro' ] );
	
	$processar_info  = explode( ":", trim( $_POST[ 'aplicar_dinheiro' ] ) );
	
	# TOTAL ATUAL DA COMPRA
	$total_atual_compra = trim( $processar_info[0] );
	
	log_sistema( "Total Atual Compra: " . $total_atual_compra );
	
	$valor_recurso_aplicado = trim( $processar_info[1] ); # VALOR DO RECURSO APLICADO
	
	$id_recurso_aplicado    = trim( $processar_info[2] ); # NOME DO RECURSO APLICADO
	
	$total_recursos_atuais  = trim( $processar_info[3] ); # TOTAL ATUAL DE RECURSOS
	
	log_sistema( "Novo Recurso Aplicado: " . $valor_recurso_aplicado );
	
	# RECURSOS ATUAIS + RECURSO APLICADO
	$recurso_total = calcular_operacao_monetaria( $total_recursos_atuais, $valor_recurso_aplicado, "+" );
	
	# NOVO SALDO COMPRA
	$novo_saldo_compra = calcular_operacao_monetaria( $recurso_total, $total_atual_compra, "-" );
	
	log_sistema( "Novo Saldo Compra: " . $novo_saldo_compra );
	
	# GERAR O XML RESPONSE PARA VISUALIZAR PELO JS E HTML
	$xml_response  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$xml_response .= "<calculos_compra>\n";
	$xml_response .= "	<saldo_compra>" .$novo_saldo_compra. "</saldo_compra>\n";
	$xml_response .= "	<recurso_total>" .$recurso_total. "</recurso_total>\n";
	$xml_response .= "</calculos_compra>\n";
	
	echo $xml_response;
	
}

?>
