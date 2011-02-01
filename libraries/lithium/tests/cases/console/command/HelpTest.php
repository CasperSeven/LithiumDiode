<?php

namespace lithium\tests\cases\console\command;

use lithium\console\command\Help;
use lithium\console\Request;
use lithium\tests\mocks\console\command\MockCommandHelp;

class HelpTest extends \lithium\test\Unit {

	public $request;

	public $classes = array();

	protected $_backup = array();

	public function setUp() {
		$this->classes = array('response' => 'lithium\tests\mocks\console\MockResponse');
		$this->_backup['cwd'] = getcwd();
		$this->_backup['_SERVER'] = $_SERVER;
		$_SERVER['argv'] = array();

		$this->request = new Request(array('input' => fopen('php://temp', 'w+')));
		$this->request->params = array('library' => 'build_test');
	}

	public function tearDown() {
		$_SERVER = $this->_backup['_SERVER'];
		chdir($this->_backup['cwd']);
	}

	public function testRun() {
		$command = new Help(array(
			'request' => $this->request, 'classes' => $this->classes
		));
		$result = $command->run();
		$this->assertTrue($expected, $result);

		$expected = "COMMANDS\n";
		$expected = preg_quote($expected);
		$result = $command->response->output;
		$this->assertPattern("/{$expected}/", $result);

		$expected = preg_quote($expected);
		$result = $command->response->output;
		$pattern = "/\s+test\s+Runs a given set of tests and outputs the results\./ms";
		$this->assertPattern($pattern, $result);
	}

	public function testRunWithName() {
		$command = new Help(array(
			'request' => $this->request, 'classes' => $this->classes
		));
		$result = $command->run('Test');
		$this->assertTrue($result);

		$expected = "li3 test --case=CASE --group=GROUP --filters=FILTERS [ARGS]";
		$expected = preg_quote($expected);
		$result = $command->response->output;
		$this->assertPattern("/{$expected}/", $result);

		$expected = "OPTIONS\n    --case=CASE\n";
		$expected = preg_quote($expected);
		$result = $command->response->output;
		$this->assertPattern("/{$expected}/", $result);

		$expected = "missing\n";
		$expected = preg_quote($expected);
		$result = $command->response->output;
		$this->assertPattern("/{$expected}/", $result);
	}

	public function testApiClass() {
		$command = new Help(array(
			'request' => $this->request, 'classes' => $this->classes
		));
		$result = $command->api('lithium.util.Inflector');
		$this->assertNull($result);

		$expected = "Utility for modifying format of words";
		$expected = preg_quote($expected);
		$result = $command->response->output;
		$this->assertPattern("/{$expected}/", $result);
	}

	public function testApiMethod() {
		$command = new Help(array(
			'request' => $this->request, 'classes' => $this->classes
		));
		$result = $command->api('lithium.util.Inflector', 'method');
		$this->assertNull($result);

		$expected = "rules [type] [config]";
		$expected = preg_quote($expected);
		$result = $command->response->output;
		$this->assertPattern("/{$expected}/", $result);
	}

	public function testApiMethodWithName() {
		$command = new Help(array(
			'request' => $this->request, 'classes' => $this->classes
		));
		$result = $command->api('lithium.util.Inflector', 'method', 'rules');
		$this->assertNull($result);

		$expected = "rules [type] [config]";
		$expected = preg_quote($expected);
		$result = $command->response->output;
		$this->assertPattern("/{$expected}/", $result);
	}

	public function testApiProperty() {
		$command = new Help(array(
			'request' => $this->request, 'classes' => $this->classes
		));
		$result = $command->api('lithium.net.Message', 'property');
		$this->assertNull($result);

		$expected = "    --host=HOST\n        The hostname for this endpoint.";
		$expected = preg_quote($expected);
		$result = $command->response->output;
		$this->assertPattern("/{$expected}/", $result);
	}

	public function testApiPropertyWithName() {
		$command = new Help(array(
			'request' => $this->request, 'classes' => $this->classes
		));
		$result = $command->api('lithium.net.Message', 'property');
		$this->assertNull($result);

		$expected = "    --host=HOST\n        The hostname for this endpoint.";
		$expected = preg_quote($expected);
		$result = $command->response->output;
		$this->assertPattern("/{$expected}/", $result);
	}
}

?>