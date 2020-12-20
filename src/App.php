<?php

namespace Andrey;

use FaaPz\PDO\Clause\Limit;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__.'/../vendor/autoload.php';
$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/../.env');
$connection = new Connection();
$pdo = $connection->getPdo();

function convert($size)
{
    $unit=array('b','kb','mb','gb','tb','pb');

    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}



echo '#1 Плохой метод, выбираем сразу все записи' . PHP_EOL;
/*$begin = microtime(true);
$selectStatement = $pdo->select()
    ->from('random_records');

$stmt = $selectStatement->execute();
$data = $stmt->fetchAll();
while($row = $stmt->fetch()) {
    substr($row['text'], 0, 4);
}

echo convert(memory_get_usage()) . PHP_EOL;
$end = microtime(true);
echo ($end - $begin) . ' seconds' . PHP_EOL;*/

function getMillionRecords($pdo)
{
    echo '#3 Методика использования генератора' . PHP_EOL;
    $begin = microtime(true);
    $step = 0;
    $size = 10000;
    $data = [];
    while (true) {
        $selectStatement = $pdo->select()
            ->from('random_records')
            ->limit(new Limit($size, $step * $size));

        $stmt = $selectStatement->execute();
        if ($stmt->rowCount() === 0) {
            break;
        }
        echo convert(memory_get_usage()) . PHP_EOL;
        while ($row = $stmt->fetch()) {
            yield $row['text'];
        }

        $step++;
    }

    echo convert(memory_get_usage()) . PHP_EOL;
    $end = microtime(true);
    echo ($end - $begin) . ' seconds' . PHP_EOL;

    return $data;
}
/////////////////////////////////////////////////////////////////////
foreach(getMillionRecords($pdo) as $text) {
    substr($text, 0, 4);
}










