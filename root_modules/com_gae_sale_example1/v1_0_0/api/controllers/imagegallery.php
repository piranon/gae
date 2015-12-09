<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class imagegallery extends base_module_controller {

    public function  sortby(){
        $this->load->model("root_imagegallery_model");
        $sortbyData = $this->root_imagegallery_model->getSortby();
        resOk($sortbyData);
    }

    public function  lists(){
        $this->load->library('form_validation');
        $this->form_validation->allRequest();
        $this->form_validation->set_rules('cur_page','trim|required|numeric');
        $this->form_validation->set_rules('per_page','trim|required|numeric');
        $this->form_validation->set_rules('txt_sortby','trim|option');
        $this->formCheck();

        $cur_page = t_Request("cur_page");
        $per_page = t_Request("per_page");
        $txt_sortby = t_Request("txt_sortby");

        $this->load->model("root_imagegallery_model");
        $sortby_id = $this->root_imagegallery_model->getSortbyId($txt_sortby);

        $whereStr = "";
        $paramAr = array();

        $total_row = $this->root_imagegallery_model->getListsTotalRow($whereStr,$paramAr);
        $data_list_ar = $this->root_imagegallery_model->getLists($whereStr,$paramAr,$cur_page,$per_page,$sortby_id);

        $dataSend = dataListSendFormat($total_row,$data_list_ar,$cur_page,$per_page,$sortby_id);
        resOk($dataSend);
    }

    public function  search(){
        $this->load->library('form_validation');
        $this->form_validation->allRequest();
        $this->form_validation->set_rules('txt_search','trim|required');
        $this->form_validation->set_rules('cur_page','trim|required|numeric');
        $this->form_validation->set_rules('per_page','trim|required|numeric');
        $this->form_validation->set_rules('txt_sortby','trim|option');
        $this->formCheck();

        $txt_search = t_Request("txt_search");
        $cur_page = t_Request("cur_page");
        $per_page = t_Request("per_page");
        $txt_sortby = t_Request("txt_sortby");

        $this->load->model("root_imagegallery_model");
        $sortby_id = $this->root_imagegallery_model->getSortbyId($txt_sortby);

        $whereStr = " imagegallery.name LIKE ? ";
        $paramAr = array("%".$txt_search."%");

        $total_row = $this->root_imagegallery_model->getListsTotalRow($whereStr,$paramAr);
        $data_list_ar = $this->root_imagegallery_model->getLists($whereStr,$paramAr,$cur_page,$per_page,$sortby_id);

        $dataSend = dataListSendFormat($total_row,$data_list_ar,$cur_page,$per_page,$sortby_id);
        resOk($dataSend);
    }

    public function  id(){
        $this->load->library('form_validation');
        $this->form_validation->allRequest();
        $this->form_validation->set_rules('txt_imagegallery_id','trim|required|numeric');
        $this->formCheck();

        $txt_imagegallery_id = t_Request("txt_imagegallery_id");

        $this->load->model("root_imagegallery_model");
        $result = $this->root_imagegallery_model->getId($txt_imagegallery_id);
        resOk($result);
    }

    public function  add(){

        $this->load->library('form_validation');
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('txt_name','trim|required');
        $this->form_validation->set_rules('txt_title','trim');
        $this->form_validation->set_rules('txt_description','trim');
        $this->formCheck();

        $dbData["name"] = t_Post("txt_name");
        $dbData["title"] = t_Post("txt_title");
        $dbData["description"] = t_Post("txt_description");

        $this->load->model("root_imagegallery_model");
        $newImageGalleryId = $this->root_imagegallery_model->add($dbData);
        $imageGalleryData = $this->root_imagegallery_model->getId($newImageGalleryId);
        resOk($imageGalleryData);
    }

    public function  edit(){
        $this->load->library('form_validation');
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('txt_imagegallery_id','trim|required|numeric');
        $this->form_validation->set_rules('txt_name','trim|required');
        $this->form_validation->set_rules('txt_title','trim');
        $this->form_validation->set_rules('txt_description','trim');
        $this->formCheck();

        $imagegallery_id = t_Post("txt_imagegallery_id");
        $dbData["name"] = t_Post("txt_name");
        $dbData["title"] = t_Post("txt_title");
        $dbData["description"] = t_Post("txt_description");

        $this->load->model("root_imagegallery_model");
        $updateResult = $this->root_imagegallery_model->edit($dbData,$imagegallery_id);
        resOk($updateResult);
    }

    public function  delete(){
        $this->load->library('form_validation');
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('txt_delete_json','trim|required');
        $this->formCheck();

        $daleteId_array = json_decode(t_Post("txt_delete_json"),true);

        $this->load->model("root_imagegallery_model");
        $deleteResult = $this->root_imagegallery_model->delete($daleteId_array);
        resOk($deleteResult);
    }

    public function  upload_image(){
        $this->load->library('form_validation');
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('txt_imagegallery_id','trim|required|numeric');
        $this->form_validation->requireFile('image_files');
        $this->formCheck();

        $imagegallery_id = t_Post("txt_imagegallery_id");
        
        $this->load->model("root_imagegallery_model");
        $imagegallerData = $this->root_imagegallery_model->getId($imagegallery_id);

        $dbData["imagegallery_id"] = $imagegallerData["imagegallery_id"];
        $this->load->model("root_image_model");
        $uploadData = $this->root_image_model->uploadWithData('image_files',$dbData,6);
        resOk($uploadData);

    }

}

?>