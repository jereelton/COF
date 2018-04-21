<?php

# Obrigado PHP Brasil: criado por Claudio Diniz em 30/04/2002 3:26pm
# Use: formataReais("347,89", "67,12", "+");

function calcular_operacao_monetaria( $valor1, $valor2, $operacao ) {
	
	// Antes de tudo , arrancamos os "," e os "." dos dois valores passados a função . Para isso , podemos usar str_replace :
	$valor1 = str_replace (".", "", $valor1);
	$valor1 = str_replace (",", ".", $valor1);
	
	$valor2 = str_replace (".", "", $valor2);
	$valor2 = str_replace (",", ".", $valor2);
	
	// Agora vamos usar um switch para determinar qual o tipo de operação que foi definida :
	switch ( $operacao ) {
		
		// Adição :
		case "+":
			$resultado = $valor1 + $valor2;
			break;
			
		// Subtração :
		case "-":
			$resultado = $valor1 - $valor2;
			break;
			
		// Multiplicação :
		case "*":
			$resultado = $valor1 * $valor2;
			break;
			
	} // Fim Switch
	
	$retorna = number_format( $resultado, 2, ",", ".");
	
	// Por fim , retorna o resultado já formatado
	return $retorna;
	
} // Fim da function

?>
