<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 00.07.07
 * @since  2021-12-28 19:54:14
 *
 */
declare(strict_types = 1);
namespace Avi;

use voku\helper\AntiXSS;

/**
 * Filter class
 *
 * @author aviato-vasile
 *
 */
class Filter
{

	const FILTER_DEF_INVALID = 0;

	const FILTER_DEF_GROUP_BY_TYPE = 1;

	const FILTER_DEF_GROUP_BY_VAR = 2;

	const FILTER_INPUT_TYPE = [
		INPUT_POST,
		INPUT_GET,
		INPUT_COOKIE,
		INPUT_ENV,
		INPUT_SERVER
	];

	public $input = [];

	const FILTER_ACTIONS = [
		'validate',
		'sanitize'
	];

/*
 filter definitions strucutre:
 def => [
 FILTER_INPUT_TYPE_0 => [
 validate => [
 var_0 => [],
 var_1 => [],
 [...]
 ]

 sanitize => [
 var_0 => [],
 [...]
 ]
 ],
 FILTER_INPUT_TYPE_1 => [
 [...]
 ],
 [...]
 ]
 */
	protected $definition;

	protected $data;


	/**
	 *
	 * @param int $type is one of INPUT_GET, INPUT_POST, INPUT_COOKIE, INPUT_SERVER, or INPUT_ENV
	 * @param array $definition is an array of filtering definitions
	 */
	public function __construct(array $definition)
	{
		$this->input = [
			INPUT_POST => $_POST,
			INPUT_GET => $_GET,
			INPUT_COOKIE => $_COOKIE,
			INPUT_ENV => $_ENV,
			INPUT_SERVER => $_SERVER
		];
		$this->data = [];

		$this->definition = $this->parseDefinition($definition);

		return $this;
	}


	/**
	 * Determinate the definition group pattern (by variable | by input type } invalid)
	 *
	 * @param array $definition
	 * @return string
	 */
	private function getDefinitionGroup($definition)
	{
		$firstKey = array_key_first($definition);
		if (is_null($firstKey)) {
			return self::FILTER_DEF_INVALID;
		}

		if (in_array($firstKey, self::FILTER_INPUT_TYPE, true)) {
			return self::FILTER_DEF_GROUP_BY_TYPE;
		}

		if (! is_array($definition[$firstKey])) {
			return self::FILTER_DEF_INVALID;
		}

		$firstKey = array_key_first($definition[$firstKey]);
		if (is_null($firstKey)) {
			return self::FILTER_DEF_INVALID;
		}

		if (in_array($firstKey, self::FILTER_INPUT_TYPE, true)) {
			return self::FILTER_DEF_GROUP_BY_VAR;
		}

		return self::FILTER_DEF_INVALID;
	}


	/**
	 * Parse the definition array, return false on invalid definition
	 *
	 * @param array $definition
	 * @return boolean|array
	 */
	private function parseDefinition(array $definition)
	{
		$definitionGroupBy = $this->getDefinitionGroup($definition);

		if ($definitionGroupBy === self::FILTER_DEF_INVALID) {
			return false;
		}

		if ($definitionGroupBy === self::FILTER_DEF_GROUP_BY_VAR) {
			$definition = $this->transformDefGroupByVarToType($definition);
		}

		return $definition;
	}


	private function transformDefGroupByVarToType($definition)
	{
		// variable -> input_type -> action -> filter//
		// input_type -> action -> variable -> filter//
		$result = [];
		foreach ($definition as $var => $filtersInput) {
			foreach ($filtersInput as $inputType => $actions) {
				if (in_array($inputType, self::FILTER_INPUT_TYPE, true)) {
					foreach ($actions as $action => $filter) {
						$result[$inputType][$action][$var] = $filter;
					}
				}
			}
		}
		return $result;
	}


	/**
	 * Simple wrapper for filter_input_array
	 *
	 * @param bool $add_empty
	 * @return mixed filtered array
	 */
	private function validateInput(bool $add_empty = null)
	{
		// post -> validate -> date ->
		foreach ($this->definition as $inputType => $v) {
			// $dataValid = filter_var_array($_GET, $v['validate'], true);
			// because of this bug: https://bugs.php.net/bug.php?id=42608 filter_input_array can not be tested!
			// $dataValid = filter_input_array($inputType, $v['validate'], true);
			$dataValid = filter_var_array($this->input[$inputType], $v['validate'], $add_empty);

			if (\is_array($dataValid)) {
				$this->data = array_merge($this->data, $dataValid);
			}
		}
		return $this;
	}


	/**
	 *
	 * @param array $var
	 * @return array filtered var by antixss
	 */
	private function validateAntiXss()
	{
		$antiXss = new AntiXSS();
		foreach ($this->data as $k => $v) {
			$this->data[$k] = $antiXss->xss_clean($v);
		}

		return $this;
	}


	/**
	 *
	 * Wrapper for finlter_var_array
	 *
	 * @param bool $add_empty
	 * @return mixed
	 */
	private function sanitizeData(bool $add_empty = false)
	{
		/*
		 foreach ($this -> definition as $inputType => $filter) {
		 $dataSanitized = filter_var_array($this -> data, $filter['sanitize'], $add_empty);
		 foreach ($filter['sanitize'] as $k => $v) {

		 }
		 }
		 */
		foreach ($this->definition as $definition) {
			if (isset($definition['sanitize'])) {
				foreach ($definition['sanitize'] as $k => $v) {
					if (isset($this->data[$k])) {
						$this->data[$k] = filter_var($this->data[$k], $v['filter'], $v['options'] ?? []);
					} else {
						$this->data[$k] = null;
					}

					if (\is_null($this->data[$k]) && ! $add_empty) {
						unset($this->data[$k]);
					}
				}
			}
		}
	}


	public function add(int $input_type, string $action, array $filterVariable)
	{
		$this->definition[$input_type][$action] = $this->definition[$input_type][$action] ?? [];
		$this->definition[$input_type][$action] = array_merge($this->definition[$input_type][$action], $filterVariable);
		return $this;
	}


	public function check($add_empty = false)
	{
		$this->validateInput($add_empty);
		$this->validateAntiXss();
		$this->sanitizeData($add_empty);

		return $this->data;
	}
}