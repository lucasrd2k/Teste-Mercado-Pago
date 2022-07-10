<h1>Este formulário está configurado paa gerar o link para um produto</h1>
<h2>*Para testar digite as informações*</h2>
<h3>**Tem formas de adicionar mais de um item, o Mercado pago soma e cobra o valor total**</h3>
<h4>Os exemplos em mysqli são simples, apenas para ilustração</h4>
<form method="POST" action="">
    Nome:<br><input name="nome"><br>
    Preço:<br><input name="preco"><br>
    Quantidade:<br><input name="quantidade"><br>
    <input type="submit">
</form>


<?php
    /**
     * Aqui pode ser uma busca no banco e pegamos o token de acesso do vendedor
     * Preencher a variável $acess_token
     */
/*
    include "../../conexao.php";

    $id = $_SESSION['id'];
    $sql = "SELECT acess_token FROM vendedor WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result)){
        $linha = mysqli_fetch_array($result);
        $acess_token = $linha['acess_token'];    
    }
*/

    if (isset($_POST['preco'])){

        $acess_token = "SEU ACESS TOKEN";
        
    require_once "vendor/autoload.php";

    MercadoPago\SDK::setAccessToken($acess_token);
    
    $preference = new MercadoPago\Preference();
    
    /**
     * Teste comentado com mais de um produto 
     * 
     */
/*
$vetor = [
        array( 
            "nome"=>"Produto 1",
        "preco"=>23.20,
        "quantidade"=>2
    ),
    array(
        "nome"=>"Produto 2",
            "preco"=>70.00,
            "quantidade"=>1
        )]; //Esse vetor representa os produtos recebidos na hora do pagamento
        
        $items = array();
        
      for ($x = 0;$x<sizeof($vetor);$x++){
              $item = new MercadoPago\Item();
          
              $item->title = $vetor[$x]["nome"];
          
              $item->quantity = $vetor[$x]["quantidade"];
              
              $item->unit_price = (double)$vetor[$x]["preco"];
              
              $items[] = $item;
            }
  */  
  
  $item = new MercadoPago\Item();
            
  $item->title = $_POST["nome"];

  $item->quantity = $_POST["quantidade"];
  
  $item->unit_price = (double)$_POST["preco"];
  
  
  
  $preference->items = array($item);
  //var_dump($preference->items);
  //$preference->items[] = array($items[0]);
  /**
   * Front-End: Página com as 3 respostas possíveis pra adicionar nesses links
   */
  
  
  $preference->back_urls = array(
      "success"=>"http://localhost/App/Teste%20Mercado%20Pago/aviso.php", //Link de sucesso
      "failure"=>"http://localhost/App/Teste%20Mercado%20Pago/aviso.php", //Link de falha
      "pending"=>"http://localhost/App/Teste%20Mercado%20Pago/aviso.php"  //Link de pendente/em confirmação
    );
    
    $preference->notification_url = "http://localhost/App/Teste%20Mercado%20Pago/aviso.php";  //Link (do seu site) aviso pro vendedor que a compra ocorreu
        
        $preference->external_reference = 55; //"Identificação do produto que foi vendido (id no sistema)"; 
        
        $preference->save();
        
        $link = $preference->init_point; //Link que o Mercado Pago retorna
        
        echo $link; //Redirecionar para esse link para concluir
    }
?>