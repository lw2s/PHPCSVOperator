<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use PHPCSVOperator\FileManager;
use PHPCSVOperator\Operator;

class FileManagerTest extends TestCase
{
    public function testEnglishCsvFileImport()
    {
        $lines = FileManager::importFile(__dir__ . '/file/en/test.csv');
        $this->assertTrue(isset($lines));
        $this->assertSame(5, count($lines));
        $this->assertEquals('id', $lines[0]['id']);
        $this->assertSame('1', $lines[1]['id']);
        $this->assertEquals('name', $lines[0]['name']);
        $this->assertEquals('foo', $lines[1]['name']);
        $this->assertEquals('price', $lines[0]['price']);
        $this->assertSame('12000000', $lines[1]['price']);
    }

    public function testJapaneseCsvFileImport()
    {
        $lines = FileManager::importFile(__dir__ . '/file/ja/test.csv');
        $this->assertTrue(isset($lines));
        $this->assertEquals(5, count($lines));
        $this->assertEquals('id', $lines[0]['id']);
        $this->assertSame('1', $lines[1]['id']);
        $this->assertEquals('名前', $lines[0]['名前']);
        $this->assertEquals('フー', $lines[1]['名前']);
        $this->assertEquals('金額', $lines[0]['金額']);
        $this->assertSame('12000000', $lines[1]['金額']);
    }

    public function testNotReadCsvFileThrowsException()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('not read csv file.');
        FileManager::importFile(__dir__ . '/file/ja/aaa.csv');
    }

    public function testNotFoundCsvFileThrowsException()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('not found csv file.');
        FileManager::importFile();
    }
}
