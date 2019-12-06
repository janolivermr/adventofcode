<?php

namespace AoC;

use League\Csv\Reader;

abstract class PartWithInput
{
    protected \Iterator $records;

    public function __construct()
    {
        $reverse_path = preg_replace('/^AoC\\\\(.+)\\\\\w+$/', '$1', static::class);
        $path = implode(DIRECTORY_SEPARATOR, explode('\\', $reverse_path));
        try {
            $reader = Reader::createFromPath(__DIR__ . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . 'input');
            $this->records = $reader->getRecords();
        } catch (\League\Csv\Exception $e) {
            // Do nothing
        }
    }
}