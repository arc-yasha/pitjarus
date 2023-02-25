<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Main_m extends CI_Model {

    public function get_report_product()
    {
        return $this->db->get('report_product');
    } 

    public function get_area($where = '')
    {
        if ($where == '') {
            return $this->db->get('store_area');
        }else{
            return $this->db->get_where('store_area',$where);
        }
    }

    public function get_brand()
    {
        return $this->db->get('product_brand');
    }

    public function get_compliance_by_area($area_id, $dateFrom='', $dateTo='')
    {
        $this->db->select('*');
		$this->db->join('store_area','store_area.area_id = store.area_id','left');
		$this->db->join('report_product','report_product.store_id = store.store_id','left');
		$this->db->where(['store_area.area_id'=>$area_id]);
        if ($dateFrom != '' AND $dateTo != '') {
            $this->db->where('report_product.tanggal >=', $dateFrom);
            $this->db->where('report_product.tanggal <=', $dateTo);
        }
		return $this->db->get('store');
    }

    public function get_compliance_by_area_brand($area_id,$brand_id, $dateFrom='', $dateTo='')
    {
        $this->db->select('*');
        $this->db->join('store','store.store_id = report_product.store_id','left');
        $this->db->join('store_area','store_area.area_id = store.area_id','left');
        $this->db->join('product','product.product_id = report_product.product_id','left');
        $this->db->join('product_brand','product_brand.brand_id = product.brand_id','left');
        $this->db->where(['store_area.area_id'=>$area_id]);
        $this->db->where(['product_brand.brand_id'=>$brand_id]);
        if ($dateFrom != '' AND $dateTo != '') {
            $this->db->where('report_product.tanggal >=', $dateFrom);
            $this->db->where('report_product.tanggal <=', $dateTo);
        }
		return $this->db->get('report_product');
    }

}

/* End of file Main_m.php */

?>
