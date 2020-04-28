<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Main_generic
{
	var $data = array();

	function layout($pages, $data, $return = false)
	{
		$this->CI = &get_instance();

		$comp = array(
			'header' => $this->CI->load->view('core/html-header'),
			'navbar' => $this->CI->load->view('core/navbar', $data),
			'content' => $this->CI->load->view($pages),
			'foot'   => $this->CI->load->view('core/footer'),
			'footer' => $this->CI->load->view('core/html-footer')
		);

		return $this->CI->load->view('pages/index', $comp, true);
	}

	function alert($condition, $message, $alertClasses)
	{
		$this->CI = &get_instance();

		$alert = '<div class="alert alert-' . $alertClasses . ' alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4>
						<i class="icon fa fa-check"></i> ' . $condition . '!
					</h4> 
					' . $message . '
				</div>';

		return $alert;
	}
}

/* End of file Main_generic.php */
/* Location: ./system/application/libraries/Main_generic.php */
