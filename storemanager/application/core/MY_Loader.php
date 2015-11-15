<?

class MY_Loader extends CI_Loader {

	public $curModule = null;

    function __construct()
    {
    	//echo " [[[ ---- MY_Loader : __construct ---- ]]]";
        parent::__construct();
    }

    public function startByModule($curModule){
    	$this->curModule = $curModule;
    }

    public function mLoadModel($model_name,$not_overide=false){
		$module_path =  $this->curModule->path;
		$class_file_path = $module_path."app/models/".$model_name;
		
		$this->load->model("module_model");
		$obj = $this->module_model->processModuleModel($class_file_path,$model_name);
		if($not_overide==false){
			$this->{$model_name} = $obj;
		}
		$obj->startByModule($this->curModule);
		return $obj;
	}

	public function mLoadLibrary($class_name,$not_overide=false){
		$module_path =  $this->curModule->path;
		$class_file_path = $module_path."libraries/".$class_name;

		$this->load->model("module_model");
		$obj = $this->module_model->processModuleLibrary($class_file_path,$class_name);
		if($not_overide==false){
			$this->{$class_name} = $obj;
		}
		return $obj;
	}

    public function themeable($view, $vars = array(), $return = FALSE)
	{
        $themeFile = $view.'.php';
        if(file_exists($themeFile)) return $this->_ci_load(array('_ci_path' => $themeFile, '_ci_view' => $view, '_ci_vars' => $this->_ci_object_to_array($vars), '_ci_return' => $return));    // Get from theme
        return $this->view($view, $vars, $return);        // Get from views
	}


    protected function _ci_load_class($class, $params = NULL, $object_name = NULL)
	{
		// Get the class name, and while we're at it trim any slashes.
		// The directory path can be included as part of the class name,
		// but we don't want a leading slash
		$class = str_replace('.php', '', trim($class, '/'));

		// Was the path included with the class name?
		// We look for a slash to determine this
		$subdir = '';
		if (($last_slash = strrpos($class, '/')) !== FALSE)
		{
			// Extract the path
			$subdir = substr($class, 0, $last_slash + 1);

			// Get the filename from the path
			$class = substr($class, $last_slash + 1);
		}

		// We'll test for both lowercase and capitalized versions of the file name
		foreach (array(ucfirst($class), strtolower($class)) as $class)
		{
			$current_lib_path = 'libraries/'.$subdir.config_item('subclass_prefix').$class.'.php';
			$subclass_is_exists = false;
			$subclass = APPPATH.$current_lib_path;
			if (file_exists($subclass))
			{
				$subclass_is_exists = true;
			}
			else
			{
				$subclass = root_framework_app_path().$current_lib_path;
				if (file_exists($subclass)){
					$subclass_is_exists = true;
				}
			}

			/*
			$subclass = APPPATH.'libraries/'.$subdir.config_item('subclass_prefix').$class.'.php';
			// Is this a class extension request?
			if (file_exists($subclass))
			{
			*/

			if ($subclass_is_exists)
			{
				$baseclass = BASEPATH.'libraries/'.ucfirst($class).'.php';

				if ( ! file_exists($baseclass))
				{
					log_message('error', "Unable to load the requested class: ".$class);
					show_error("Unable to load the requested class: ".$class);
				}

				// Safety:  Was the class already loaded by a previous call?
				if (in_array($subclass, $this->_ci_loaded_files))
				{
					// Before we deem this to be a duplicate request, let's see
					// if a custom object name is being supplied.  If so, we'll
					// return a new instance of the object
					if ( ! is_null($object_name))
					{
						$CI =& get_instance();
						if ( ! isset($CI->$object_name))
						{
							return $this->_ci_init_class($class, config_item('subclass_prefix'), $params, $object_name);
						}
					}

					$is_duplicate = TRUE;
					log_message('debug', $class." class already loaded. Second attempt ignored.");
					return;
				}

				include_once($baseclass);
				include_once($subclass);
				$this->_ci_loaded_files[] = $subclass;

				return $this->_ci_init_class($class, config_item('subclass_prefix'), $params, $object_name);
			}

			// Lets search for the requested library file and load it.
			$is_duplicate = FALSE;
			foreach ($this->_ci_library_paths as $path)
			{
				$filepath = $path.'libraries/'.$subdir.$class.'.php';

				// Does the file exist?  No?  Bummer...
				if ( ! file_exists($filepath))
				{
					continue;
				}

				// Safety:  Was the class already loaded by a previous call?
				if (in_array($filepath, $this->_ci_loaded_files))
				{
					// Before we deem this to be a duplicate request, let's see
					// if a custom object name is being supplied.  If so, we'll
					// return a new instance of the object
					if ( ! is_null($object_name))
					{
						$CI =& get_instance();
						if ( ! isset($CI->$object_name))
						{
							return $this->_ci_init_class($class, '', $params, $object_name);
						}
					}

					$is_duplicate = TRUE;
					log_message('debug', $class." class already loaded. Second attempt ignored.");
					return;
				}

				include_once($filepath);
				$this->_ci_loaded_files[] = $filepath;
				return $this->_ci_init_class($class, '', $params, $object_name);
			}

		} // END FOREACH

		// One last attempt.  Maybe the library is in a subdirectory, but it wasn't specified?
		if ($subdir == '')
		{
			$path = strtolower($class).'/'.$class;
			return $this->_ci_load_class($path, $params);
		}

		// If we got this far we were unable to find the requested class.
		// We do not issue errors if the load call failed due to a duplicate request
		if ($is_duplicate == FALSE)
		{
			log_message('error', "Unable to load the requested class: ".$class);
			show_error("Unable to load the requested class: ".$class);
		}
	}
}
	
?>