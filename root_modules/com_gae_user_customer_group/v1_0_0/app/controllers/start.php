<?php

class start extends base_module_controller
{
    public function index()
    {
        $this->render('start/list');
    }

    public function add()
    {
        $view_data = [
            'css' => [
                'autocomplete.css'
            ],
            'js' => [
                'third_party/autocomplete.js',
                'add/add.controller.js'
            ]
        ];
        $this->render('start/add', $view_data);
    }

    private function render($view_name, $view_data = [])
    {
        $content = [
            'content' => $this->mLoadView($view_name, null, true)
        ];
        $this->mLoadView('template', array_merge($content, $view_data));
    }
}
