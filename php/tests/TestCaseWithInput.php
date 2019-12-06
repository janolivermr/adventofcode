<?php

namespace Tests;

use EmptyIterator;
use Iterator;
use League\Csv\Exception;
use League\Csv\Reader;
use PHPUnit\Framework\TestCase;

abstract class TestCaseWithInput extends TestCase
{
    protected function getInput(): Iterator
    {
        $reverse_path = preg_replace(
            '/^Tests\\\\(.+)\\\\(\w+)Test$/',
            '$1'.DIRECTORY_SEPARATOR.'$2.txt',
            static::class
        );
        $pathComponents = [
            __DIR__,
            '..',
            '..',
            'input',
        ];
        $path = implode(DIRECTORY_SEPARATOR, array_merge($pathComponents, explode('\\', $reverse_path)));
        try {
            $reader = Reader::createFromPath($path);
            return $reader->getRecords();
        } catch (Exception $e) {
            return new EmptyIterator();
        }
    }

    abstract public function testPartOne();

    abstract public function testPartTwo();
}