<?php 
namespace application\core;

class View {
    public $path;
    public $layout = 'default';
    public $route;
    public function __construct($route)
    {
      $this->route = $route;
      $this->path = $route['controller'] . '/' . $route['action'];
    }

    public function render($title, $vars = [])
    {
        
        if(file_exists('application/views/' . $this->path . '.php')){
            extract($vars);
            ob_start();
            require 'application/views/' . $this->path . '.php';
            $content = ob_get_clean();
            require 'application/views/layouts/' . $this->layout . '.php'; 
        } else {
            echo 'Вид не найден';
        }
        
    }
}