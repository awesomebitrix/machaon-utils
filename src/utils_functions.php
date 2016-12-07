<?php 

	/**
	 * Proxy wrappers to use utils without namespaces
	 */

	if (!function_exists('config'))
	{
		function config() {
			call_user_func_array('Machaon\Utils\config', func_get_args());
		}
	}

	if (!function_exists('asset'))
	{
		function asset() {
			call_user_func_array('Machaon\Utils\asset', func_get_args());
		}
	}

	if (!function_exists('logger'))
	{
		function logger() {
			call_user_func_array('Machaon\Utils\logger', func_get_args());
		}
	}

	if (!function_exists('starts_with'))
	{
		function starts_with() {
			call_user_func_array('Machaon\Utils\starts_with', func_get_args());
		}
	}

	if (!function_exists('ends_with'))
	{
		function ends_with() {
			call_user_func_array('Machaon\Utils\ends_with', func_get_args());
		}
	}