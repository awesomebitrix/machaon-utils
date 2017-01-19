<?php 

	/**
	 * Proxy wrappers to use utils without namespaces
	 */

	if (!function_exists('config'))
	{
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
		function config() {
			return call_user_func_array('Machaon\Utils\config', func_get_args());
		}
	}

	if (!function_exists('asset'))
	{
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
		function asset() {
			return call_user_func_array('Machaon\Utils\asset', func_get_args());
		}
	}

	if (!function_exists('logger'))
	{
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
		function logger() {
			return call_user_func_array('Machaon\Utils\logger', func_get_args());
		}
	}

	if (!function_exists('starts_with'))
	{
		/**
		 * Функция возвращает true, если строка $haystack начинается со строки $needle
		 * Позаимствовано из исходников Laravel.
		 * 
		 * @param  string $haystack Строка, в которой производится поиск
		 * @param  string $needle   Проверяемая подстрока
		 * @return bool
		 */
		function starts_with() {
			return call_user_func_array('Machaon\Utils\starts_with', func_get_args());
		}
	}

	if (!function_exists('ends_with'))
	{
		/**
		 * Функция возвращает true, если строка $haystack заканчивается строкой $needle
		 * Позаимствовано из исходников Laravel.
		 * 
		 * @param  string $haystack Строка, в которой производится поиск
		 * @param  string $needle   Проверяемая подстрока
		 * @return bool
		 */
		function ends_with() {
			return call_user_func_array('Machaon\Utils\ends_with', func_get_args());
		}
	}

	if (!function_exists('d'))
	{
		/**
		 * Функция выводит удобный дамп переданных на вход переменных
		 * с использованием компонента symfony/var-dumper
		 * 
		 * Количество входных параметров не ограничено
		 * 
		 * @see http://symfony.com/doc/current/components/var_dumper.html
		 * 
		 * @return void
		 */
		function d() {
			call_user_func_array('Machaon\Utils\d', func_get_args());
		}
	}

	if (!function_exists('dd'))
	{
		/**
		 * Dump & Die
		 * @see d()
		 * @return void
		 */
		function dd() {
			call_user_func_array('Machaon\Utils\dd', func_get_args());
		}
	}

	if (!function_exists('da'))
	{
		/**
		 * Dump if Admin
		 * 
		 * Функция срабатывает только в том случае, если определен глобальный объект $USER класса CUser,
		 * и текущий пользователь является администратором.
		 * 
		 * Метод зависит от глобального bitrix-объекта $USER
		 * 
		 * @see http://dev.1c-bitrix.ru/api_help/main/reference/cuser/isadmin.php
		 * @see d()
		 * @return void
		 */
		function da() {
			call_user_func_array('Machaon\Utils\da', func_get_args());
		}
	}

	if (!function_exists('dda'))
	{
		/**
		 * Dump & Die if Admin
		 * @see da()
		 * @see dd()
		 * @return void
		 */
		function dda() {
			call_user_func_array('Machaon\Utils\dda', func_get_args());
		}
	}