<?php declare(strict_types=1);

namespace PHPCSVOperator;

class FileManager
{
    /**
     * import csvfile
     *
     * @param string $csvfile
     * @return array shapedlines
     */
    public static function importFile($csvfile = null): array
    {
        if (is_null($csvfile)) {
            throw new \RuntimeException('not found csv file.');
        }

        if (!is_readable($csvfile)) {
            throw new \RuntimeException('not read csv file.');
        }

        $lines = file($csvfile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        return self::shape($lines);
    }

    /**
     * @param string $line
     * @return string
     */
    private static function trimNewLineCharacter($line): string
    {
        return str_replace(["\r\n","\r","\n"], '', $line);
    }

    /**
     * @param string $line
     * @return string
     */
    private static function trimQuote($line): string
    {
        return str_replace('"', '', $line);
    }

    /**
     * @param string $line
     * @param string $header
     */
    private static function linesToArray($line, $header): array
    {
        if (strpos($header[0], ';') !== false) {
            $line = explode(";", $line);
            $header = explode(";", $header[0]);
        } else {
            $line = explode(",", $line);
            $header = explode(",", $header[0]);
        }
        $result = [];
        foreach ($header as $key => $column) {
            $result[$column] = $line[$key];
        }

        return $result;
    }

    /**
     * @param array $lines
     * @return array $shapedLines
     */
    public static function shape($lines): array
    {
        $shapedLines = [];
        $header = [];
        foreach ($lines as $key => $line) {
            $line = self::trimNewLineCharacter($line);

            if ($key === 0) {
                if (strpos($line, '"') !== false) {
                    $line = self::trimQuote($line);
                }

                $header[] = $line;
            }

            $line = preg_replace_callback(
                '/"(.+?)"/',
                function ($matches) {
                    return str_replace(',', '', $matches[1]);
                },
                $line
            );

            $shapedLines[] = self::linesToArray($line, $header);
        }

        return $shapedLines;
    }
}
