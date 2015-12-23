<?php

class Start extends base_module_controller
{
    public function index()
    {
        $view_data = [
            'js' => [
                'components/fileread.directive.js',
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
