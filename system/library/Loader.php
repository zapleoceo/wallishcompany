<?php
final class Loader {
	private $registry;

	public function __construct($registry) {
		$this->registry = $registry;
	}

	public function __get($key) {
		return $this->registry->get($key);
	}

	public function __set($key, $value) {
		$this->registry->set($key, $value);
	}

	public function model($model) {
		$key = 'model_' . str_replace('/', '_', $model);

		if (!$this->registry->has($key)) {
			$file = DIR_APPLICATION . 'model/' . $model . '.php';
			$class = 'Model' . preg_replace('/[^a-zA-Z0-9]/', '', $model);

			if (is_file($file)) {
				include_once($file);
				$proxy = new Proxy();
				$proxy->__get($class);
				$this->registry->set($key, $proxy);
			} else {
				throw new Exception('Error: Could not load model ' . $model . '!');
			}
		}

		return $this->registry->get($key);
	}

	public function view($template, $data = array()) {
		$file = DIR_TEMPLATE . $template;

		if (is_file($file)) {
			extract($data);
			ob_start();
			require($file);
			$output = ob_get_contents();
			ob_end_clean();
			return $output;
		} else {
			throw new Exception('Error: Could not load template ' . $template . '!');
		}
	}

	public function library($library) {
		$file = DIR_SYSTEM . 'library/' . $library . '.php';

		if (is_file($file)) {
			include_once($file);
		} else {
			throw new Exception('Error: Could not load library ' . $library . '!');
		}
	}

	public function helper($helper) {
		$file = DIR_SYSTEM . 'helper/' . $helper . '.php';

		if (is_file($file)) {
			include_once($file);
		} else {
			throw new Exception('Error: Could not load helper ' . $helper . '!');
		}
	}

	public function config($config) {
		$this->config->load($config);
	}

	public function language($language) {
		return $this->registry->get('language')->load($language);
	}
}
?>
