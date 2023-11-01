<?php

namespace Controllers;

use Exception;
use PHPJasper\PHPJasper;

class JasperReportController
{
    private $jasper;
    public function __construct(string $reportBaseDir, string $fileName)
    {
        $jasper = new PHPJasper();
        $inputFile = $reportBaseDir . $fileName . ".jrxml";
        $jasper->compile($inputFile)->execute();
        $input = $reportBaseDir . $fileName . ".jasper";
        $output = $reportBaseDir;
        $options = [
            'format' => ['pdf', 'xlsx', 'html', 'csv'],
            'locale' => 'en',
            'params' => [],
            'db_connection' => [
                'driver' => 'mysql',
                'username' => 'root',
                'host' => 'localhost',
                'port' => '3306',
                'database' => '3lm',
            ]
        ];
        try {
            $jasper->process($input, $output, $options)->execute();
        } catch (Exception $err) {
            echo $err;
        }
    }
}
