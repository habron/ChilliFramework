<?php

namespace App\Core\Controller;

/**
 * Abstract controller
 * 
 * @author ondra
 */
abstract class Controller
{

    protected \StdClass $template;

    private bool $startupError = true;


    /**
     * Startup function
     * @return void
     */
    public function startup(): void
    {
        $this->startupError = false;
    }


    /**
     * Return template attributes as \StdClass     
     * @return \StdClass
     */
    public function getTemplate(): \StdClass
    {
        return $this->template;
    }
   

    public function __destruct()
    {
        if ($this->startupError) {
            throw new \Exception("Parent method startup() was not called.");
        }
    }

}
