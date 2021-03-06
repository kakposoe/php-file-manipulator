<?php

namespace PHPFileManipulator\Tests\Unit\Endpoints;

use PHPFileManipulator\Tests\FileTestCase;

use PHPFile;
use LaravelFile;

class ClassExtendsTest extends FileTestCase
{
    /** @test */
    public function it_can_retrieve_class_extends()
    {
        $file = PHPFile::load('app/User.php');

        $this->assertTrue(
            $file->extends() === 'Authenticatable'
        );
    }

    /** @test */
    public function it_can_set_class_implements()
    {
        $file = PHPFile::load('app/User.php')->extends("My\BaseClass");

        $this->assertTrue(
            $file->extends() === "My\BaseClass"
        );
    } 
}