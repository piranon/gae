<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class image extends base_module_controller {

    public function  sortby(){
        $this->load->model("root_image_model");
        $sortbyData = $this->root_image_model->getSortby();
        resOk($sortbyData);
    }

    public function  lists(){
        $this->load->library('form_validation');
        $this->form_validation->allRequest();
        $this->form_validation->set_rules('txt_imagegallery_id','trim|required|numeric');
        $this->form_validation->set_rules('cur_page','trim|required|numeric');
        $this->form_validation->set_rules('per_page','trim|required|numeric');
        $this->form_validation->set_rules('txt_sortby','trim|option');
        $this->formCheck();

        $imagegallery_id = t_Request("txt_imagegallery_id");
        $cur_page = t_Request("cur_page");
        $per_page = t_Request("per_page");
        $txt_sortby = t_Request("txt_sortby");

        
        if(intval($imagegallery_id)==0){
            $whereStr = "";
            $paramAr = array();
        }else{
            $this->load->model("root_imagegallery_model");
            $joinStr = "LEFT JOIN image_matchto_image_group ON ( image_matchto_image_group.image_id = image.image_id )";
            $whereStr = " image_matchto_image_group.image_group_id = ? ";
            $paramAr = array($imagegallery_id);
        }
        
        $this->load->model("root_image_model");
        $sortby_id = $this->root_image_model->getSortbyId($txt_sortby);


        $total_row = $this->root_image_model->getListsTotalRow($whereStr,$paramAr);
        $data_list_ar = $this->root_image_model->getLists($whereStr,$paramAr,$cur_page,$per_page,$sortby_id,$joinStr);

        $dataSend = dataListSendFormat($total_row,$data_list_ar,$cur_page,$per_page,$sortby_id);
        resOk($dataSend);
    }

    public function  search(){

        $this->load->library('form_validation');
        $this->form_validation->allRequest();
        $this->form_validation->set_rules('txt_search','trim|required');
        $this->form_validation->set_rules('txt_imagegallery_id','trim|required|numeric');
        $this->form_validation->set_rules('cur_page','trim|required|numeric');
        $this->form_validation->set_rules('per_page','trim|required|numeric');
        $this->form_validation->set_rules('txt_sortby','trim|option');
        $this->formCheck();

        $txt_search = t_Request("txt_search");
        $imagegallery_id = t_Request("txt_imagegallery_id");
        $cur_page = t_Request("cur_page");
        $per_page = t_Request("per_page");
        $txt_sortby = t_Request("txt_sortby");


        $this->load->model("root_image_model");
        $sortby_id = $this->root_image_model->getSortbyId($txt_sortby);
        $joinStr = "LEFT JOIN image_matchto_image_group ON ( image_matchto_image_group.image_id = image.image_id )";
        $whereStr = " image_matchto_image_group.image_group_id = ? AND image.title LIKE ? ";
        $paramAr = array($imagegallery_id,"%".$txt_search."%");

        $total_row = $this->root_image_model->getListsTotalRow($whereStr,$paramAr);
        $data_list_ar = $this->root_image_model->getLists($whereStr,$paramAr,$cur_page,$per_page,$sortby_id,$joinStr);

        $dataSend = dataListSendFormat($total_row,$data_list_ar,$cur_page,$per_page,$sortby_id);
        resOk($dataSend);
    }

    public function  id(){
        $this->load->library('form_validation');
        $this->form_validation->allRequest();
        $this->form_validation->set_rules('txt_image_id','trim|required|numeric');
        $this->formCheck();

        $txt_image_id = t_Request("txt_image_id");

        $this->load->model("root_image_model");
        $result = $this->root_image_model->getId($txt_image_id);
        resOk($result);
    }

    public function  upload(){
        $this->load->library('form_validation');
        $this->form_validation->onlyPost();
        $this->form_validation->requireFile('image_file');
        $this->form_validation->set_rules('txt_crop_rect_json','trim');
        $this->form_validation->set_rules('txt_rotate_degree','trim|numeric');
        $this->formCheck();

        $crop_json = t_Post("txt_crop_rect_json");
        $rotate_degree = t_Post("txt_rotate_degree");

        $this->load->model("root_image_model");
        if($crop_json!=""){
            $cropData = json_decode($crop_json,true);
            $this->root_image_model->checkCropRectDataFormat($cropData);
        }
        if(is_numeric($rotate_degree)){
            $this->root_image_model->checkValidRotateValue(intval($rotate_degree));
        }

        $uploadData = $this->root_image_model->upload('image_file',1);
        
        if(sizeof($uploadData["successFiles"])>0){
            $successImageData = $uploadData["successFiles"][0];
            $image_id = $successImageData["image_id"];
            
            if($crop_json!=""){
                $resultRectCrop = $this->root_image_model->cropRectImageById($image_id,$cropData);
                $uploadData["resultRectCrop"] = $resultRectCrop;
            }
            if($crop_json!=""){
                $resultThumbCrop = $this->root_image_model->cropImageById($image_id,$cropData);
                $uploadData["resultThumbCrop"] = $resultThumbCrop;
            }
            if(is_numeric($rotate_degree)){
                $resultRotate = $this->root_image_model->rotateImageById($image_id,intval($rotate_degree));
                $uploadData["resultRotate"] = $resultRotate;
            }
        }

        resOk($uploadData);
    }

    public function  edit(){
        $this->load->library('form_validation');
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('txt_image_id','trim|required|numeric');
        $this->form_validation->set_rules('txt_image_title','trim|required');
        $this->form_validation->set_rules('txt_image_description','trim');
        $this->formCheck();

        $image_id = t_Post("txt_image_id");
        $dbData["title"] = t_Post("txt_image_title");
        $dbData["description"] = t_Post("txt_image_description");

        $this->load->model("root_image_model");
        $updateResult = $this->root_image_model->edit($dbData,$image_id);
        resOk($updateResult);
    }

    public function  delete(){
        $this->load->library('form_validation');
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('txt_delete_json','trim|required');
        $this->formCheck();

        $daleteId_array = json_decode(t_Post("txt_delete_json"),true);

        $this->load->model("root_image_model");
        $deleteResult = $this->root_image_model->delete($daleteId_array);

        resOk($deleteResult);
    }

    public function  crop(){

        $this->load->library('form_validation');
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('txt_image_id','trim|required|numeric');
        $this->form_validation->set_rules('txt_crop_json','trim|required');
        $this->formCheck();

        $txt_image_id = t_Post("txt_image_id");
        $cropData = json_decode(t_Post("txt_crop_json"),true);

        $this->load->model("root_image_model");
        $result = $this->root_image_model->cropImageById($txt_image_id,$cropData);
        resOk($result);
    }

    public function  crop_rect(){

        $this->load->library('form_validation');
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('txt_image_id','trim|required|numeric');
        $this->form_validation->set_rules('txt_crop_rect_json','trim|required');
        $this->formCheck();

        $txt_image_id = t_Post("txt_image_id");
        $cropRectData = json_decode(t_Post("txt_crop_rect_json"),true);

        $this->load->model("root_image_model");
        $result = $this->root_image_model->cropRectImageById($txt_image_id,$cropRectData);
        resOk($result);
    }


    public function  rotate(){

        $this->load->library('form_validation');
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('txt_image_id','trim|required|numeric');
        $this->form_validation->set_rules('txt_rotate_degree','trim|required|numeric');
        $this->formCheck();

        $txt_image_id = t_Request("txt_image_id");
        $txt_rotate_degree = t_Request("txt_rotate_degree");

        $this->load->model("root_image_model");
        $result = $this->root_image_model->rotateImageById($txt_image_id,$txt_rotate_degree);
        resOk($result);
    }

}

?>