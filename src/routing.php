<?php
/**
 * This file dispatch routes.
 *
 * PHP version 7
 *
 * @author   WCS <contact@wildcodeschool.fr>
 *
 * @link     https://github.com/WildCodeSchool/simple-mvc
 */

$routeParts = explode('/', ltrim($_SERVER['REQUEST_URI'], '/') ?: HOME_PAGE);
$controller = 'App\Controller\\' . ucfirst($routeParts[0] ?? '') . 'Controller';
$method = $routeParts[1] ?? '';
$vars = array_slice($routeParts, 2);

if (class_exists($controller) && method_exists(new $controller(), $method)) {
    if ($controller === 'App\Controller\AdminController') {
        if (empty($_SESSION['role_user']) || $_SESSION['role_user'] !== 'ROLE_ADMIN') {
            header('Location: /user/signIn');
            exit();
        }
    }
    if ($controller === 'App\Controller\SheetController' && empty($_SESSION['role_user'])) {
        header('Location: /user/signIN');
        exit();
    }
    echo call_user_func_array([new $controller(), $method], $vars);
} else {
    header('HTTP/1.0 404 Not Found');
    echo call_user_func_array([new App\Controller\HomeController(), 'error'], [404]);
    exit();
}
