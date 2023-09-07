<?php
//inclui a pasta conexao e o arquivo conexao para transferir os dados
include_once('conexao/conexao.php');

$db = new Database(); //Criando a variável

class Crud{ //Usada para executar operações CRUD
    private $conn; //Esta é uma propriedade privada da classe chamada $conn. Ela é usada para armazenar uma instância da conexão com o banco de dados. A conexão provavelmente é passada como argumento para o construtor da classe.
    private $table_name = "carros"; //Esta é uma propriedade privada da classe chamada $table_name que armazena o nome da tabela do banco de dados com a qual a classe Crud trabalhará. No seu caso, a tabela se chama "carros". Isso é útil porque a classe pode precisar executar operações específicas nessa tabela.

    public function __construct($db){ //Este é o construtor da classe Crud. Ele é executado automaticamente quando um objeto da classe Crud é criado.
        $this->conn = $db; //Esse parâmetro é uma instância de uma classe que representa uma conexão com o banco de dados, como a instância do PDO que vimos em perguntas anteriores. O construtor está inicializando a propriedade $conn da classe Crud com essa conexão.
    }

    public function create($postValues){ //É um array associativo que contém os valores dos campos que serão inseridos na tabela do banco de dados.
        $modelo = $postValues['modelo'];
        $marca = $postValues['marca'];
        $placa = $postValues['placa'];
        $cor = $postValues['cor'];
        $ano = $postValues['ano']; 
        //São variáveis locais que recebem os valores correspondentes dos campos do array $postValues.

        $query = "INSERT INTO ". $this->table_name . " (modelo, marca, placa, cor, ano) VALUES (?,?,?,?,?)"; //A função constrói uma consulta SQL de inserção usando os valores extraídos e o nome da tabela armazenado na propriedade '$this->table_name'
        $stmt = $this->conn->prepare($query); //A função prepara a consulta SQL para execução utilizando a conexão PDO ($this->conn) e o método prepare(). Isso é uma prática recomendada para evitar injeção de SQL e tornar a consulta mais segura.
        $stmt->bindParam(1,$modelo); //Vincula o valor de $modelo ao primeiro marcador de posição na consulta.
        $stmt->bindParam(2,$marca); //Vincula o valor de $marca ao segundo marcador de posição na consulta.
        $stmt->bindParam(3,$placa); //Vincula o valor de $placa ao terceiro marcador de posição na consulta.
        $stmt->bindParam(4,$cor); //Vincula o valor de $cor ao quatro marcador de posição na consulta.
        $stmt->bindParam(5,$ano); //Vincula o valor de $ano ao quinto marcador de posição na consulta.

        $rows = $this->read(); //para ler os registros atualizados.
        if($stmt->execute()){ //É usada para verificar se a execução de uma consulta SQL preparada foi bem-sucedida.
            print "<script>alert('Cadastro Ok!')</script>"; //Imprime na tela um alerta dizendo que o cadastro foi feito
            print "<script> location.href='?action=read'; </script>"; //Serve para redirecionar o navegador da web para uma nova página ou URL. Ela faz isso incorporando JavaScript na página PHP e usando location.href para direcionar o navegador para a URL especificada, que neste caso é ?action=read. Isso é frequentemente usado em aplicativos da web para controlar a navegação do usuário de uma página para outra.
            return true; //Se a execução da consulta for bem-sucedida, ou seja, se $stmt->execute() retornar true, a função ou método que contém esse código retornará true.
        }else{
            return false; //Se a execução da consulta falhar, ou seja, se $stmt->execute() retornar false, a função ou método retornará false.
        }
    }

    public function read(){ //Parte de uma classe em PHP responsável pela leitura (consulta) de registros de uma tabela em um banco de dados.
        $query = "SELECT * FROM ". $this->table_name; //Cria uma string de consulta SQL que seleciona todos os registros (todas as colunas) da tabela cujo nome é armazenado na propriedade $this->table_name. O * em SELECT * significa selecionar todas as colunas.
        $stmt = $this->conn->prepare($query); //Está preparando a consulta SQL para execução usando a conexão PDO armazenada em $this->conn. Isso é uma prática recomendada para evitar a injeção de SQL e tornar a consulta mais segura.
        $stmt->execute(); //Executa a consulta SQL preparada, obtendo assim os resultados da consulta
        return $stmt; //A função retorna o objeto da declaração preparada ($stmt).
    }

    public function update($postValues){ //Parte de uma classe PHP responsável por atualizar registros em um banco de dados. 
        
        $id = $postValues['id']; //A função começa extraindo os valores relevantes do array $postValues e atribuindo-os a variáveis locais, como $id, $modelo, $marca, $placa, $cor e $ano. Esses valores representam os novos dados que serão usados para atualizar um registro existente.
        $modelo = $postValues['modelo'];
        $marca = $postValues['marca'];
        $placa = $postValues['placa'];
        $cor = $postValues['cor'];
        $ano = $postValues['ano'];

        if(empty($id) || empty($modelo) || empty($marca) || empty($placa) || empty($cor) || empty($ano)){ //verifica se algum dos campos relevantes (no caso, $id, $modelo, $marca, $placa, $cor e $ano) está vazio usando empty(). Se algum dos campos estiver vazio, a função retorna false.
            return false;
        }
        
        $query = "UPDATE ". $this->table_name . " SET modelo = ?, marca = ?, placa = ?, cor = ?, ano = ? WHERE id = ?"; //Esta linha cria uma string de consulta SQL de atualização. Ela atualiza os valores nas colunas modelo, marca, placa, cor e ano da tabela cujo nome é armazenado em $this->table_name. A atualização é baseada no valor da coluna id, que é fornecido como um parâmetro para a consulta.
        $stmt = $this->conn->prepare($query); //Está preparando a consulta SQL de atualização para execução usando a conexão PDO ($this->conn). Isso é feito para evitar a injeção de SQL e garantir que a atualização seja segura.
        $stmt->bindParam(1,$modelo); //Vinculam os valores das variáveis $modelo, $marca, $placa, $cor, $ano e $id aos marcadores de posição na consulta SQL. Os marcadores de posição são representados por ? na consulta SQL. A vinculação dos valores é feita para que os valores sejam inseridos de forma segura na consulta.
        $stmt->bindParam(2,$marca);
        $stmt->bindParam(3,$placa);
        $stmt->bindParam(4,$cor);
        $stmt->bindParam(5,$ano);
        $stmt->bindParam(6,$id);
        if($stmt->execute()){ //Executa a consulta SQL preparada usando $stmt->execute(). Se a execução for bem-sucedida, ou seja, se a atualização for concluída com sucesso, o método execute() retorna true. Nesse caso, o código dentro do bloco if é executado, e a função/método que contém esse código retorna true para indicar que a atualização foi bem-sucedida.
            return true;
        }else{ //Se a execução da consulta falhar, o código dentro do bloco else é executado, e a função/método retorna false para indicar que a atualização falhou.
            return false;
        }

    }
        public function readOne($id){ //Serve para recuperar um único registro de uma tabela em um banco de dados com base no valor do campo id.
            $query = "SELECT * FROM ". $this->table_name . " WHERE id = ?"; //Cria uma string de consulta SQL que seleciona todos os campos (colunas) da tabela cujo nome é armazenado em $this->table_name. A cláusula WHERE é usada para filtrar os resultados com base no valor da coluna id, que é fornecido como um parâmetro para a consulta.
            $stmt = $this->conn->prepare($query); //Preparando a consulta SQL para execução usando a conexão PDO ($this->conn). A preparação da consulta é uma prática recomendada para evitar a injeção de SQL e tornar a consulta segura.
            $stmt->bindParam(1, $id); //Vincula o valor da variável $id ao marcador de posição ? na consulta SQL. Isso permite que o valor seja inserido de forma segura na consulta.
            $stmt->execute(); //Executando a consulta SQL preparada. Isso resulta na seleção de um registro da tabela com base no valor do campo id fornecido.
            return $stmt->fetch(PDO::FETCH_ASSOC); //Recupera a primeira linha de resultados como um array associativo. Isso significa que a função retornará um array associativo contendo os valores das colunas do registro selecionado.

        }

        public function delete($id){ //Serve para excluir um registro de uma tabela de banco de dados com base no valor do campo id.
            $query = "DELETE FROM " .$this->table_name . " WHERE id = ?"; //Cria uma string de consulta SQL que remove (exclui) registros da tabela cujo nome é armazenado em $this->table_name. A cláusula WHERE é usada para especificar qual registro deve ser excluído com base no valor da coluna id, que é fornecido como um parâmetro para a consulta.
            $stmt = $this->conn->prepare($query); //Preparando a consulta SQL para execução usando a conexão PDO ($this->conn). A preparação da consulta é uma prática recomendada para evitar a injeção de SQL e tornar a consulta segura.
            $stmt->bindParam(1, $id); //Vincula o valor da variável $id ao marcador de posição ? na consulta SQL. Isso permite que o valor seja inserido de forma segura na consulta.
            if($stmt->execute()){
                return true;
            }else{ //Executando a consulta SQL preparada usando $stmt->execute(). Se a execução for bem-sucedida, o método execute() retornará true. Nesse caso, o código dentro do bloco if é executado, e a função/método que contém esse código retorna true para indicar que a exclusão foi bem-sucedida.
                return false;
            }
        }

    }
?>