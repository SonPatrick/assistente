<?php 


require_once("../controller/system.php");
$user_name = $system_user['0']['user_name'];
$assistente_nome = $assistente['0']['assistente_name'];
$time = date('H:m');
$key = $busca->Rand(20);

if (isset($_POST['quest'])) {

	$quest = $_POST['quest'];



	$pergunta = $busca->select("perguntas", "pergunta_name = '$quest'  order by rand() limit 1");

	$dados['quest'] = $quest;

//001 - QUANDO A PERGUNTAR NÃO EXISTIR
	if(empty($pergunta)){

		$dados['resposta'] = '

		<div class="chat-message-right mb-4">
		<div>
		<img src="assets/img/avatars/1-small.png" class="ui-w-40 rounded-circle" alt>
		<div class="text-muted small text-nowrap mt-2">'.$time.'</div>
		</div>
		<div class="flex-shrink-1 bg-lighter rounded py-2 px-3 mr-3">
		<div class="font-weight-semibold mb-1">'.$user_name.'</div>
		'.htmlspecialchars($quest).'
		</div>
		</div>

		<div class="chat-message-left mb-4">
		<div>
		<img src="assets/img/avatars/5.png" class="ui-w-40 rounded-circle" alt>
		<div class="text-muted small text-nowrap mt-2">'.$time.'</div>
		</div>
		<div class="flex-shrink-1 bg-lighter rounded py-2 px-3 ml-3">
		<div class="font-weight-semibold mb-1">'.$assistente_nome.'

		</div>
		'.$user_name.' desculpe, ainda não sei responder a isso, mais preparei um formulário para que possa me ensinar ;)<br>
		CHAVE: <i class="text-info">'.$key.'</i>

		<div class="form-group">
		<br>
		<label class="form-label">Pergunta</label>
		<input name="'.$key.'pergunta" id="'.$key.'pergunta" type="text" class="form-control" placeholder="Informe o texto da pergunta" value="'.$quest.'">
		</div>
		<div class="form-group">
		<label class="form-label">Resposta</label>
		<input name="'.$key.'resposta" id="'.$key.'resposta"  type="text" class="form-control" placeholder="Informe o texto da resposta">
		</div>

		<button class="btn btn-info" onclick="Envia_Pergunta('.$key.');">Ensinar</button>
		</div>
			';
//FIM - 001	

//A PERGUNTA EXISTE ENTÃO ELA RETORNA UMA RESPOSTA ALEATÓRIA	
		}elseif($pergunta[0]['pergunta_name'] == $quest){

			$pergunta_id = $pergunta[0]['id'];

			$resposta = $busca->select("respostas", "resposta_pergunta_id = '$pergunta_id' order by rand() limit 1");

			$dados['resposta'] = '

			<div class="chat-message-right mb-4">
			<div>
			<img src="assets/img/avatars/1-small.png" class="ui-w-40 rounded-circle" alt>
			<div class="text-muted small text-nowrap mt-2">'.$time.'</div>
			</div>
			<div class="flex-shrink-1 bg-lighter rounded py-2 px-3 mr-3">
			<div class="font-weight-semibold mb-1">'.$user_name.'</div>
			'.$quest.'
			</div>
			</div>

			<div class="chat-message-left mb-4">
			<div>
			<img src="assets/img/avatars/5.png" class="ui-w-40 rounded-circle" alt>
			<div class="text-muted small text-nowrap mt-2">'.$time.'</div>
			</div>
			<div class="flex-shrink-1 bg-lighter rounded py-2 px-3 ml-3">
			<div class="font-weight-semibold mb-1">'.$assistente_nome.'

			</div>
			'.$resposta[0]["resposta_name"].'
			</div>
			';
		}


		header("Content-Type: text/plain");
		echo json_encode($dados);

	}

	?>



