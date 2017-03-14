<?php

require __DIR__ . '/../vendor/autoload.php';

use kongr45gpen\EasyCi\Build;
use Symfony\Component\Console\Output\ConsoleOutput;

$config = __DIR__ . '/build.yml';
$output = new ConsoleOutput();
$output->writeln("<info>Build starting</info>");

$build = new Build($config);
$build->setOutput($output);
if ($build->start()) {
    $output->writeln("<info>Build successful</info>");
} else {
    $output->writeln("<error>Build errored</error>");
}