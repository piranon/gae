<?php

class Start extends base_module_controller
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
                'datepicker.min.css'
            ],
            'js' => [
                'third_party/bootstrap-datepicker.min.js',
                'third_party/bootstrap-datepicker.th.js',
                'add/add.controller.js',
                'add/add.common.js'
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
