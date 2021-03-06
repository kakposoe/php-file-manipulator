<?php

namespace PHPFileManipulator\Endpoints\PHP;

use PHPFileManipulator\Endpoints\EndpointProvider;
use PhpParser\BuilderFactory;

class Namespace_ extends EndpointProvider
{
    public function namespace($value = null)
    {
        if($this->file->directive('remove')) return $this->remove();

        if($value === null) return $this->get();

        return $this->set($value);
    }

    protected function get()
    {
        return $this->file->astQuery()
            ->namespace()
            ->remember('formatted_namespace', function($node) {
                $parts = $node->name->parts ?? null;
                return $parts ? join('\\', $parts) : null;
            })
            ->recall()
            ->pluck('formatted_namespace')
            ->first();
    }

    protected function set($newNamespace)
    {
        $namespace = $this->file->astQuery()
            ->namespace()
            ->first();        
        
        if($namespace) {
            // Modifying existing namespace
            $namespace->name->parts = explode("\\", $newNamespace);
        } else {
            // Add a namespace
            $ast = $this->file->ast();
            array_unshift(
                $ast,
                (new BuilderFactory)->namespace($newNamespace)->getNode()
            );

            $this->file->ast($ast);
        }
        
        return $this->file->continue();
    }

    protected function remove()
    {
        $namespace = $this->file->astQuery()->namespace()->first();
        
        // using remove()->namespace() should NOT remove underlying statements
        // humans would not expect that
        // instead just unwrap the statements
        // this assumes 0 or 1 namespaces
        if($namespace) $this->file->ast($namespace->stmts);

        return $this->file->continue();
    }    
}