<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mylib
{
	function view($view, $data = [])
	{
		$ci = &get_instance();
		if (!array_key_exists('title', $data)) {
			$data['title'] = 'PT Pitjarus - Web Developer Test';
		}
		if (!array_key_exists('js', $data)) {
			$data['js'] = '';
		}
		$ci->load->view('layouts/header', $data);
		if ($data) {
			$ci->load->view('' . $view, $data);
		} else {
			$ci->load->view('' . $view);
		}
		$ci->load->view('layouts/footer', $data);
	}
}
