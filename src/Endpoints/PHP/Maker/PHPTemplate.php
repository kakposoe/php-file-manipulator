<?php

namespace PHPFileManipulator\Endpoints\PHP\Maker;

use Illuminate\Support\Str;

class PHPTemplate
{
    protected $options = [];

    public static function make(...$args)
    {
        return new static(...$args);
    }

    public function in($file)
    {
        $this->file = $file;
        return $this;
    }

    public function get()
    {
        $file = $this->file->fromString(
            $this->contents()
        );

        $file->outputDriver(
            $this->outputDriver()
        );

        return $file;           
    }

    protected function outputDriver()
    {
        $outputDriverClass = config('php-file-manipulator.output', \PHPFileManipulator\Drivers\FileOutput::class);
        $outputDriver = new $outputDriverClass;
        $outputDriver->filename = $this->filename();
        $outputDriver->extension = $this->extension();
        $outputDriver->relativeDir = $this->relativeDir();

        return $outputDriver;
    }    

    protected function extension()
    {
        return 'php';
    }

    protected function contents()
    {
        $contents = file_get_contents($this->stubPath());
        $contents = $this->populate($contents);

        return $contents;
    }

    protected function populate($contents)
    {
        return $contents;
    }

    protected function stubPath()
    {
        // HAS PUBLISHED ?

        // ELSE USE DEFAULT
        $name = $this->stub;
        return __DIR__ . '/stubs/' . $name;
    }    
}