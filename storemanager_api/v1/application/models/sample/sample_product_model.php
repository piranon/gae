<?
class sample_product_model extends base_model {

  public function getSortby(){

        $sortData = array(
            array(
              "id"=>"product_oldest_create",
              "label"=>"oldest",
              "value"=>"product.create_time ASC",
              "default"=>1
            ),
            array(
              "id"=>"product_oldest_create",
              "label"=>"lastest",
              "value"=>"product.create_time DESC",
              "default"=>0
            ),
            array(
              "id"=>"product_name_a-z",
              "label"=>"name_A-Z",
              "value"=>"product.name ASC",
              "default"=>0
            ),
            array(
              "id"=>"product_name_z-a",
              "label"=>"name_Z-A",
              "value"=>"product.name DESC",
              "default"=>0
            )
        );
        return $sortData;

  }

  public function getListsTotalRow(){
      return 30;
  } 

  protected function getSortbyStr($sortby_id=){

      $sortbyValue = "";

      /* GET1 :  FIND BY ID */
      $sortbyArray = $this->getSortby();
      foreach ($sortbyArray as $index => $row) {
          if($row["id"]==trim($sortby_id)){
            $sortbyValue = $row["value"];
          }
      }

      /* GET2 :  IF NOT FOUND ID */
      if($sortbyValue==""){
        foreach ($sortbyArray as $index => $row) {
          if($row["default"]==1){
              $sortbyValue = $row["value"];
          }
        }
      }

      return $sortbyValue;
  }

  public function getLists($cur_page,$per_page,$sortby_id=""){

      /*  EXAMPLE START : USING sorby */

      $sortByStr = $this->getSortbyStr($sortby_id);

      // $sortByStr : product.create_time ASC;

      $sql = "
          SELECT
              product.product_id
              product.price
              product.create_time
              product_detail.title
              product_detail.description
          FROM
              product
                  LEFT JOIN product_detail ON ( product_detail.product_id =  product.product_id ) 
          WHERE 
              product.product_type_id = 4
          ORDER BY
              ".$sortByStr."
          LIMIT
              ?,?
          ";
      $param_ar = array($cur_page,$per_page);
      return $result_ar = $this->db->query($sql,$param_ar)->result_array();

      /*  EXAMPLE END :  USING  sortby*/


      $data["product_id | pri"] = "";
      $data["product_name"] = "";
      $data["product_price | ori"] = rand(10,100000);
      $data["product_create_time | time"] = time();

      $total_row = $this->getListsTotalRow();
      $this->load->model("root_sampledata_model");
      $dataSend = $this->root_sampledata_model->generateListData("product",$data,$cur_page,$per_page,$total_row,0,"");

      return $dataSend;

  }

  
  public function getSearchTotalRow($txt_search=""){
       return 25;
  }

  public function getSearch($cur_page,$per_page,$txt_search="",$sortby_id=""){

      $data["product_id | pri"] = "";
      $data["product_name"] = "";
      $data["product_price | ori"] = rand(10,100000);
      $data["product_create_time | time"] = time();

      $total_row = $this->getSearchTotalRow($txt_search);
      $this->load->model("root_sampledata_model");
      $dataSend = $this->root_sampledata_model->generateListData("product",$data,$cur_page,$per_page,$total_row,0,$txt_search);

      return $dataSend;
  }


  public function getId($item_id){

      if($item_id==404){
        return false;
      }

      $data["product_id"] = $item_id;
      $data["product_name"] = "product_name - ".$item_id;
      $data["product_description"] = "product_description - ".$item_id;;
      $data["product_price"] = rand(10,100000);
      $data["currency_name"] = "thb";
      $data["product_create_time"] = time();

      return $data;
  }
  
  public function add($dbData){
      return $this->getId(rand(0,10000));
  }

  public function edit($dbData,$txt_item_id){
      return $this->getId($txt_item_id);
  }

  public function delete($deleteArray){
      return $deleteArray;
  }



}
?>