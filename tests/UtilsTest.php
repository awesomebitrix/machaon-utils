<?php 
	use PHPUnit\Framework\TestCase;
	use Machaon\Utils as Machaon;

	class UtilsTest extends TestCase
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
			$this->expectException(Exception::class);
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
			$this->expectException(Exception::class);
			$logger = Machaon\logger('test');
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