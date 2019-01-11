<?php
# основные настройки бота
define('BOT_TOKEN', 'ABC:123'); // токен бота
define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/'); // адрес API. Без нужды не трогать!
define('WEBHOOK', 'https://example.com/process.php'); // адрес вебхука, поменять на свой (строго https!!!)
define('ADMIN', 'DecoderCoder'); // ник админа, используется проверка "админ ли?"
define('R', getcwd()); // рутовая директория, т.е. где лежит этот файл, например

# доп. сервисы
define('SPEECHKIT_TOKEN', '123'); // token Yandex.SpeechKit для распознавания голоса
define('LASTFM', '1234567890'); // API key Last.FM для просмотра NowPlaying


# настройки подключения к БД
$mysql = mysqli_connect('127.0.0.1','root','') or die(mysqli_error()); // укажите тут данные для коннекта к серверу БД
$mysql->select_db('DBNAME') or die(mysqli_error()); // укажите имя базы
mysqli_set_charset($mysql, 'utf8'); // по умолчанию все на utf-8