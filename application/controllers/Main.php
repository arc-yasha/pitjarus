<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Main_m');
	}

	public function index()
	{
		$data['areas'] = $this->Main_m->get_area();
		$data['js'] = 'main/js_main';
		$this->mylib->view('main/v_main', $data);
	}

	public function get_data()
	{
		$isSearch = false;
		$w_area_id = '';
		$w_dateFrom = '';
		$w_dateTo = '';
		if ($this->input->post('area_id') AND $this->input->post('dateFrom') AND $this->input->post('dateTo')) {
			$isSearch = true;
			$w_area_id = $this->input->post('area_id');
			$w_dateFrom = date('Y-m-d', strtotime($this->input->post('dateFrom')));
			$w_dateTo = date('Y-m-d', strtotime($this->input->post('dateTo')));
		}
		
		$total_rows_report_product = $this->Main_m->get_report_product()->num_rows();
		if (!$isSearch) {
			$areas = $this->Main_m->get_area();
		}else{
			$areas = $this->Main_m->get_area(['area_id'=>$w_area_id]);
		}

		// Grafik
		$store_by_areas_percentage = [];
		foreach ($areas->result() as $area) {
			if (!$isSearch) {
				$compliance = $this->Main_m->get_compliance_by_area($area->area_id)->num_rows();
			}else{
				$compliance = $this->Main_m->get_compliance_by_area($area->area_id, $w_dateFrom, $w_dateTo)->num_rows();
			}
			$calculation_nilai = ($compliance/$total_rows_report_product)*100;
			array_push($store_by_areas_percentage, $calculation_nilai);
		}

		// Table
		$compliance_area_brand = [];
		$brands = $this->Main_m->get_brand();
		foreach ($brands->result() as $brand) { 
			$compliance_area_brand_temp = [];
			foreach ($areas->result() as $area) {
				if (!$isSearch) {
					$compliance = $this->Main_m->get_compliance_by_area_brand($area->area_id,$brand->brand_id)->num_rows();
				}else{
					$compliance = $this->Main_m->get_compliance_by_area_brand($area->area_id,$brand->brand_id, $w_dateFrom, $w_dateTo)->num_rows();
				}
				$calculation_nilai = ($compliance/$total_rows_report_product)*100;
				array_push($compliance_area_brand_temp, $calculation_nilai);
			}
			array_push($compliance_area_brand, $compliance_area_brand_temp);
		}

		header("Content-Type: application/json");
		echo json_encode([
			'areas' => $areas->result(),
			'percentage' => $store_by_areas_percentage,
			'brands' => $brands->result(),
			'compliance_area_brand' => $compliance_area_brand,
		]);
	}

}

/* End of file Main.php */

?>
