<?php

class Start extends base_module_controller
{
    public function index()
    {
        $this->render('start/list');
    }

    public function add()
    {
        $view_data = [
            'css' => [
                'base.css',
                'datepicker.min.css'
            ],
            'js' => [
                'bootstrap-datepicker.min.js',
                'bootstrap-datepicker.th.js',
                'angular-file-model-min.js',
                'user-customer.js'
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
