<?php 
	namespace Machaon\Utils;

	/**
	 * Функция подключает файл с одноименными прокси-функциями без неймспейсов.
	 * @return void
	 */
	function usePlainFunctions()
	{
		require_once(__DIR__ . '/utils_functions.php');
	}

	/**
	 * Функция открывает ini-файл с конфигурацией и возвращает объект для удобного управления ей.
	 * Поддерживаются файлы ini, xml, php.
	 * Если в качестве конфига используется php-скрипт, то он должен возвращать массив с конфигурацией.
	 * 
	 * @see https://zendframework.github.io/zend-config/
	 * 
	 * @param  string $fileName   Полный абсолютный путь к файлу конфигурации на сервере.
	 * @return \Zend\Config\Config Объект для работы с конфигурацией
	 * @throws \Exception Исключение будет брошено, если файл конфигурации недоступен для чтения или не существует.
	 */
	function config($fileName)
	{
		$data = array();
		$lowerName = strtolower($fileName);

		if (ends_with($lowerName, '.ini')) {
			$reader = new \Zend\Config\Reader\Ini();
		} elseif (ends_with($lowerName, '.xml')) {
			$reader = new \Zend\Config\Reader\Xml();
		} else {
			$reader = false;
		}

		if ($reader) {
			$data = $reader->fromFile($fileName);
		} elseif (is_file($fileName) && is_readable($fileName)) {
			$data = require($fileName);
		} else {
			throw new \Exception(sprintf(
                "File '%s' doesn't exist or not readable",
                $fileName
            ));
		}

		return new \Zend\Config\Config($data);
	}

	/**
	 * Функция-обертка над Bitrix\Main\Page\Asset. Добавляет в <head/> скрипты, стили и произвольные строки 
	 * и возвращает экземпляр Bitrix\Main\Page\Asset.
	 * 
	 * @see https://dev.1c-bitrix.ru/api_d7/bitrix/main/page/asset/
	 * 
	 * @param  string|array|null $resourses Список подключаемых ресурсов.
	 * Тип ресурса определяется по расширению файла. Поддерживаются .css и .js - ожидаются доступные web-пути.
	 * Остальные ресурсы записываются в <head/> как обычные строки.
	 * 
	 * @return \Bitrix\Main\Page\Asset
	 */
	function asset($resourses = null)
	{
		$assetManager = \Bitrix\Main\Page\Asset::getInstance();
		if (!empty($resourses)) 
		{
			if (!is_array($resourses)) {
				$resourses = array($resourses);
			}

			foreach ($resourses as $resourse) 
			{
				if (ends_with($resourse, '.css')) {
					$assetManager->addCss($resourse);
				} elseif (ends_with($resourse, '.js')) {
					$assetManager->addJs($resourse);
				} else {
					$assetManager->addString($resourse);
				}
			}
		}
		return $assetManager;
	}

	/**
	 * Функция возвращает объект Monolog\Logger, 
	 * с предустановленным обработчиком StreamHandler для записи в файл.
	 * 
	 * @see https://github.com/Seldaek/monolog
	 * 
	 * @param  string $channelName Название канала. 
	 * Нужно, чтобы отличать записи разных логгеров, пишущих в один файл.
	 * Можно оставить пустым.
	 * 
	 * @param  string|null $logFileName Полный путь к лог-файлу. 
	 * Если оставить пустым - путь будет браться из битрикс-константы LOG_FILENAME.
	 * 
	 * @return \Monolog\Logger
	 * 
	 * @throws \Exception Исключение будет брошено, если не указан путь к лог-файлу,
	 * и не определена битрикс-константа LOG_FILENAME
	 */
	function logger($channelName = 'logger()', $logFileName = null)
	{
		$logger = new \Monolog\Logger($channelName);
		if (empty($logFileName)) 
		{
			if (!defined('LOG_FILENAME')) {
				throw new \Exception('Logfile not specified');
			} else {
				$logFileName = LOG_FILENAME;
			}
		}

		$handler = new \Monolog\Handler\StreamHandler($logFileName, \Monolog\Logger::DEBUG);
		$logger->pushHandler($handler);
		return $logger;
	}

	/**
	 * Функция возвращает true, если строка $haystack начинается со строки $needle
	 * Позаимствовано из исходников Laravel.
	 * 
	 * @param  string $haystack Строка, в которой производится поиск
	 * @param  string $needle   Проверяемая подстрока
	 * @return bool
	 */
	function starts_with($haystack, $needle)
	{
		return ($needle != '' && strpos($haystack, $needle) === 0);
	}

	/**
	 * Функция возвращает true, если строка $haystack заканчивается строкой $needle
	 * Позаимствовано из исходников Laravel.
	 * 
	 * @param  string $haystack Строка, в которой производится поиск
	 * @param  string $needle   Проверяемая подстрока
	 * @return bool
	 */
	function ends_with($haystack, $needle)
	{
		return ((string)$needle === substr($haystack, -strlen($needle)));
	}