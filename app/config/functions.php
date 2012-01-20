<?php

/**
 * Check is $value non-negative integer, or integer string,
 * or array containing integers.
 *
 * @param  mixed   $value Value to check
 * @param  boolean $zero  Is "0" value accepted
 * @return boolean
 * @author Maria, Krat
 */
function checkNumber($value, $zero = false) {
	if (is_array($value)) {
		$result = (bool) $value;
		foreach ($value as $val) {
			$result &= checkNumber($val, $zero);
		}
		return $result;
	}

	$intValue = (int)    $value;
	$strValue = (string) $intValue;
	$srcValue = (string) $value;

	return ($strValue === $srcValue)
		&& ($intValue >= ($zero ? 0 : 1))
		&& (! is_bool($value));
}

/**
 * Get parameter from options list and return it's value
 *
 * To get parameter from sublist, use '/' delimiter in $parName.
 * For example:
 *   >> $test = array ('one' => array ('two' => 'A'));
 *   >> echo gp($test, 'one/two');
 *   << A
 *
 * If parameter not exists return default value.
 * For example:
 *   >> echo gp($test, 'one/tree', 'B');
 *   << B
 *
 * Also, if parameter value and default value are arrays, function
 * returns recurcively merged these values.
 * For example:
 *   >> $one = gp($test, 'one', array ('three' => 'B'));
 *   >> echo $one['two'];
 *   << A
 *   >> echo $one['three'];
 *   << B
 *
 * @param  array  &$from    Options list
 * @param  string  $parName Parameter key name
 * @param  mixed   $default Default value
 * @param  boolean $unset   Unset parameter from list when true
 * @return mixed
 */
function gp(&$from, $parName, $default = false, $unset = false) {
	$path = explode('.', $parName);
	$current = &$from;
	do {
		$key = array_shift($path);
		if (! is_array($current)) {
			return $default;
		}
		if (! isset($current[$key])) {
			if ($unset && array_key_exists($key, $current)) {
				unset($current[$key]);
			}
			return $default;
		}
		if ($path) {
			$current = &$current[$key];
		}
	}
	while ($path);

	$result = $current[$key];

	if ($unset) {
		unset($current[$key]);
	}
	if (! function_exists('__array_merge_recursive')) {
		function __array_merge_recursive($arg1, $arg2) {
			if (! is_array($arg1) || ! is_array($arg2)) {
				return $arg2;
			}
			foreach ($arg1 as $key => &$value) {
				if (! isset($arg2[$key])) {
					continue;
				}
				$value = __array_merge_recursive($value, $arg2[$key]);
				unset($arg2[$key]);
			}
			unset($value);
			return $arg1 + $arg2;
		}
	}
	return __array_merge_recursive($default, $result);
}

/**
 * Extract parameter from options list and return it's value
 *
 * It is a synonym for gp function with $unset = true
 *
 * @param  array  &$from    Options list
 * @param  string  $parName Parameter key name
 * @param  mixed   $default Default value
 * @return mixed
 */
function ep(&$from, $parName, $default = false) {
	return gp($from, $parName, $default, true);
}

/**
 * Output var_dump wrapped by <pre> tags and only in debug mode
 *
 * @param  mixed $var,... Variables to output
 * @return void
 */
function vd() {
	if (Configure::read() > 0) {
		echo '<pre>';
		foreach (func_get_args() as $var) {
			var_dump($var).PHP_EOL;
		}
		echo '</pre>';
	}
}

/**
 * Check if $array is associative array or not
 *
 * @param  mixed   $array Array to check
 * @return boolean
 * @author alex frase
 */
function is_assoc($array) {
	if (is_array($array)) {
		foreach (array_keys($array) as $k => $v) {
			if ($k !== $v)
				return true;
		}
	}
	return false;
}
