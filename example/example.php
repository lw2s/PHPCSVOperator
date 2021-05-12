<?php
require '../vendor/autoload.php';

$lines = PHPCSVOperator\Operator::import('example.csv');
$result = PHPCSVOperator\Operator::execute($lines)->search(['name' => 'foo']);

print_r($result);
