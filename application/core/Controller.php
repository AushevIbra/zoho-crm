<?php
namespace application\core;
use application\core\View;
use application\lib\ZohoCrm;
abstract class Controller {
    public $route;
    public $view;
    public $zoho;
    public function __construct($route)
    {
       $this->route = $route;
       $this->view = new View($route);
       $this->zoho = new ZohoCrm();

    }



}
