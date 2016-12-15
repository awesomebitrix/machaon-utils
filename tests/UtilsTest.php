<?php 
	use PHPUnit\Framework\TestCase;
	use Machaon\Utils as Machaon;

	class UtilsTest extends TestCase
	{
		public function testConfigIni()
		{
			$fileName = __DIR__ . '/files/conf.ini';
			$this->checkValues($fileName);
		}

		public function testConfigXml()
		{
			$fileName = __DIR__ . '/files/conf.xml';
			$this->checkValues($fileName);	
		}

		public function testConfigPhp()
		{
			$fileName = __DIR__ . '/files/conf.php';
			$this->checkValues($fileName);
		}

		protected function checkValues($fileName)
		{
			$config = Machaon\config($fileName);
			$this->assertEquals('correct_val', $config['group2']['field']);
			$this->assertEquals('512', $config->group1->bar);
			$this->assertEquals('512', $config->group1->get('bar'));
			$this->assertEquals('not_found', $config->group1->get('bazzz', 'not_found'));
		}
	}