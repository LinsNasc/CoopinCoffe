<?php
    require_once('conexao.php');
    session_start();

    Function CadastrarProduto(){
        $conn = getConexao();

        $nome = $_POST['nome'];
        $preco = $_POST['preco'];
        $categoria = filter_var($_POST['categoria']);
        $porcao = filter_var($_POST['porcao']);
        $qtd_estoque = $_POST['qtd_estoque'];
        if ($categoria){
            if ($porcao){
                $sql = "INSERT INTO produto (nome, preco, categoria, porcao, qtd_estoque) values ( :nome, :preco, :categoria, :porcao, :qtd_estoque)";
                $stmt = $conn -> prepare($sql);
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':preco', $preco);
                $stmt->bindParam(':categoria', $categoria);
                $stmt->bindParam(':porcao', $porcao);
                $stmt->bindParam(':qtd_estoque', $qtd_estoque);
                if ($stmt->execute()){
                    echo "Produto cadastrado com sucesso!";
                    header('location:../cadastro_produto.php');
                }
                else{
                    echo "Erro ao cadastrar produto!";
                }
            }
            else{
            echo "<script type='text/javascript'>
                        alert('Escolha não selecionada');
                        window.location='../cadastro_produto.php';
                      </script>";
        }

        }
        else{
            echo "<script type='text/javascript'>
                        alert('Escolha não selecionada');
                        window.location='../cadastro_produto.php';
                      </script>";
        }


    }

    Function VisualizarProduto(){
        $conn = getConexao();
        $sql = "SELECT * FROM produto";
        $stmt = $conn->prepare($sql);

        if ($stmt->execute()){
            $result = $stmt->fetchAll();
            $_SESSION['nome'] = [];
            $_SESSION['preco'] = [];
            $_SESSION['categoria'] = [];
            $_SESSION['porcao'] = [];
            $_SESSION['qtd_estoque'] = [];
                foreach ($result as $value) {
                    $_SESSION['preco'][] = $value['preco'];
                    $_SESSION['nome'][] = $value['nome'];
                    $_SESSION['categoria'][] = $value['categoria'];
                    $_SESSION['porcao'][] = $value['porcao'];
                    $_SESSION['qtd_estoque'][] = $value['qtd_estoque'];
                }
                header("Location: ../cadastro_produto.php");
        }
        else{
            echo "Erro ao visualizar produtos!";
        }
    }

    function ExcluirProduto(){
        $conn = getConexao();
        $nome = $_POST['nome'];
        $sql = "DELETE FROM produto WHERE nome = :nome";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        if ($stmt->execute()){
            echo "<script type='text/javascript'>
            alert('Produto excluído com sucesso!');
            window.location='../cadastro_produto.php';
            </script>";
            }
        else{
            echo "Erro ao excluir produto!";
        }
    }

    function AlterarProduto(){
        $conn = getConexao();
        $nome = $_POST['nome'];
        $preco = $_POST['preco'];
        $categoria = $_POST['categoria'];
        $porcao = $_POST['porcao'];
        $qtd_estoque = $_POST['qtd_estoque'];
        $sql = "UPDATE produto SET nome = :nome, preco = :preco, categoria = :categoria, porcao = :porcao, qtd_estoque = :qtd_estoque WHERE nome = :nome";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':preco', $preco);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->bindParam(':porcao', $porcao);
        $stmt->bindParam(':qtd_estoque', $qtd_estoque);
    }

    if(isset($_POST['cadastrar'])){
        CadastrarProduto();
    }

    if(isset($_POST['visualizar'])){
        VisualizarProduto();
    }

    if(isset($_POST['excluir'])){
        ExcluirProduto();
    }

?>