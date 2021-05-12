<?php declare(strict_types=1);

namespace PHPCSVOperator;

use PHPCSVOperator\FileManager;
use PHPCSVOperator\Command;

class Operator
{
    public static function import(string $csvfile = null): array
    {
        $lines = FileManager::importFile($csvfile);

        return $lines;
    }

    public static function execute(array $lines): Command
    {
        return new Command($lines);
    }
}
