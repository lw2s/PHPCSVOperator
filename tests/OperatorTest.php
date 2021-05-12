<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use PHPCSVOperator\Operator;
use PHPCSVOperator\FileManager;
use PHPCSVOperator\Command;

class OperatorTest extends TestCase
{
    public function testCreateCommandInstance()
    {
        $lines = Operator::import(__dir__ . '/file/en/test.csv');
        $commandInstance = Operator::execute($lines);
        $this->assertTrue($commandInstance instanceof Command);
    }

    public function testUseSearch()
    {
        $lines = Operator::import(__dir__ . '/file/en/test.csv');
        $result = Operator::execute($lines)->search(['id' => 1]);
        $this->assertTrue(isset($result));
        $this->assertSame('1', $result['id']);
    }

    public function testGroupColumn()
    {
        $lines = Operator::import(__dir__ . '/file/en/test.csv');
        $rowNum = Operator::execute($lines)->group(['id' => 1])->countRow();
        $this->assertEquals(2, $rowNum);
    }

    public function testGroupToSearch()
    {
        $lines = Operator::import(__dir__ . '/file/en/test.csv');
        $line = Operator::execute($lines)->group(['id' => 1])->search(['name' => 'foo']);
        $this->assertTrue(isset($line));
    }

    public function testExportToCsvFile()
    {
        $exportDir = dirname(__DIR__) . '/export';
        $this->assertTrue(is_dir($exportDir));
        $lines = Operator::import(__dir__ . '/file/en/test.csv');
        Operator::execute($lines)->export();
        $this->assertTrue(is_readable($exportDir . '/export.csv'));
        $this->assertTrue(unlink($exportDir . '/export.csv'));
    }

    public function testExportToSjisCsvFile()
    {
        $exportDir = dirname(__DIR__) . '/export';
        $this->assertTrue(is_dir($exportDir));
        $lines = Operator::import(__dir__ . '/file/en/test.csv');
        Operator::execute($lines)->export();
        $this->assertTrue(is_readable($exportDir . '/export.csv'));
        $this->assertTrue(unlink($exportDir . '/export.csv'));
    }
}
