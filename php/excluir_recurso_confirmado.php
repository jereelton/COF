<?php

session_start();

header("Content-Type: text/xml");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jun 2015 05:00:00 GMT");

include("calculo_monetario_full.php");

/* Parametros: deletar_recurso,valor_recurso,total_recursos,total_compra,saldo_atual,recursos_guardados */

if( 
	isset( $_POST[ 'deletar_recurso'    ] ) && $_POST[ 'deletar_recurso'    ] <> "" && 
	isset( $_POST[ 'valor_recurso'      ] ) && $_POST[ 'valor_recurso'      ] <> "" &&
	isset( $_POST[ 'total_recursos'     ] ) && $_POST[ 'total_recursos'     ] <> "" &&
	isset( $_POST[ 'total_compra'       ] ) && $_POST[ 'total_compra'       ] <> "" &&
	isset( $_POST[ 'saldo_atual'        ] ) && $_POST[ 'saldo_atual'        ] <> "" &&
	isset( $_POST[ 'recursos_guardados' ] ) && $_POST[ 'recursos_guardados' ] <> "" ) {
	
	$nome_recurso       = trim( $_POST[ 'deletar_recurso'    ] );
	$valor_recurso      = trim( $_POST[ 'valor_recurso'      ] );
	$total_recursos     = trim( $_POST[ 'total_recursos'     ] );
	$total_compra       = trim( $_POST[ 'total_compra'       ] );
	$saldo_atual        = trim( $_POST[ 'saldo_atual'        ] );
	$recursos_guardados = trim( $_POST[ 'recursos_guardados' ] );
	
	$retorno_xml        = calcular_remocao_recurso( 
												$nome_recurso, 
												$valor_recurso,
												$total_recursos,
												$total_compra,
												$saldo_atual,
												$recursos_guardados
											);
											
	echo $retorno_xml;

} else {
	
	echo "Erro na passagem dos parametros : _POST";
	
	}

function calcular_remocao_recurso( $nome_recurso, $valor_recurso, $total_recursos, $total_compra, $saldo_atual, $recursos_guardados ) {
	
	# Sessao invalida, nao eh permitido operar nestas condicoes
	if( ! isset($_SESSION[ 'nome_lista' ]) || $_SESSION[ 'nome_lista' ] == "" ) {
		
		$retorno_xml  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$retorno_xml .= "<recurso_deletado>\n";
		$retorno_xml .= "	<resposta>falhou</resposta>\n";
		$retorno_xml .= "</recurso_deletado>\n";
		
		return $retorno_xml;
		
	}
	
	// Retirando o recurso da lista de recursos guardados
	$novo_recursos_guardados = str_replace( $nome_recurso.":".$valor_recurso.";", "", $recursos_guardados);
	
	// Calculo de novo recurso aplicado (recurso_total)
	$novo_recurso_total = calcular_operacao_monetaria( $total_recursos, $valor_recurso, "-" );
	
	// Novo saldo com base no novo recurso total e no total da compra
	$novo_saldo_compra = calcular_operacao_monetaria( $novo_recurso_total, $total_compra, "-" );
	
	$retorno_xml  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$retorno_xml .= "<recurso_deletado>\n";
	$retorno_xml .= "	<resposta>sucesso</resposta>\n";
	$retorno_xml .= "	<novo_saldo_compra>"       . $novo_saldo_compra       . "</novo_saldo_compra>\n";
	$retorno_xml .= "	<novo_recurso_total>"      . $novo_recurso_total      . "</novo_recurso_total>\n";
	$retorno_xml .= "	<novo_recursos_guardados>" . $novo_recursos_guardados . "</novo_recursos_guardados>\n";
	$retorno_xml .= "</recurso_deletado>\n";
	
	return $retorno_xml;
	
}

?>
