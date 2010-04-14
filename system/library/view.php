<?php

class View
{
    private
      $vars = array(),
      $views = array();

    protected
      $view_path,
      $structure,
      $config;

    public function __construct()
    {
        $this->config = get_config();

        $view_path  = $this->config->get('path.system');
        $view_path .= $this->config->get('path.views');

        $this->view_path = $view_path;
    }

    public function add($view)
    {
        $this->views[] = $view;
    }

    public function assign($var_name, $var_val)
    {
        $this->vars[$var_name] = $var_val;
    }

    public function setStructure($structure)
    {
        if (file_exists($this->view_path . '/' . $structure))
        {
            $this->structure = $structure;
        }
    }

    public function output()
    {
        extract($this->vars);

        foreach ($this->views as $view)
        {
            $path = !empty($this->structure) ? $this->view_path . '/' . $this->structure : $this->view_path;

            include $path .'/' . $view . '.php';
        }
    }

}

?>
