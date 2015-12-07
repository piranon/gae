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
            'js' => [
                'add/add.controller.js'
            ]
        ];
        $this->render('start/add', $view_data);
    }

    private function render($view_name, $view_data = [])
    {
        $myData['myData'] = [
            'owner_id' => $this->currentOwnerId(),
            'staff_id' => $this->currentStaffId()
        ];
        $content = [
            'content' => $this->mLoadView($view_name, $myData, true)
        ];
        $this->mLoadView('template', array_merge($content, $view_data));
    }
}
