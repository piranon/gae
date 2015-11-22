<?php

class start extends base_module_controller
{
    public function index()
    {
        $view_data = [
            'js' => [
                'list/list.controller.js'
            ]
        ];
        $this->render('start/list', $view_data);
    }

    public function add()
    {
        $view_data = [
            'css' => [
                'autocomplete.css'
            ],
            'js' => [
                'add/add.controller.js'
            ]
        ];
        $this->render('start/add', $view_data);
    }

    public function detail()
    {
        $view_data = [
            'js' => [
                'detail/detail.controller.js'
            ]
        ];
        $this->render('start/detail', $view_data);
    }

    private function render($view_name, $view_data = [])
    {
        $content = [
            'content' => $this->mLoadView($view_name, null, true)
        ];
        $this->mLoadView('template', array_merge($content, $view_data));
    }
}
