<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->load->view('index');
	}

	public function print_invoice() {
		$this->homeModel->insert_invoice_details($_POST);
		$data['result'] = $this->homeModel->get_invoice_details($_POST['invoiceNumber']);
		$this->load->view('invoice', $data);
	}

	public function report() {
		$data['result'] = $this->homeModel->get_all_invoice_details();
		$this->load->view('report', $data);
	}

	public function view_invoice($id) {
		$data['result'] = $this->homeModel->get_invoice_details(($id));
		$this->load->view('invoice', $data);
	}

}
