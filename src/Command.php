<?php declare(strict_types=1);

namespace PHPCSVOperator;

use PHPCSVOperator\FileManager;

class Command
{
    private $lines;
    private $groupedLines;

    /**
     * @param array $lines
     */
    public function __construct($lines)
    {
        $this->lines = $lines;
    }

    /**
     * @param array $parameters
     * @return array
     */
    public function search($parameters): array
    {
        $parameterKeys = array_keys($parameters);
        $keys = array_keys($this->lines[0], $parameterKeys[0]);
        $lines = array_column($this->lines, $keys[0]);
        foreach ($parameters as $parameter) {
            if (in_array($parameter, $lines)) {
                $key = array_search($parameter, $lines);

                return $this->lines[$key];
            }
        }
    }

    /**
     * @param array $parameter
     * @return self
     */
    public function group($parameter): self
    {
        $line = array_column($this->lines, key($parameter));
        $key = array_keys($line, $parameter[key($parameter)]);

        $groupedLines = [];
        foreach ($key as $value) {
            $groupedLines[] = $this->lines[$value];
        }
        $this->groupedLines = $groupedLines;

        return $this;
    }

    /**
     * @return int
     */
    public function countRow(): int
    {
        if (isset($this->groupedLines)) {
            return count($this->groupedLines);
        } else {
            return count($this->lines);
        }
    }

    /**
     * export csv file
     */
    public function export()
    {
        $filename = dirname(__dir__, 1) . '/export/export.csv';
        $fp = fopen($filename, 'w');
        if ($fp == false) {
            throw new \Exception('can not open the file');
        }

        foreach ($this->lines as $row) {
            fputcsv($fp, $row);
        }

        fclose($fp);
    }

    /**
     * export sjis csv file
     */
    public function exportJa()
    {
        $filename = dirname(__dir__, 1) . '/export/exportJa.csv';
        $fp = fopen($filename, 'w');
        if ($fp == false) {
            throw new \Exception('can not open the file');
        }

        foreach ($this->lines as $row) {
            fputcsv($fp, $row);
        }

        fclose($fp);
    }
}
