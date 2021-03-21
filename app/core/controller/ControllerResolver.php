<?php
declare(strict_types=1);

namespace App\Core\Controller;

use App\Exception\UrlException;

/**
 * Class used to find the controller
 * 
 * @author ondra
 */
class ControllerResolver
{
    
    /**
     * Finds controller     
     * @param string $controllerName
     * @param string $actionName
     * @param array $params
     * @return void
     * @throws UrlException
     */
    public static function findController(string $controllerName, string $actionName, array $params): void
    {
        $class = "App\Controllers\\" . $controllerName . "Controller";
        if(!class_exists($class)) {
            throw new UrlException("Page not found!");
        }
        
        $controller = new $class(); //TODO Solve constructor dependencies
        if ($controller instanceof Controller == false) {
            throw new UrlException("Controller is not child of App\Core\Controller\Controller!");
        }
        $controller->startup();

        $methodAction = "action" . $actionName;
        $methodRender = "render" . $actionName;
       
        if (\method_exists($controller, $methodAction)) {
            self::callMethod($controller, $methodAction, $params);
        }
        if (\method_exists($controller, $methodRender)) {
            self::callMethod($controller, $methodRender, $params);
        }

        //TODO move to View
        $viewName = \strtolower($actionName);
        $viewPath = \VIEW_DIR . $controllerName . "/" . $viewName . ".php";        
        if (!\file_exists($viewPath)) {
            throw new UrlException("View file is missing!");
        }
              
    }


    /**     
     * Call controller mathod
     * @param Controller $controller
     * @param string $name
     * @param array $params
     * @return void
     * @throws UrlException
     */
    private static function callMethod(Controller $controller, string $name, array $params): void
    {
        if (!\method_exists($controller, $name)) {
            throw new UrlException("Action not found!");
        }

        $args = self::getFuncArgNames($controller, $name);

        $parameters = [];
        foreach ($args as $arg) {
            if (!isset($params[$arg])) {
                throw new UrlException("Missing argument!");
            }
            $parameters[$arg] = $params[$arg];
        }

        call_user_func_array(array($controller, $name), $parameters);
    }


    private static function getFuncArgNames(Controller $controller, string $funcName): array
    {
        $f = new \ReflectionMethod(get_class($controller), $funcName);
        $result = array();
        foreach ($f->getParameters() as $param) {
            $result[] = $param->name;   
        }
        return $result;
    }
}
