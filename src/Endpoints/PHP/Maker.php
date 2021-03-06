<?php

namespace PHPFileManipulator\Endpoints\PHP;

use PHPFileManipulator\Endpoints\EndpointProvider;
use PHPFileManipulator\Endpoints\PHP\Maker\Empty_;
use PHPFileManipulator\Endpoints\PHP\Maker\Class_;
use PHPFileManipulator\Support\URI\UriFactory;
use PHPFileManipulator\PHPFile;


class Maker extends EndpointProvider
{
    protected $filename;
    protected $extension = '.php';
    protected $relativeDir = '';

    protected function setupNames($name)
    {
        $this->uri = UriFactory::make($name); // TODO
        $this->filename = $name;
        $this->namespace = 'Some\App\\Namespaze';
        $this->class = $name;        
    }

    public function file($name)
    {
        return Empty_::make($name)->in($this->file)->get();
    }

    public function class($name)
    {
        return Class_::make($name)->in($this->file)->get();
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

    protected function filename()
    {
        return $this->filename;
    }

    protected function extension()
    {
        return $this->extension;        
    }
    
    protected function relativeDir()
    {
        return $this->relativeDir;        
    }    
}