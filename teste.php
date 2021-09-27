<?php

     

function plano_existe($cod_plano, $planos) {
    for ($i = 0; $i < count($planos); $i++) {
      if ($cod_plano === $planos[$i]["codigo"]){
        return true;
      }
    }
    return false;
  }
  
   function faixaIdade($idade) {
    switch ($idade) {
      case 0 <= $idade and $idade <= 17:
        return "faixa1";
        break;
      case  18 <= $idade and $idade <= 40:
        return "faixa2";
        break;
      case $idade > 40:
        return "faixa3";
      default:
        return "invalido";
        break;
    }
   
  }
  function obterValorBeneficio($precos, $faixa, $codigoPlano, $qtdeBeneficiarios) {
    for ($i = 0; $i < count($precos); $i++) {
      if ($codigoPlano === $precos[$i]["codigo"] and $qtdeBeneficiarios >= $precos[$i]["minimo_vidas"]) {
        $valorBeneficio = floatval($precos[$i][$faixa]);
      }
    }
    return $valorBeneficio;
  }
  
  
  //sei que não foi pedido  na lista de requisitos que deveriam ir  no codigo, mais essa foi de brinde XD
  function clearTela() {
    $so = PHP_OS;
    if ($so === "Windows") {
      system("cls");
    } else {
      system("clear");
    }
  }
  // fim da função do limpa tela
  
  
  function quit($key) {
    if ($key === "x") {
      return -1;
    }
  }

  function inicial() {
    echo"Cadastre aqui seu plano de saude se vc for novo por aqui...";
    echo"Para sair aperte o X e dê enter";
    $key = readline("pressione a tecla ENTER para continuar");
    return quit($key);
  }

  function saindo() {
    echo" Obrigado por usar o programa\n e volte sempre!!!!";
   
  }

  function main() {
    $json = file_get_contents("./planos.json");
    $planos = json_decode($json, true);

    $json = file_get_contents("./precos.json");
    $precos = json_decode($json, true);

    clearTela();
    
    $resultado = inicial();
    if ($resultado === -1) {
      return -1;
    }
    
    clearTela();

    $registroPlano = readline(": ");
    if (saindo($registroPlano) === -1) {
     return -1;
    }
    $registroPlano = intval($registroPlano);
    $planoExiste = plano_existe($registroPlano,$planos);
    
    
    while (!$planoExiste) {
      
      echo"Plano invalido";
      echo"Entre com o codigo de algum dos seguintes planos:";
      
        $comprimentoPlano = strlen($planos[0]["nome"]);
        $mask = "|%-{$comprimentoPlano}s |%-6s\n";
          printf($mask, 'Plano', 'codigo');
      
      
          for ($i = 0; $i < count($planos); $i++) { 
             printf($mask, $planos[$i]["nome"], $planos[$i]["codigo"]);
            }
      
            // entrada de dados
     
      
      $registroPlano = readline("Entre com o registro do plano desejado: ");
      if (saindo($registroPlano) === -1) {
        return -1;
      }
      
      $registroPlano = intval($registroPlano);
      $planoExiste = plano_existe($registroPlano,$planos);
    }

   clearTela();

    $qtdeBeneficiarios = readline("Entre com a quantidade de usuarios do plano: ");
    if (saindo($qtdeBeneficiarios) === -1){
      return -1;
    }
    while (!valor_valido($qtdeBeneficiarios)){
      $qtdeBeneficiarios = readline("Entre com um valor maior que 0 para a quantidade de usarios: ");
      if (saindo($qtdeBeneficiarios) === -1){
        return -1;
      }
    }
// final da entrada de dados.
    clearTela();

    $beneficiarios = [];
    $valorTotal = 0.0;
    $maiorNome = 5;
    for ($i = 1; $i <= $qtdeBeneficiarios; $i++) {
      $nomeBeneficiario = readline("Entre com o nome do usuário ".$i.": ");
      if (saindo($nomeBeneficiario) === -1){
        return -1;
      }
      if (strlen($nomeBeneficiario) > $maiorNome) {
        $maiorNome = strlen($nomeBeneficiario);
      }

      $idade = readline("Entre com a idade ".$i.": ");
      if (saindo($idade) === -1){
        return -1;
      }
      while (!valor_valido($idade)) {
        $idade= readline("Entre com um valor numerico maior que 0 para a idade do usuario a ser cadastrado ".$i.": ");
        if (saindo($idade) === -1){
          return -1;
        }
      }

     
      $faixaBeneficio = faixa_idade($idade);
      $precoBeneficio = obterValorBeneficiario($precos,$faixaBeneficio,$registroPlano,$qtdeBeneficiarios);
      $valorTotal += $precoBeneficiario;
      array_push($beneficiarios, [$nomeBeneficiario,$idade, $precoBeneficiario]);
    }

    echo"Valor total do plano ".$planos[$registroPlano-1]["nome"]." para ".$qbtdeBeneficiarios.":";
    echo"R$".number_format($valorTotal,2, ',','.')."\n";
    echo "Valor para cada usuario do plano";
    
    $mask = "|%-{$maiorNome}s |%-5s |%-5s \n";
    printf($mask, 'Nome', 'Idade', 'Valor para faixa de idade');
    for ($i = 0; $i < count($beneficiarios); $i++) { 
      printf($mask, $beneficiarios[$i][0], $beneficiarios[$i][1],"R$".number_format($beneficiarios[$i][2],2,',','.'));
    }
  }

  $resultado = main();
  if ($resultado === -1) {
    l;
   saindo();
  }