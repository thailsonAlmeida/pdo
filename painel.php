<?php 
require_once("conexao.php"); 
@session_start();
$usuario = $_SESSION['nome_usuario'];
if ($usuario == ''){
	header('Location: index.php');
}
//echo $usuario;
 ?>


<!DOCTYPE html>
<html>
<head>
	
	<title>Fornecedores</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</head>
<body>

	<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="painel.php">PDO</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="painel.php">Fornecedores <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="produtos.php">Produtos</a>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Relatórios
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="rel/fornecedores_class.php">Fornecedores</a>
          <a class="dropdown-item" href="#">Produtos</a>
          
      </li>
     
       <li class="nav-item">
        <a class="nav-link" href="logout.php">Sair</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Search" name="txtbuscar">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="buscar">Buscar</button>
    </form>
  </div>
</nav>

<div class="container">
	<div class="col-md-12">
		<button class="btn btn-info mt-4 mb-2" data-toggle="modal" data-target="#modal">Novo Fornecedor</button>
	</div>
	<table class="table">
	  <thead>
	    <tr>
	      <th scope="col">Nome</th>
	      <th scope="col">Telefone</th>
	      <th scope="col">Email</th>
	      <th scope="col">Produto</th>
	      <th scope="col">Ações</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php

	  		if(isset($_GET['buscar']) and $_GET['txtbuscar'] != ''){

	  			$nome_buscar = $_GET['txtbuscar'] . '%';

	  			
	  			$res = $conexao->query("SELECT * from fornecedores where nome LIKE '$nome_buscar' order by nome asc");

	  		}else{
	  			$res = $conexao->query("SELECT * from fornecedores order by nome asc");
	  		} 

	  		


			$dados = $res->fetchAll(PDO::FETCH_ASSOC);
			$quantidade_fornecedores = count($dados);
			for ($i=0; $i < count($dados); $i++) { 
				foreach ($dados[$i] as $key => $value) {
				$id = $dados[$i]['id'];
				$nome = $dados[$i]['nome'];
				$telefone = $dados[$i]['telefone'];
				$email = $dados[$i]['email'];
				$produto = $dados[$i]['produto'];

				$res_p = $conexao->query("SELECT * from produtos where id = '$produto'");
				$dados_p = $res_p->fetch(PDO::FETCH_ASSOC);
					foreach ($dados_p as $key => $value) {
					$nome_produto = $dados_p['nome'];
					}
				}
				?>
	    <tr>
	      	<td><?php echo $nome ?></td>
	     	<td><?php echo $telefone ?></td>
	    	<td><?php echo $email ?></td>
	    	<td><?php echo $nome_produto ?></td>
	      
	       <td>
	      	<a href="painel.php?acao=editar&id=<?php echo $id; ?>" class="text-info mr-1"><i class="far fa-edit"></i></a>
	      	<a href="painel.php?acao=excluir&id=<?php echo $id; ?>" class="text-danger"><i class="far fa-trash-alt"></i></a>
	      </td>

	    </tr>

	<?php } ?>
	   
	  </tbody>
	</table>

</div>



</body>
</html>



<div class="modal" id="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Inserir Fornecedor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       		<form method="post">
       		  <div class="form-group">
			    <label for="exampleFormControlInput1">Nome</label>
			    <input type="text" class="form-control" id="exampleFormControlInput1" name="nome" placeholder="Nome">
			  </div>
			   <div class="form-group">
			    <label for="exampleFormControlInput1">Telefone</label>
			    <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Telefone">
			  </div>
			  <div class="form-group">
			    <label for="exampleFormControlInput1">Email</label>
			    <input type="email" class="form-control" id="exampleFormControlInput1" name="email" placeholder="name@example.com">
			  </div>
			  <div class="form-group">
			    <label for="exampleFormControlSelect1">Produtos</label>
			    <select class="form-control" name="produto" id="exampleFormControlSelect1">

			    	<?php 
			    	$res = $conexao->query("SELECT * from produtos order by nome asc");

			    	$dados = $res->fetchAll(PDO::FETCH_ASSOC);
					
					for ($i=0; $i < count($dados); $i++) { 
						foreach ($dados[$i] as $key => $value) {
						$id = $dados[$i]['id'];
						$nome = $dados[$i]['nome'];
						
						}
						?>

			    	 ?>

			      <option value="<?php echo $id ?>"><?php echo $nome ?></option>

			  <?php } ?>
			     
			    </select>
			  </div>
			 
			  
			
      </div>
      <div class="modal-footer">
        <button type="submit" name="salvar" class="btn btn-primary">Salvar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </form>
      </div>
    </div>
  </div>
</div>
 




<!--CADASTRO DOS FORNECEDORES -->
<?php 
if(isset($_POST['salvar'])){

	


	$nome = $_POST['nome'];
	$telefone = $_POST['telefone'];
	$email = $_POST['email'];
	$produto = $_POST['produto'];
	
	

		//VERIFICAR SE O EMAIL DO FORNECEDOR JÁ ESTÁ CADASTRADO
		$res = $conexao->query("SELECT * from fornecedores where email = '$email'");
		$dados = $res->fetchAll(PDO::FETCH_ASSOC);
		$linhas = count($dados);

		if($linhas == 0){
			
			$res = $conexao->prepare("insert into fornecedores (nome, telefone, email, produto) values (:nome, :telefone, :email, :produto)");

			$res->bindValue(":nome", $nome);
			$res->bindValue(":telefone", $telefone);
			$res->bindValue(":email", $email);
			$res->bindValue(":produto", $produto);
			
			
			$res->execute();

			echo "<script language='javascript'>window.alert('Fornecedor Cadastrado!'); </script>";

			echo "<script language='javascript'>window.location='painel.php'; </script>";
		}else{
			echo "<script language='javascript'>window.alert('Este fornecedor já está cadastrado!'); </script>";
		}

		
		
	

	
}


?>





<!--EDIÇÃO DOS FORNECEDORES -->
<?php 
if(@$_GET['acao'] == 'editar'){
	$id = $_GET['id'];
	$id_editar = $_GET['id'];

$res = $conexao->query("SELECT * from fornecedores where id = '$id'");
	  		
$dados = $res->fetch(PDO::FETCH_ASSOC);
			
foreach ($dados as $key => $value) {
				
	$nome = $dados['nome'];
	$telefone = $dados['telefone'];
	$email = $dados['email'];
	$produto = $dados['produto'];

	$res_p = $conexao->query("SELECT * from produtos where id = '$produto'");
				$dados_p = $res_p->fetch(PDO::FETCH_ASSOC);
					foreach ($dados_p as $key => $value) {
					$nome_produto = $dados_p['nome'];
					}

	$email_rec = $dados['email'];
				
}

?>


<div class="modal" id="modalEditar" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar Fornecedor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       		<form method="post"> 
       		 
       		  <div class="form-group">
			    <label for="exampleFormControlInput1">Nome</label>
			    <input type="text" class="form-control" id="exampleFormControlInput1" name="nome" placeholder="Nome" value="<?php echo $nome ?>">
			  </div>
			   <div class="form-group">
			    <label for="exampleFormControlInput1">Telefone</label>
			    <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Telefone" value="<?php echo $telefone ?>">
			  </div>
			  <div class="form-group">
			    <label for="exampleFormControlInput1">Email</label>
			    <input type="email" class="form-control" id="exampleFormControlInput1" name="email" placeholder="name@example.com" value="<?php echo $email ?>">
			  </div>
			  <div class="form-group">
			    <label for="exampleFormControlSelect1">Produtos</label>
			    <select class="form-control" name="produto" id="exampleFormControlSelect1">

			    	<option value="<?php echo $produto ?>"><?php echo $nome_produto ?></option>

			    	<?php 
			    	$res = $conexao->query("SELECT * from produtos order by nome asc");

			    	$dados = $res->fetchAll(PDO::FETCH_ASSOC);
					
					for ($i=0; $i < count($dados); $i++) { 
						foreach ($dados[$i] as $key => $value) {
						$id = $dados[$i]['id'];
						$nome = $dados[$i]['nome'];
						
						}
						?>

			    	 ?>

			      <?php 
			      	if($nome_produto != $nome){
			       ?>

			      <option value="<?php echo $id ?>"><?php echo $nome ?></option>

			  		<?php } ?>

			  <?php } ?>
			     
			    </select>
			  </div>
			 
			 
			 
			  
			
      </div>
     
	      <div class="modal-footer">
	        <button type="submit" name="editar" class="btn btn-primary">Editar</button>
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>

	      </div>
      </form>
    </div>
  </div>
</div>


<?php 
if(isset($_POST['editar'])){

	$nome = $_POST['nome'];
	$telefone = $_POST['telefone'];
	$email = $_POST['email'];
	$produto = $_POST['produto'];
	
		
		//VERIFICAR SE O NOME DO PRODUTO FOI MUDADO
		if($email_rec != $email){

			//VERIFICAR SE O PRODUTO JÁ ESTÁ CADASTRADO
			$res = $conexao->query("SELECT * from fornecedores where email = '$email'");
			$dados = $res->fetchAll(PDO::FETCH_ASSOC);
			$linhas = count($dados);

			if($linhas != 0){
				echo "<script language='javascript'>window.alert('Este fornecedor já está cadastrado!'); </script>";
				exit();
			}

		}


			
			$res = $conexao->prepare("update fornecedores set nome = :nome, telefone = :telefone, email = :email, produto = :produto where id = '$id_editar'");

			$res->bindValue(":nome", $nome);
			$res->bindValue(":telefone", $telefone);
			$res->bindValue(":email", $email);
			$res->bindValue(":produto", $produto);
			
			
			$res->execute();

			
			echo "<script language='javascript'>window.alert('Fornecedor Editado!'); </script>";

			echo "<script language='javascript'>window.location='painel.php'; </script>";
		

			
}


?>


<?php } ?>





<!--EXCLUSÃO DOS FORNECEDORES -->
<?php 
if(@$_GET['acao'] == 'excluir'){
	$id = $_GET['id'];

	$conexao->query("delete from fornecedores where id = '$id'");

	echo "<script language='javascript'>window.alert('Fornecedor Excluido!'); </script>";

	echo "<script language='javascript'>window.location='painel.php'; </script>";
		

}
?>






<script> $("#modalEditar").modal("show");</script>



 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>


<script type="text/javascript">
    $(document).ready(function(){
      $('#telefone').mask('(00) 00000-0000');
      $('#cpf').mask('000.000.000-00');
      });
</script>