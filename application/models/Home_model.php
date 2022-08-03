<?php
class Home_Model extends CI_Model {
	public function insert_invoice_details($post) {
		$updateData = [
			"invoice_number" => $post['invoiceNumber'],
			"data" => json_encode($post),
		];

		$res = $this->db->from('invoice_details')->where('invoice_number', $post['invoiceNumber'])->count_all_results();
		if (empty($res)) {
			return $this->db->insert('invoice_details', $updateData);
		} else {
			return $this->db->where('invoice_number', $post['invoiceNumber'])->update('invoice_details', $updateData);
		}

	}

	public function get_invoice_details($id) {

		$res = $this->db->from('invoice_details')->where('invoice_number', $id)->get();
		if ($res->num_rows() > 0) {
			return $res->row();
		} else {
			return '';
		}
	}

	public function get_all_invoice_details() {

		$res = $this->db->from('invoice_details')->get();
		if ($res->num_rows() > 0) {
			return $res->result();
		} else {
			return '';
		}
	}
}
