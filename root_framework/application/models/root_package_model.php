<?

class root_package_model extends root_model {

    // private $currentProductTypeId = null;

    // public function setProductTypeId($type_id){
    //     $this->currentProductTypeId = $type_id;
    // }

    // public function getProductTypeId(){
    //     return  $this->currentProductTypeId;
    // }
    // /* << BASIC FUNCTION : START >> */

    // public function getTableId(){
    //     return  202;
    // }

    public function getSortby(){

        $sortData = array(
            array(
                "id" => "product_lastest_create", 
                "label" => "lastest",
                "value" => "product.create_time DESC",
                "default" => 1
            ),
            array(
                "id" => "product_oldest_create",
                "label" => "oldest",
                "value" => "product.create_time ASC",
                "default" => 0
            ),
            array(
                "id" => "product_title_a-z",
                "label" => "title_A-Z",
                "value" => "product_detail.title ASC",
                "default" => 0
            ),
            array(
                "id" => "product_title_z-a",
                "label" => "title_Z-A",
                "value" => "product_detail.title DESC",
                "default" => 0
            )
        );
        return $sortData;
    }

    public function getSelectFieldArray_short(){
        $field["product_id"] = "product.product_id";
        $field["product_create_time"] = "product.create_time";
        $field["product_update_time"] = "product.update_time";
        $field["product_title"] = "product_matchto_package.amount";
        $field["product_title"] = "product_detail.title";
        $field["matchto_amount"] = "product_matchto_package.amount";
        $field["matchto_create_time"] = "product_matchto_package.create_time";
        $field["matchto_update_time"] = "product_matchto_package.update_time";
        return $field;
    }

    protected function getSelectFieldArray_extend(){

         $field = array() ;
        // $field["product_tags"] = "product_detail.tags";
        // $field["product_description"] = "product_detail.description";
        return $field;
    }

    protected function getSelectFieldArray_veryShot(){
        // $field["product_id"] = "product.product_id";
        // $field["product_type_id"] = "product.product_type_id";
        // $field["product_price"] = "product.price";
        // $field["product_title"] = "product_detail.title";
        // $field["product_create_time"] = "product.create_time";
        // $field["product_update_time"] = "product.update_time";
        $field = array() ;
        return $field;
    }


    public function getListsTotalRow($WhereStr,$joinStr){

        if(trim($WhereStr)!=""){
            $WhereStr = " AND ".$WhereStr." ";
        }

        $sql = " 
            SELECT
                 COUNT( DISTINCT product_matchto_package.product_id ) as count 
            FROM 
                product_matchto_package
                    INNER JOIN product ON product.product_id = product_matchto_package.product_id
                     INNER JOIN product_detail ON product_detail.product_id = product_matchto_package.product_id
                    ".$joinStr."
            WHERE
                product_matchto_package.status > 0
            "
            .$WhereStr ;

        $result_ar = $this->db->query($sql)->result_array();
        return intval(@$result_ar[0]["count"]);

    }

    public function getLists($cur_page,$per_page,$sortBy_id="",$WhereStr="",$joinStr=""){

        if(trim($WhereStr)!=""){
            $WhereStr = " AND ".$WhereStr." ";
        }

        
        $orderAndLimit_str = $this->getPageNavSql($cur_page,$per_page,$sortBy_id);
        $fieldArray = array();
        $fieldArray = array_merge($fieldArray, $this->getSelectFieldArray_short());

        $sql = " 
            SELECT
                ".fieldArrayToSql($fieldArray)."
            FROM 
                product_matchto_package
                    INNER JOIN product ON product.product_id = product_matchto_package.product_id
                    INNER JOIN product_detail ON product_detail.product_id = product_matchto_package.product_id
                    ".$joinStr."
            WHERE
                product_matchto_package.status > 0
            "
            .$WhereStr
            .$orderAndLimit_str;
        $result_ar = $this->db->query($sql)->result_array();

        // if(sizeof($result_ar)>0){
        //     foreach ($result_ar as $key => $value) {
        //         $product_id = @$value["product_id"];
        //         $result_ar[$key]["product_image"] = $this->getPrimaryImage($product_id,2);
        //     }
        // }


        return $result_ar;
    }


    public function getId($product_id){

        $result = $this->getDataById($product_id);
        if(!$result){
            resDie(array(),"data-not-foud");
        }   
        return $result;
    }
    
    public function getShortId($product_id){
        
        $result = $this->getShortDataById($product_id);
        if(!$result){
            resDie(array(),"data-not-foud");
        }   
        return $result;
    }


    public function getDataById($product_id,$extend_field=true){

        $fieldArray = array();
        $fieldArray = array_merge($fieldArray, $this->getSelectFieldArray_short());
        if($extend_field){
            $fieldArray = array_merge($fieldArray, $this->getSelectFieldArray_extend());
        }

        $sql = " 
            SELECT
                ".fieldArrayToSql($fieldArray)."
            FROM 
                package
                    INNER JOIN product_matchto_package ON product_matchto_package.package_id = package.package_id
            WHERE
                product_matchto_package.package_id = {$package_id}
                AND product_matchto_package.product_id = {$product_id}
                AND product.status > 1
            LIMIT 
                0,1
            ";

        $result_ar = $this->db->query($sql)->result_array();

        $dataResult = @$result_ar[0];
        if(@$dataResult["product_id"]==""){
            return false;
        }  
        return $dataResult;

    }

    public function getShortDataById($product_id){
        return $this->getDataById($product_id,false);
    }

    // public function getMatchById($package_id,$product_id){

    //     $fieldArray = array();
    //     $fieldArray = array_merge($fieldArray, $this->getSelectFieldArray_short());

    //     // INNER JOIN product_matchto_package ON product_matchto_package.package_id = package.package_id

    //     $sql = " 
    //         SELECT
    //             ".fieldArrayToSql($fieldArray)."
    //         FROM 
    //             product_matchto_package            
    //         WHERE
    //             product_matchto_package.package_id = {$package_id}
    //             AND product_matchto_package.product_id = {$product_id}
    //             AND product_matchto_package.status > 1
    //         LIMIT 
    //             0,1
    //         ";

    //     $result_ar = $this->db->query($sql)->result_array();

    //     $dataResult = @$result_ar[0];
    //     // if(@$dataResult["product_id"]==""){
    //     //     return false;
    //     // }  
    //     //return $dataResult;

    //     return $sql ;

    // }

   

    /* << BASIC FUNCTION : END >> */

    // public function getPrimaryImage($product_id,$limit=-1){

    //     return $this->root_image_model->getImageByHolder($this->getTableId(),$product_id,0,$limit);
    // }

     //MORE FUNCTOIN

    public function getPackageIdForProduct($product_id){

             return $this->root_package_model->getPackageIddata($product_id,$Tbname="package",$FieldData = "package_id",$conID = 'product_id') ;

    }

    public function getProductIdForPackage($product_id){

            return $this->root_package_model->getPackageIddata($product_id,$Tbname="package",$FieldData = "product_id",$conID = 'package_id') ;

    }

   public function getPackageIddata($DataId,$Tbname,$FieldData,$conID){

             $dataId = $this->db->select($FieldData) 
                                ->where($conID, $DataId )
                                ->where('status', 1)
                                ->get($Tbname) 
                                ->row_array() ;       

            if(!$dataId){

              return false ;

           }else{

              return $dataId  ;

           }
      

    }

    public function addProductForPackage($Dbdata)
    {
     
        $Dbdata['shop_id'] = $this->currentShopId(); ;
        $Dbdata['status'] =  1 ;
        $Dbdata['create_time'] =  time() ;
        $Dbdata['update_time'] =  time() ;

        $FieldData = 'package_id,product_id' ;

      // $PackageData = $this->CheckProductInPackage($Dbdata,$Tbname='package',$FieldData) ;

        $PackageData = $this->GetPackageData($Dbdata,$Tbname='package',$FieldData) ;
  
        $PackageMatchData = $this->GetPackageData($Dbdata,$Tbname='product_matchto_package',$FieldData) ;

        if(!$PackageData AND !$PackageMatchData)
        {

          return $this->insertToTable("product_matchto_package",$Dbdata);

        }else{

          
           return resDie('Your Database Have same package_id '.$Dbdata['package_id'].' and product_id'.$Dbdata['product_id']) ;

        } 
        
    }


    public function subProductForPackage($package_id,$product_id,$amount)
    {

        $FieldData = 'amount' ;

        $Dbdata = array() ;

         $Dbdata['package_id'] = $package_id ;

         $Dbdata['product_id'] = $product_id ;

         $PackageData = $this->GetPackageData($Dbdata,$Tbname='product_matchto_package',$FieldData) ;

        if($PackageData > 0 )
        {


         $updateField['amount'] = $PackageData['amount'] - $amount ;

             if($updateField['amount']  < 0 ){

                  $updateField['amount']  = 0 ;

                  $updateField['update_time']  = time() ;

             }

         return $this->updateToTable("product_matchto_package",$updateField," WHERE product_matchto_package.package_id = {$package_id} AND product_matchto_package.product_id = {$product_id} ") ;

        } 

    }

    public function getTotalAmountForPackage($package_id,$where_str,$joinStr){

        $sortby_id = "update_time";
 
        $total_row = $this->root_package_model->getListsTotalRow($where_str,$joinStr) ;
        $cur_page =  1 ;
        $per_page =  $total_row  ;
        $dataList = $this->root_package_model->getLists($cur_page,$per_page,$sortby_id,$where_str);

        $TotalAmount = 0 ;

        foreach ($dataList as $key => $value) {
          
              $TotalAmount = $TotalAmount + $value['matchto_amount'] ;

        }

        return $TotalAmount ;
      
    
    }

    public function GetPackageData($Dbdata,$Tbname,$FieldData){

         return $this->ProductAndPackageData($Dbdata,$Tbname,$FieldData) ;

    }

    public function ProductAndPackageData($Dbdata,$Tbname,$FieldData){

 
             $dataId = $this->db->select($FieldData) 
                                ->where('package_id', $Dbdata['package_id'] )
                                ->where('product_id', $Dbdata['product_id'] )
                                ->where('status', 1)
                                ->get($Tbname) 
                                ->row_array() ;   


              return $dataId  ;

    }


}

?>