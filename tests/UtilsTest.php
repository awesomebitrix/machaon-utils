<?php 
	namespace Machaon\Utils\Tests;

	use \PHPUnit\Framework\TestCase;
	use \Symfony\Component\VarDumper\VarDumper;
	use \Machaon\Utils as Machaon;

	class FunctionsTest extends TestCase
	{
		public function testConfigIni()
		{
			$fileName = __DIR__ . '/files/conf.ini';
			$this->checkConfigValues($fileName);
		}

		public function testConfigXml()
		{
			$fileName = __DIR__ . '/files/conf.xml';
			$this->checkConfigValues($fileName);	
		}

		public function testConfigPhp()
		{
			$fileName = __DIR__ . '/files/conf.php';
			$this->checkConfigValues($fileName);
		}

		public function testConfigException()
		{
			$this->expectException(\Exception::class);
			$fileName = __DIR__ . '/files/not_existing_file.php';
			$config = Machaon\config($fileName);
		}

		public function testConfigTypeof()
		{
			$fileName = __DIR__ . '/files/conf.ini';
			$config = Machaon\config($fileName);
			$this->assertInstanceOf(\Zend\Config\Config::class, $config);
		}

		public function testLogger()
		{
			$logFile = __DIR__ . '/files/test.log';
			$logger = Machaon\logger('test', $logFile);
			$this->assertInstanceOf(\Monolog\Logger::class, $logger);
 
			$handle = fopen($logFile, 'w');
			fclose($handle);

			$logger->debug('test message', array('foo' => 'bar'));
			$this->assertStringNotEqualsFile($logFile, '');

			$handle = fopen($logFile, 'w');
			fclose($handle);
		}

		public function testLoggerException()
		{
			$this->expectException(\Exception::class);
			$logger = Machaon\logger('test');
		}

		public function testStartsWith()
		{
			$this->assertTrue(Machaon\starts_with('foobar', 'foo'));
			$this->assertTrue(Machaon\starts_with('foobar', 'f'));
			$this->assertTrue(Machaon\starts_with('foobar', 'foobar'));
			$this->assertFalse(Machaon\starts_with('foobar', 'foobarbaz'));
			$this->assertFalse(Machaon\starts_with('', 'foo'));
			$this->assertFalse(Machaon\starts_with('foo', ''));
			$this->assertFalse(Machaon\starts_with('foo', null));
			$this->assertFalse(Machaon\starts_with(null, 'foo'));
			$this->assertFalse(Machaon\starts_with(null, null));
			$this->assertFalse(Machaon\starts_with('', ''));
		}

		public function testEndsWith()
		{
			$this->assertTrue(Machaon\ends_with('foobar', 'bar'));
			$this->assertTrue(Machaon\ends_with('foobar', 'r'));
			$this->assertTrue(Machaon\ends_with('foobar', 'foobar'));
			$this->assertFalse(Machaon\ends_with('foobar', 'foobarbaz'));
			$this->assertFalse(Machaon\ends_with('foobar', 'bazfoobar'));
			$this->assertFalse(Machaon\ends_with('', 'foo'));
			$this->assertFalse(Machaon\ends_with('foo', ''));
			$this->assertFalse(Machaon\ends_with('foo', null));
			$this->assertFalse(Machaon\ends_with(null, 'foo'));
			$this->assertFalse(Machaon\ends_with(null, null));
			$this->assertFalse(Machaon\ends_with('', ''));
		}

		public function testPlainFunctions()
		{
			$functionNames = array(
				'config', 'asset', 'logger', 'starts_with', 'ends_with',
				'd', 'dd', 'da', 'dda'
			);

			foreach ($functionNames as $fn) {
				$this->assertTrue(function_exists($fn));
			}
		}

		public function testDumps()
		{
			// just test functions exists and callable
			$this->assertNull(Machaon\d());
			$this->assertNull(Machaon\da());
		}

		protected function checkConfigValues($fileName)
		{
			$config = Machaon\config($fileName);
			$this->assertEquals('correct_val', $config['group2']['field']);
			$this->assertEquals('512', $config->group1->bar);
			$this->assertEquals('512', $config->group1->get('bar'));
			$this->assertEquals('not_found', $config->group1->get('bazzz', 'not_found'));
		}
	}