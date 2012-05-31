<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    protected $data;
    protected $defaults;
    protected $view;
    protected $layout;

    function __construct()
	{
		parent::__construct();
		
		$settings = $this->settings->get_settings();
		if (array_key_exists('site_name', $settings) === FALSE OR empty($settings['site_name']))
		{
			$settings['site_name'] = SYSTEM_NAME;
		}
		
		$this->data = array(
			'meta_title' => $settings['site_name'],
			'meta_desc' => '',
			'meta_keywords' => '',
			'meta_robot' => 'index, follow',
			'settings' => $settings
		);
		
		$this->form_validation->set_error_delimiters('<p class="help-block">', '</p>');
	}

    /**
     * Remap the CI request, running the method
     * and loading the view
     */
    public function _remap($method, $arguments)
    {
        if (method_exists($this, $method))
        {
            call_user_func_array(array($this, $method), array_slice($this->uri->rsegments, 2));
        }
        else
        {
            show_404(strtolower(get_class($this)).'/'.$method);
        }

        $this->_load_view();
    }

    /**
     * Load a view into a layout based on
     * controller and method name
     */
    private function _load_view()
    {
        // Back out if we've explicitly set the view to FALSE
        if ($this->view === FALSE) return;

        // Get or automatically set the view and layout name
        $view = ($this->view !== null) ? $this->view . '.php' : $this->router->directory . $this->router->class . '/' . $this->router->method . '.php';

        if ($this->uri->segment(1) == 'admin')
        {
	        $layout = ($this->layout !== null) ? $this->layout . '.php' : 'layouts/admin.php';
        }
        else
        {
	        $layout = ($this->layout !== null) ? $this->layout . '.php' : 'layouts/application.php';
        }

        if (is_admin())
        {
	        $this->output->enable_profiler(FALSE);
        }

        // Load the view into the data
        $this->data['yield'] = $this->load->view($view, $this->data, TRUE);

        // Display the layout with the view
        $this->load->view($layout, $this->data);
    }

    function _check_permissions()
   	{
   		if ( ! $this->ion_auth->is_admin())
   		{
   			flashmsg('You do not have the correct permissions to view that.', 'error');
   			redirect('auth/login');
   		}
   	}
}