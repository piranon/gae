<?php

class Start extends base_module_controller
{
    public function index()
    {
        $view_data = [
            'css' => [
                'tinycolorpicker.css'
            ],
            'js' => [
                'third_party/jquery.tinycolorpicker.min.js',
                'components/fileread.directive.js',
                'services/focus.service.js',
                'list/list.controller.js'
            ]
        ];
        $this->render('start/list', $view_data);
    }

    private function render($view_name, $view_data = [])
    {
        $content = [
            'content' => $this->mLoadView($view_name, null, true)
        ];
        $this->mLoadView('template', array_merge($content, $view_data));
    }
}
