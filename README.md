# Machaon\Utils

Набор функций-утилит для упрощения работы с битрикс-проектами

## Установка

	composer require machaon/utils

## Как пользоваться

Базовый случай

	# local/php_interface/init.php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/local/vendor/autoload.php');
	
	# any-script.php
	use Machaon\Utils as Machaon;
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	$asset = Machaon\asset([
	    SITE_TEMPLATE_PATH . '/js/script.js',
	    SITE_TEMPLATE_PATH . '/css/style.css',
	    '<meta name="cms" content="bitrix">'
	]);
	if (SOMETHING) {
	    $asset->addJs(SITE_TEMPLATE_PATH . '/js/something.js');
	}

Если не хочется работать через неймспейсы, можно подключить файл с прокси-функциями.
При этом могут быть конфликты, если например в системе уже есть функции с таким названием.
Если это не пугает, то модифицируем `init.php`:

	# local/php_interface/init.php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/local/vendor/autoload.php');
	Machaon\Utils\usePlainFunctions();
	
	# any-script.php
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
		
	// работаем с функцией напрямую
	$asset = asset([
	    SITE_TEMPLATE_PATH . '/js/script.js',
	    SITE_TEMPLATE_PATH . '/css/style.css',
	    '<meta name="cms" content="bitrix">'
	]);

## Что в коробке

### Machaon\Utils\usePlainFunctions()

Подключает файл с прокси-функциями для вызова без неймспейсов. Вместо `Machaon\Utils\foobar()` можно просто `foobar()`.
Все прокси-функции обернуты в `function_exists()`.

### Machaon\Utils\config()

Открывает ini-файл с конфигурацией и возвращает объект для удобного управления ей.
Помимо `.ini` поддерживает `.xml` и `.php` конфиги. 

В работе используется пакет `zendframework/zend-config`. Подробный док: [https://zendframework.github.io/zend-config/](https://zendframework.github.io/zend-config/)

Пример использования:

	# any-script.php
	$config = config($_SERVER['DOCUMENT_ROOT'] . '/config/main.ini');
	echo $config['iblock']['main_catalog'];
	echo $config->iblock->get('main_catalog'); // то же самое
	echo $config->iblock->get('main_catalog', '11'); // задаем значение по-умолчанию

Файл конфигурации должен быть валидным ini-файлом. Например, таким:

	# main.ini 
	[iblock]
	news = 1
	main_catalog = 11

### Machaon\Utils\asset()

Обертка над Bitrix\Main\Page\Asset. Добавляет в `head` скрипты, стили и произвольные строки 
и возвращает экземпляр Bitrix\Main\Page\Asset. Подробный док: [https://dev.1c-bitrix.ru/api_d7/bitrix/main/page/asset/](https://dev.1c-bitrix.ru/api_d7/bitrix/main/page/asset/)

Пример использования:

	# any-script.php
	
	// добавляем пачку скриптов и  метатегов
	$asset = asset([
	    SITE_TEMPLATE_PATH . '/js/script.js',
	    SITE_TEMPLATE_PATH . '/css/style.css',
	    '<meta name="cms" content="bitrix">'
	]);
	
	// используем полученный инстанс в дальнейшем для добавления скриптов по условию
	if (SOMETHING) {
	    $asset->addJs(/* ... */);
	}

Функция умеет выделять из путей js и css файлы по расширению, а нераспознаные строки добавляет методом `addString`,
это удобно для мета-тегов.

### Machaon\Utils\logger()

Быстрый способ получить готовый к использованию объект `Monolog\Logger` - популярной библиотеки для логирования.

Первый параметр задает название канала, чтобы можно было различать разные логгеры, пишущие в один файл. Необязательный.
Вторым параметром можно задать абсолютный путь к лог-файлу. Если оставить его пустым, то путь к лог-файлу будет браться 
из битрикс-константы LOG_FILENAME. Если константа не определена, функция бросит исключение.

Пример использования:

	# any-script.php
	$logger = logger();
	$logger->info('Logger instance inited');
	$logger->debug('Config instance inited', ['foo' => 'bar', 'bar' => 'baz']);

Лог-файл в таком случае может выглядеть примерно так:

	# main.log
	[2016-12-05 14:36:35] logger().INFO: Logger instance inited [] []
	[2016-12-05 14:36:35] logger().DEBUG: Config instance inited {"foo":"bar","bar":"baz"} []

Логгеров может быть несколько:

	# any-script.php
	$securityLogger = logger('security', $_SERVER['DOCUMENT_ROOT'] . '/logs/security.log');
	$debugLogger = logger('debug', $_SERVER['DOCUMENT_ROOT'] . '/logs/debug.log');

Важно понимать, что вместо функции можно пользоваться коробочными возможностями библиотеки Monolog. 
Это будет менее компактно, но даст больше возможностей:

	# any-script.php
	$logger = new \Monolog\Logger('security');
	$handler = new \Monolog\Handler\StreamHandler(LOG_FILENAME, \Monolog\Logger::DEBUG);
	$logger->pushHandler($handler);
	$logger->info('Security logger inited');

Полная документация Monolog: [https://github.com/Seldaek/monolog](https://github.com/Seldaek/monolog)

### Machaon\Utils\starts_with($haystack, $needle)

Функция возвращает true, если строка $haystack начинается со строки $needle. Позаимствовано из исходников Laravel.

Пример использования:

	# any-script.php
	if (starts_with('HelloWorld', 'Hello')) {
	    echo 'true';
	}

### Machaon\Utils\ends_with($haystack, $needle)

Функция возвращает true, если строка $haystack заканчивается строкой $needle. Позаимствовано из исходников Laravel.

Пример использования:

	# any-script.php
	if (ends_with('style.css', '.css')) {
	    echo 'this is css-file';
	}