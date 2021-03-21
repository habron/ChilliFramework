<?php
declare(strict_types=1);

namespace App\Core\Url;

/**
 * Class used to resolve URL address
 * 
 * @author ondra
 */
class UrlResolver
{

    private static string $controller = \DEFAULT_CONTROLLER;

    private static string $action = \DEFAULT_ACTION;

    private static array $params = [];


    /**
     * Returns controller name
     * @return string
     */
    public static function getController(): string
    {
        return self::$controller;
    }


    /**
     * Returns action name     
     * @return string
     */
    public static function getAction(): string
    {
        return self::$action;
    }


    /**
     * Returns params     
     * @return array
     */
    public static function getParams(): array
    {
        return self::$params;
    }


    /**
     * Resolves url
     * @param string $url
     * @return void
     */
    public static function resolve(string $url): void
    {
        $counter = 0;
        foreach (explode("/", $url) as $part) {
            if (!empty($part)) {
                switch ($counter) {
                    case 1:
                        self::$controller = \ucfirst($part);
                        break;
                    case 2:
                        self::$action = \ucfirst($part);
                        break;
                    case 3:
                        self::resolveParameters($part);
                        break;
                }
            }

            $counter++;
        }
    }


    /**
     * Resolves url parameters
     *
     * @param string $params
     * @return void
     */
    private static function resolveParameters(string $params): void
    {
        if (\strpos($params, "?") === false) {
            self::$params[\DEFAULT_PARAM] = $params;
            return;
        }

        self::$params[\DEFAULT_PARAM] = \substr($params, 0, strpos($params, "?"));

        $otherParams = \substr($params, strpos($params, "?") + 1);

        foreach (explode("&", $otherParams) as $param) {
            $parts = explode("=", $param);
            self::$params[$parts[0]] = $parts[1];
        }
    }
}
