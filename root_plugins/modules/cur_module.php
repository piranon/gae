<?
	
class cur_module{

	public $id;
	public $bundle_id;
	public $version;
	public $path;
	public $url;
	public $file_url;
	public $app_url;
	public $app_popup_url;
	public $api_url;

	public $base_app_url;
	public $base_app_popup_url;
	public $base_api_url;
	
	private $class_data;

	public function init(){

		$this->file_url = $this->url."staticfiles/";
		$this->base_app_url = base_url()."module/app/";
		$this->base_app_popup_url = base_url()."module/app_popup/";
		$this->base_api_url = base_api_url()."module/api/";

		$this->app_url = $this->base_app_url.$this->id."/";
		$this->app_popup_url = $this->base_app_popup_url.$this->id."/";
		$this->api_url = $this->base_api_url.$this->id."/";


		$class_data = new stdClass();
		$class_data->id = $this->id;
		$class_data->bundle_id = $this->bundle_id;
		$class_data->version = $this->version;
		$class_data->path = $this->path;
		$class_data->url = $this->url;

		$class_data->file_url = $this->file_url;
		$class_data->base_app_url = $this->base_app_url;
        $class_data->base_app_popup_url = $this->base_app_popup_url;
        $class_data->base_api_url = $this->base_api_url;

		$class_data->app_url =  $this->app_url;
		$class_data->app_popup_url = $this->app_popup_url;
		$class_data->api_url = $this->api_url;

		$this->class_data = $class_data;
	}

	public function id(){
		return $this->class_data->id;
	}

	public function bundle_id(){
		return $this->class_data->bundle_id;
	}

	public function version(){
		return $this->class_data->version;
	}

	public function path(){
		return $this->class_data->path;
	}	

	public function url(){
		return $this->class_data->url;
	}

	public function file_url(){
		return $this->class_data->file_url;
	}

	public function app_url(){
		return $this->class_data->app_url;
	}

	public function app_popup_url(){
		return $this->class_data->app_popup_url;
	}

	public function api_url(){
		return $this->class_data->api_url;
	}

	public function base_app_url(){
		return $this->class_data->base_app_url;
	}

	public function base_app_popup_url(){
		return $this->class_data->base_app_popup_url;
	}

	public function base_api_url(){
		return $this->class_data->base_api_url;
	}

}

?>