<?php declare(strict_types=1);

namespace PHPCSVOperator;

use PHPCSVOperator\FileManager;
use PHPCSVOperator\Command;

class Operator
{
    /**
     * @param string $csvfile
     * @return array $lines
     */
    public static function import(string $csvfile = null): array
    {
        $lines = FileManager::importFile($csvfile);

        return $lines;
    }

    /**
     * @param array $lines
     * @return Command
     */
    public static function execute(array $lines): Command
    {
        return new Command($lines);
    }
}
