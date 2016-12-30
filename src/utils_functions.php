<?php 

	/**
	 * Proxy wrappers to use utils without namespaces
	 */

	if (!function_exists('config'))
	{
		function config() {
			return call_user_func_array('Machaon\Utils\config', func_get_args());
		}
	}

	if (!function_exists('asset'))
	{
		function asset() {
			return call_user_func_array('Machaon\Utils\asset', func_get_args());
		}
	}

	if (!function_exists('logger'))
	{
		function logger() {
			return call_user_func_array('Machaon\Utils\logger', func_get_args());
		}
	}

	if (!function_exists('starts_with'))
	{
		function starts_with() {
			return call_user_func_array('Machaon\Utils\starts_with', func_get_args());
		}
	}

	if (!function_exists('ends_with'))
	{
		function ends_with() {
			return call_user_func_array('Machaon\Utils\ends_with', func_get_args());
		}
	}

	if (!function_exists('d'))
	{
		function d() {
			call_user_func_array('Machaon\Utils\d', func_get_args());
		}
	}

	if (!function_exists('dd'))
	{
		function dd() {
			call_user_func_array('Machaon\Utils\dd', func_get_args());
		}
	}

	if (!function_exists('da'))
	{
		function da() {
			call_user_func_array('Machaon\Utils\da', func_get_args());
		}
	}

	if (!function_exists('dda'))
	{
		function dda() {
			call_user_func_array('Machaon\Utils\dda', func_get_args());
		}
	}