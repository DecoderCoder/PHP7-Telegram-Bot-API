<?php


require_once 'api.php'; // всякие функции отправки сообщений, обработки и так далее + задание констант типа API_TOKEN и коннект к бд
# сеттим вебхук, если скрипт выполняется из оболочки системы
if(php_sapi_name() == 'cli' XOR !empty($_GET['webhook']))
	{
		setWebhook(WEBHOOK);
	}
# процессим входящую ебалу

$content = file_get_contents("php://input"); // всё, что пришло на вебхук ПОСТом - идет в $content
$update = @json_decode($content, true); // декодим из джсона в ассоциативный массив

if(!$update)
	{
		// кривой JSON, значит левый запрос или что-то такое
		sendMessage(@$_CHAT['id'], 'Invalid request');
	}
else
	{
		# делаем псевдоглобальные переменные
		$_MESS = $update['message']; // массив с содержанием самого сообщения (полезная информация то есть)
		$_TEXT = mb_strtolower($_MESS['text'], 'utf-8'); // для нерегистрозависимости сразу текст в нижнее подчеркивание
		$_CHAT = $_MESS['chat']; // информация о том, какой это чат (если это личка, части переменных не будет)
		$_USER = $_MESS['from']; // информация о юзере-отправителе
		$_USER['username'] = empty($_USER['username']) ? $_USER['first_name'].' '.$_USER['last_name'] : $_USER['username'];
		$_CHAT['title'] = empty($_CHAT['title']) ? 'ЛС' : $_CHAT['title'];
		// тут require всяких скриптов-обработчиков
		$h = opendir('scripts');
		while(false !== ($file = readdir($h)))
			{
				$___tmp = explode('.', $file);
				$ext = end($___tmp);
				if($ext == 'php')
					{
						require_once 'scripts/'.$file;
					}
			}
		closedir($h);
	}

http_response_code(200);   // Что бы в случае ошибки телеграм не отправлял повторные запросы