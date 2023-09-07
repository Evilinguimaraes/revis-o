<?php

class Database{
    private $host = "localhost";//nome da URL
    private $db_name = "aula3crud";//nome do banco de dados
    private $username = "root";//nome de usuário
    private $senha = "";//senha
    private $conn;//conexão

    public function getConnection(){// indica que o método ou atributo da classe é público, ou seja, pode ser acessado em qualquer outro ponto do código e por outras classes.
        $this->conn = null;//usada para armazenar a conexão com o banco de dados após a conexão ser estabelecida. Definir inicialmente como null é uma prática comum.

        try{// tratar exceções que o programador não tem como prever que irão acontecer ou controlar.
            $this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->db_name, $this->username,$this->senha);//esta linha cria uma nova instancia da classe PDO para estabelecer uma conexão com o banco de dados MySQL.
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){//define como o código responde a uma exceção lançada, define um ou mais tipos de exceções ou erros que ele pode processar, e opcionalmente uma variável para receber a exceção lançada.
            echo "Erro na conexao: ". $e->getMessage();//é a instrução que envia para a saída qualquer informação, podendo conter texto, números ou variáveis.
        }

        return $this->conn;// retorna o controle do programa para o módulo que o chamou. A execução continuará na expressão seguinte à invocação do módulo. Se chamada dentro de uma função, a declaração return terminará imediatamente sua execução, e retornará seus argumentos como valor à chamada da função.
        }
    }
?>