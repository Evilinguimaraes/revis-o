<?php

//pegando os dados das pastas
require_once('classes/Crud.php'); // É idêntica a require exceto que o PHP verificará se o arquivo já foi incluído, e em caso afirmativo, não o incluirá (exigirá) novamente.
require_once('Conexao/conexao.php');

//criando uma variável
$database = new Database();
$db = $database->getConnection();//cria uma conexão com o banco de dados.
$crud = new Crud($db);

if(isset($_GET['action'])){//verifica se o parâmetro 'action' está presente na URL da requisição.
    switch($_GET['action']){//inicia um bloco switch baseado no valor do parâmetro 'action' na URL.
        case 'create'://cria algum objeto ou algo no banco de dados.
            $crud->create($_POST);//é usado para criar um banco de dados no MySQL.
            $rows = $crud->read();//geralmente usada para ler registros atualizados.
            break;
        case 'read' ://é usado com o contexto de manipulação de arquivos quando você está lendpo dados de um arquivo aberto usando funções como fopen(), fread() e entre outras.
            $rows = $crud->read();//para ler os registros.
            break;
        case 'update':// atualizar os dados já armazenados em uma tabela do banco.
            if(isset($_POST['id'])){//verifica se o parâmetro 'action' está presente na URL da requisição.
                $crud->update($_POST);//alteração de todo o registro, mesmo que apenas um campo seja modificado, a web deve configurar todos os valores do registro: SQL. NodeJS. PHP.
                $rows = $crud->read();//geralmente usada para ler registros atualizados.  
            break;
            case 'delete' ://permite que uma ou mais linhas sejam excluídas de uma tabela do banco de dados.
                $crud->delete($_GET['ID']);//A função delete é praticamente igual ao insert na prática, a diferença é que ao invés de inserir dados, vamos estar excluindo eles da tabela, para isso precisamos identificar o registro de alguma maneira(normalmente usamos o próprio ID do registro) para então excluir a tabela.
                $rows = $crud->READ();//é usado para ler os registros atualizados.
                break;
        
                default://retorna um registro que contém os valores padrão da fonte de dados. Se uma coluna na fonte de dados não tiver um valor padrão, essa propriedade não estará presente.
                $rows = $crud->read();//Retorna um array que corresponde à linha carregada, ou false se não existem mais linhas.
                break;//finaliza a execução da estrutura for , foreach , while , do-while ou switch atual. break aceita um argumento numérico opcional que diz quantas estruturas aninhadas deverá interromper. 
        }else{//é a estrutura de controle que é executada quando o If, ou elseif, retorna falso.
            $rows = $crud->read();//geralmente usada para ler registros atualizados.
        }

}


        
        ?>
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud</title>
    <style>
        form{
            max-width:500px;
            margin: 0 auto;
        }
         label{
            display: flex;
            margin-top:10px
         }
         input[type=text]{
            width:100%;
            padding: 12px 20px;
            margin: 8px 0;
            display:inline-block;
            border: 1px solid #ccc;
            border-radius:4px;
            box-sizing:border-box;
         }
         input[type=submit]{
            background-color:#4caf50;
            color:white;
            padding:12px 20px;
            border:none;
            border-radius:4px;
            cursor:pointer;
            float:right;
         }
         input[type=submit]:hover{
            background-color:#45a049;
         }
         table{
            border-collapse:collapse;
            width:100%;
            font-family:Arial, sans-serif;
            font-size:14px;
            color:#333;
         }
         th, td{
            text-align:left;
            padding:8px;
            border: 1px solid #ddd;
         }
        th{
           background-color:#f2f2f2;
           font-weight:bold; 
        }
        a{
            display:inline-block;
            padding:4px 8px;
            background-color: #007bff;
            color:#fff;
            text-decoration:none;
            border-radius:4px;
        }
        a:hover{
            background-color:#0069d9;
        }

        a.delete{
            background-color: #dc3545;
        }
        a.delete:hover{
            background-color:#c82333;
        }
    </style>
</head>
<body>
<?php
 if(isset($_GET['action']) && $_GET['action'] == 'update' && isset($_GET['id'])){//verifica se o parâmetro 'action' está definido na URL e se o seu valor é 'update', e se o parâmetro 'id' também está definido.
    $id = $_GET['id'];//atribuiria o valor do parâmetro 'id' à variável '$id'.
    $result =$crud->readOne($id);//para buscar um registro com base no ID fornecido.

    if(!$result){//esta parte verifica se o resultado da consulta anterior é falso (ou seja, não encontrou um registro correspondente) e, nesse caso, exibe uma mensagem de erro e encerra o script.
        echo "Registro não encontrado, ";
        exit();
    }
    $modelo = $result['modelo'];//atribui corretamente os valores dos campos do registro ás variáveis correspondentes.
    $marca = $result['marca'];
    $placa = $result['placa'];
    $cor = $result['cor'];
    $ano = $result['ano'];

?>

<form action="?action=update" method="POST"> <!-- Esta função insere uma tabela para o usuário escrever seus dados -->
    <input type="hidden" name="id" value="<?php echo $id ?>">
    <label for="modelo">Modelo</label>
    <input type="text" name="modelo" value="<?php echo $modelo ?>">

    <label for="marca">Marca</label>
    <input type="text" name="marca" value="<?php echo $marca ?>">

    <label for="placa">Placa</label>
    <input type="text" name="placa" value="<?php  echo $placa ?>">
    
    <label for="cor">Cor</label>
    <input type="text" name="cor" value="<?php  echo $cor ?>">

    <label for="ano">Ano</label>
    <input type="text" name="ano" value="<?php  echo $ano ?>">

    <input type="submit" value="Atualizar" name="enviar" onclick="return confirm('Certeza que deseja atualizar?')"> <!--serve para acionar um aviso na tela -->

    </form>

<?php

   }else{

   ?>

<form action="?action=create" method="POST"> <!-- essa função insere uma tabela para o usuário escrever seus dados-->
    <label for="">Modelo</label>
    <input type="text" name="modelo">

    <label for="">Marca</label>
    <input type="text" name="marca">

    <label for="">Placa</label>
    <input type="text" name="placa">

    <label for="">Cor</label>
    <input type="text" name="cor">

    <label for="">Ano</label>
    <input type="text" name="ano">

    <input type="submit" value="Atualizar" name="enviar"> <!-- cria o botão de cadastro -->

</form>

<?php
       }
       ?>
    <table> <!-- é utilizada para criar elementos do tipo tabela em uma página HTML -->
        <tr> <!-- é usadada para definir uma linha. -->
            <td>Id</td>
            <td>Modelo</td>
            <td>Marca</td>
            <td>Placa</td>
            <td>Cor</td>
            <td>Ano</td>
        </tr>

    <table>

<?php
  if($rows->rowCount() == 0){ //se nada for digitado, aparecerá, nenhum dado encontrado
    echo "<tr>";
    echo "<td colspan='7'>Nenhum dado encontrado</td>";
    echo "</tr>";
  } else {
    while($row = $rows->fetch(PDO::FETCH_ASSOC)){//adiciona os valores escritos no cadastro
      echo "<tr>";
      echo "<td>" . $row['id'] . "</td>";
      echo "<td>" . $row['modelo'] . "</td>";
      echo "<td>" . $row['marca'] . "</td>";
      echo "<td>" . $row['placa'] . "</td>";
      echo "<td>" . $row['cor'] . "</td>";
      echo "<td>" . $row['ano'] . "</td>";
      echo "<td>";
      echo "<a href='?action=update&id=" . $row['id'] . "'>Editar</a>"; //botão para editar os dados
      echo "<a href='?action=delete&id=" . $row['id'] . "' onclick='return confirm(\"Tem certeza que quer apagar esse registro?\")' class='delete'>Delete</a>";//botão para ter certeza se a pessoa deseja excluir os dados dela
      echo "</td>";
      echo "</tr>";
    }
  }
?>

</table>

</body>
</html>

