<?php

session_start();

header("Content-Type: text/xml");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jun 2015 05:00:00 GMT");

include("log.php");
include("calculo_monetario_full.php");

if( isset( $_POST[ 'remover_produto' ] ) ) {
	
	log_sistema( "----------------------------------------------------------------" );
	log_sistema( "[ Remover Produto ]" );
	log_sistema( "Dados Recebidos: " . $_POST[ 'remover_produto' ] );
	
	$processar_info         = explode( ":", trim( $_POST[ 'remover_produto' ] ) );
	
	# DINHEIRO ATUAL APLICADO
	$dinheiro_atual_aplicado = trim( $processar_info[1] );
	
	log_sistema( "Dinheiro Atual Aplicado: " . $dinheiro_atual_aplicado );
	
	# TOTAL ATUAL COMPRA
	$total_atual_compra = trim( $processar_info[2] );
	
	log_sistema( "Total Atual Compra: " . $total_atual_compra );
	
	# SALDO ATUAL COMPRA
	$saldo_atual_compra = calcular_operacao_monetaria( $dinheiro_atual_aplicado, $total_atual_compra, "-" );
	
	log_sistema( "Saldo Atual Compra: " . $saldo_atual_compra );
	
	# TOTAL ATUAL PRODUTO
	$total_atual_produto = trim( $processar_info[0] );
	
	log_sistema( "Total Atual Produto: " . $total_atual_produto );
	
	# QTDE ATUAL DE ITENS
	$qtde_atual_itens = trim( $processar_info[4] );
	
	log_sistema( "Qtde Atual Itens: " . $qtde_atual_itens );
	
	# NOVA QTDE DE ITENS
	$nova_qtde_itens = $qtde_atual_itens - 1;
	
	if($nova_qtde_itens < 0) { $nova_qtde_itens = 0; }
	
	log_sistema( "Nova Qtde Itens: " . $nova_qtde_itens );
	
	# NOVO TOTAL COMPRA
	$novo_total_compra = calcular_operacao_monetaria( $total_atual_compra,  $total_atual_produto, "-" );
	
	log_sistema( "Novo total Compra: " . $novo_total_compra );
	
	# NOVO SALDO COMPRA
	$novo_saldo_compra = calcular_operacao_monetaria( $dinheiro_atual_aplicado, $novo_total_compra, "-" );
	
	log_sistema( "Novo Saldo Compra: " . $novo_saldo_compra );
	
	# GERAR O XML RESPONSE PARA VISUALIZAR PELO JS E HTML
	$xml_response  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$xml_response .= "<calculos_compra>\n";
	$xml_response .= "	<novo_total_compra>" .$novo_total_compra. "</novo_total_compra>\n";
	$xml_response .= "	<nova_qtde_itens>"   .$nova_qtde_itens.   "</nova_qtde_itens>\n";
	$xml_response .= "	<novo_saldo_compra>" .$novo_saldo_compra. "</novo_saldo_compra>\n";
	$xml_response .= "</calculos_compra>\n";
	
	echo $xml_response;
	
}

?>
