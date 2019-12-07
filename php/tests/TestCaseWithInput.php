<?php

namespace Tests;

use EmptyIterator;
use Iterator;
use League\Csv\Exception;
use League\Csv\Reader;
use PHPUnit\Framework\TestCase;

abstract class TestCaseWithInput extends TestCase
{
    protected string $year;
    protected string $day;
    protected string $path;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $reverse_path = preg_replace(
            '/^Tests\\\\(.+)\\\\(\w+)Test$/',
            '$1|$2',
            static::class
        );
        list($year, $day) = explode('|', $reverse_path);
        $pathComponents = [
            __DIR__,
            '..',
            '..',
            'input',
            $year,
            $day,
        ];
        $path = implode(DIRECTORY_SEPARATOR, $pathComponents).'.txt';
        $this->year = $year;
        $this->day = $day;
        $this->path = $path;
    }

    protected function getInput(): Iterator
    {
        try {
            $reader = Reader::createFromPath($this->path);
            return $reader->getRecords();
        } catch (Exception $e) {
            return new EmptyIterator();
        }
    }

    abstract public function runPartOne();

    abstract public function runPartTwo();

    public function testWithInput()
    {
        $this->assertTrue(true);
        echo sprintf("\nResult for %s, %s, Part One:\n\t%s\n", $this->year, $this->day, $this->runPartOne());
        echo sprintf("\nResult for %s, %s, Part Two:\n\t%s\n", $this->year, $this->day, $this->runPartTwo());
    }
}