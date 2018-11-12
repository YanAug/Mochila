<?php error_reporting(0)  ?>
<html>
<style>
    body{
        background-color: #eee !important;
        margin: auto 10px;
        width: auto;
    }
    .form-group{
        margin-bottom: 15px !important;
    }
    .no-padding {
        padding: 0 !important;
        padding-right: 15px !important;
    }
    .table{
        font-size: 14px;
    }
    input#valor {
        font-weight: 100;
    }
    input#peso {
        font-weight: 100;
    }
    input#capacidade {
        min-width: 287px;
    }
</style>
<head>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <script src="dynamic_forms.js"></script>
  <script>

      $(document).ready(function () {
        var dynamicForms = new DynamicForms();
        dynamicForms.automaticallySetupForm();
      });
  </script>

</head>
    <body>
        <div class="container">
              <div class="row">
                <form action="index.php">
                  <div class="row">
                    <h2>Problema da Mochila</h2>
                    <br>
                    <div class="col-xs-3 no-padding">
                        <div class="form-group">
                            <label for="capacidade">Capacidade da mochila (peso máximo):</label>
                            <input type="number" name="capacidade" class="form-control" id="capacidade" min="1" step="1">
                        </div>
                    </div>
                    <div class="col-xs-12 no-padding" data-dynamic-form>
                       <div class="row">
                          <div class="col-xs-12 form-group" data-dynamic-form-template="multi">
                              <label>

                                <div class="col-xs-4 no-padding">
                                  <input type="number" class="col-xs-2 form-control" id="valor" min="0" placeholder="Valor"
                                  name="multi[ID][valor]" data-dynamic-form-input-id-template="ID"/>
                                </div>

                                <div class="col-xs-4 no-padding">
                                  <input type="number" class="col-xs-4 form-control" id="peso" value="1" min="1" placeholder="Peso"
                                  name="multi[ID][peso]" data-dynamic-form-input-id-template="ID"/>
                                </div>

                                  <button class="btn btn-primary" type="button" data-dynamic-form-add>Adicionar item</button>
                                  <button class="btn btn-danger" type="button" data-dynamic-form-remove>Remover item</button>
                              </label>
                          </div>
                       </div>
                    </div>
                    <div class="col-xs-12 no-padding">
                      <a href="index.php" class="btn btn-danger">Resetar</a>
                      <input type="submit" class="btn btn-success" value="Enviar">
                    </div>
                  </div>
                </form>
                <?= mochilaGulosa(); ?>
                <?php
                    $j = 0;
                    $matriz = NULL;
                    $matriz[count( $_GET['multi'])][$_GET['capacidade']];
                    foreach ($_GET['multi'] as $key => $item) {
                        for($i = 0; $i <= $_GET['capacidade']; $i++){
                            $matriz[$j][$i] = calcularMatriz($matriz, $item, $i, $j);
                        }
                        $j++;
                    }
                    print_r(mochilaDinamica($matriz));
                    retornarItensDaMochilaDinamica($matriz);

                ?>

        </div>
    </body>
</html>
<?php

    //variável para salvar o GET
    $getVars = $_GET;

    //salvar os itens a serem inseridos na mochila, contidos no array multi, para a variável $itensASeremInseridos
    $itensASeremInseridos = $getVars['multi'];

    function mochilaGulosa(){
        //contador
        $i = 0;

        $getVars = $_GET;

        $itensASeremInseridos = $getVars['multi'];

        //array para salvar os itens que são inseridos dentro da mochila
        $mochila = array();
        while (retornaOQueEstaSobrando($mochila, $_GET['multi']) > 0 && $i < count( $_GET['multi'])){
          $variavel = maiorValor($itensASeremInseridos);
          if ($itensASeremInseridos[$variavel]['peso'] <= retornaOQueEstaSobrando($mochila, $_GET['multi'])){
            //adiciona na mochila o item
            $mochila[] = $variavel;
          }
          //remove do array de itens a serem inseridos o item adicionado na mochila
          unset($itensASeremInseridos[$variavel]);
          $i++;
        }

        if (isset($_GET['capacidade'])){
            echo '<br>';
            if (!$mochila == NULL){
            echo '<div class="col-xs-12 col-md-6 no-padding">';
            echo '<h4>Resolução por algoritmo guloso</h4>';
            echo '<h5>(adiciona os itens de maior valor)</h5>';
            echo '<br>';
            echo 'A capacidade da mochila é de: <b>';
            echo ($_GET['capacidade']) . " kilos imaginários (ki)</b>.";
            echo '<br>';
            echo '<br>';
            echo 'Os itens que foram inseridos na mochila foram: ';
            }
            else echo 'Nenhum item foi inserido na mochila, preencha os campos acima e tente novamente, atentando ao peso máximo da mochila.';
            echo '<br>';
            echo '<br>';
            $i = 1;
            foreach ($mochila as $key => $item){
               echo '#<b>Item '. $i .'</b>, de valor ';
               echo '<b>$';
               echo $_GET['multi'][$item]['valor'];
               echo '</b>';
               echo ' e peso ';
               echo '<b>';
               echo $_GET['multi'][$item]['peso'];
               echo ' ki</b>';
               echo '<br>';
               $i++;
            }
            echo '</div>';
        }
    }

    function arrayDinamico(){
        return 0;
    }

    function mochilaDinamica($matriz){
        echo '<div class="col-xs-12 col-md-12 no-padding">';
        echo '<br>';
        echo '<br>';
        echo '<h4>Resolução por algoritmo dinâmico</h4>';
        echo '<br>';
        $i = 0;

        echo "<table class='table table-bordered table-striped'>";
            echo "<thead>";
                echo "<tr>";
                    echo "<th>Valor</th>";
                    echo "<th>Peso</th>";
                while ($_GET['capacidade'] >= $i){
                    echo "<th>". $i++ ."</th>";
                }
                echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
                $i = 0;
                    foreach ($_GET['multi'] as $key => $item) {
                      echo "<tr>";
                          echo"<td>" .$item['valor'] ."</td>";
                          echo"<td>" .$item['peso'] ."</td>";
                          foreach($matriz[$i] as $valor)
                              echo "<td>". $valor ."</td>";
                      echo "</tr>";
                      $i++;
                    }
            echo "</tbody>";
        echo "</table>";
    }

    function pegarItem($itens, $id){
        $i = 0;
        foreach ($itens as $key => $item) {
            if($i == $id){
                return $item;
            }
            $i++;
        }
    }

    function retornarItensDaMochilaDinamica($matriz){

          $linha = count($matriz)-1;
          $coluna = count($matriz[0])-1;
          // echo $linha . ' ' . $coluna;
          $i = 1;
          echo 'Os itens que foram inseridos na mochila foram: ';
          echo "<br>";
          echo "<br>";
          while($linha >= 0){
              if($linha == 0){
                  $item = pegarItem($_GET['multi'],$linha);
                      echo "#<b>Item " .$i ."</b>, de valor <b>$" .$item['valor'] ."</b> e de peso <b>" .$item['peso'] ." ki</b>";

                  break;
              }
              if($matriz[$linha][$coluna] != $matriz[$linha-1][$coluna]){
                  $item = pegarItem($_GET['multi'],$linha);
                      echo "<b>#Item " .$i ."</b>, de valor <b>$" .$item['valor'] ."</b> e de peso <b>" .$item['peso'] ." ki</b>";
                      echo "<br>";
                  $i++;
                  $linha--;
                  $coluna = $coluna - $item['peso'];
              }
              else $linha --;

          }

    }

    //função para descobrir o item de maior valor dentro da mochila em um determinado momento
    function maiorValor($itensASeremInseridos){
        $variavelQueSalvaAKey = NULL;
        $maisCaro = 0;
        foreach($itensASeremInseridos as $key => $item){

            if ($item['valor'] > $maisCaro){
                $maisCaro = $item['valor'];
                $variavelQueSalvaAKey = $key;
            }
        }
        return $variavelQueSalvaAKey;
    }

    //função para retornar a capacidade(peso) ainda disponível da mochila
    function retornaOQueEstaSobrando($itensDentroDaMochila,$itensASeremInseridos){
        $pesoMax = $_GET['capacidade'];
        $aux = 0;
        foreach ($itensDentroDaMochila as $key => $item){
            $aux = $itensASeremInseridos[$item]['peso'] + $aux;
        }
        $pesoSobrando = $pesoMax - $aux;
        return $pesoSobrando;
    }

    function calcularMatriz($matriz, $item, $tamanho, $linha){

        if($tamanho == 0){
            return 0;
        }
        if($linha == 0){
            // se couber um item
            if($item['peso'] <= $tamanho){
                return $item['valor'];
            }
            else return 0;
        }
        if($item['peso'] <= $tamanho){
            $indice = $tamanho - $item['peso'];
            $resultado = (($matriz[$linha-1][$indice]) + $item['valor']);
            if ($resultado > $matriz[$linha-1][$tamanho])
                return $resultado;
            else return $matriz[$linha-1][$tamanho];
        }
        else return $matriz[$linha-1][$tamanho];

    }

?>
