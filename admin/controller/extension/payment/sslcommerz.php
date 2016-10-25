<?php
class ControllerExtensionPaymentSslcommerz extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/payment/sslcommerz');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('sslcommerz', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');

		$data['text_support'] = $this->language->get('text_support');

		$data['text_entry_username'] = $this->language->get('text_entry_username');
		$data['text_entry_password'] = $this->language->get('text_entry_password');
		$data['text_entry_total'] = $this->language->get('text_entry_total');
		$data['text_entry_testbox'] = $this->language->get('text_entry_testbox');
		$data['text_entry_success_status'] = $this->language->get('text_entry_success_status');
		$data['text_entry_pending_status'] = $this->language->get('text_entry_pending_status');
		$data['text_entry_notify'] = $this->language->get('text_entry_notify');
		$data['text_entry_geo_zone'] = $this->language->get('text_entry_geo_zone');
		$data['text_entry_status'] = $this->language->get('text_entry_status');
		$data['text_entry_sort_order'] = $this->language->get('text_entry_sort_order');

		$data['text_help_pending_status'] = $this->language->get('text_help_pending_status');
		$data['text_help_testbox'] = $this->language->get('text_help_testbox');
		$data['text_help_total'] = $this->language->get('text_help_total');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');


		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['username'])) {
			$data['error_username'] = $this->error['username'];
		} else {
			$data['error_username'] = '';
		}

		if (isset($this->error['password'])) {
			$data['error_password'] = $this->error['password'];
		} else {
			$data['error_password'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_payment'),
			'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/payment/sslcommerz', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('extension/payment/sslcommerz', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['sslcommerz_username'])) {
			$data['sslcommerz_username'] = $this->request->post['sslcommerz_username'];
		} else {
			$data['sslcommerz_username'] = $this->config->get('sslcommerz_username');
		}

		if (isset($this->request->post['sslcommerz_password'])) {
			$data['sslcommerz_password'] = $this->request->post['sslcommerz_password'];
		} else {
			$data['sslcommerz_password'] = $this->config->get('sslcommerz_password');
		}

		if (isset($this->request->post['sslcommerz_testbox'])) {
			$data['sslcommerz_testbox'] = $this->request->post['sslcommerz_testbox'];
		} else {
			$data['sslcommerz_testbox'] = $this->config->get('sslcommerz_testbox');
		}

		if (isset($this->request->post['sslcommerz_total'])) {
			$data['sslcommerz_total'] = $this->request->post['sslcommerz_total'];
		} else {
			$data['sslcommerz_total'] = $this->config->get('sslcommerz_total');
		}

		if (isset($this->request->post['sslcommerz_sort_order'])) {
			$data['sslcommerz_sort_order'] = $this->request->post['sslcommerz_sort_order'];
		} else {
			$data['sslcommerz_sort_order'] = $this->config->get('sslcommerz_sort_order');
		}

		if (isset($this->request->post['sslcommerz_geo_zone'])) {
			$data['sslcommerz_geo_zone'] = $this->request->post['sslcommerz_geo_zone'];
		} else {
			$data['sslcommerz_geo_zone'] = $this->config->get('sslcommerz_geo_zone');
		}

		if (isset($this->request->post['sslcommerz_status'])) {
			$data['sslcommerz_status'] = $this->request->post['sslcommerz_status'];
		} else {
			$data['sslcommerz_status'] = $this->config->get('sslcommerz_status');
		}

		if (isset($this->request->post['sslcommerz_notify'])) {
			$data['sslcommerz_notify'] = $this->request->post['sslcommerz_notify'];
		} else {
			$data['sslcommerz_notify'] = $this->config->get('sslcommerz_notify');
		}

		if (isset($this->request->post['sslcommerz_success_order_status_id'])) {
			$data['sslcommerz_success_order_status_id'] = $this->request->post['sslcommerz_success_order_status_id'];
		} else {
			$data['sslcommerz_success_order_status_id'] = $this->config->get('sslcommerz_success_order_status_id');
		}

		if (isset($this->request->post['sslcommerz_unknown_order_status_id'])) {
			$data['sslcommerz_unknown_order_status_id'] = $this->request->post['sslcommerz_unknown_order_status_id'];
		} else {
			$data['sslcommerz_unknown_order_status_id'] = $this->config->get('sslcommerz_unknown_order_status_id');
		}

		$this->load->model('localisation/order_status');
		$this->load->model('localisation/geo_zone');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/payment/sslcommerz.tpl', $data));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/payment/sslcommerz')) {
			$this->error['warning'] = $this->language->get('text_error_permission');
		}

		if (!$this->request->post['sslcommerz_username']) {
			$this->error['username'] = $this->language->get('text_error_username');
		}

		if (!$this->request->post['sslcommerz_password']) {
			$this->error['password'] = $this->language->get('text_error_password');
		}

		return !$this->error;
	}
}