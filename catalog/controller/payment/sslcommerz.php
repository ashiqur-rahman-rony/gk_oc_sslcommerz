<?php
/**
 * Payment gateway for SSLCommerz
 *
 * @author Ashiqur Rahman
 * @url http://goodkoding.com
 * @author_url http://ghumkumar.com
 **/
class ControllerPaymentSslcommerz extends Controller {
	public function index() {
		$this->language->load('payment/sslcommerz');
		$data['button_confirm'] = $this->language->get('button_confirm');
		$data['text_testbox'] = $this->language->get('text_testbox');
		$data['text_currency_error'] = $this->language->get('text_currency_error');

		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		$sslcommerz_username = $this->config->get('sslcommerz_username');
		$testbox = $this->config->get('sslcommerz_testbox');

		$transaction_id = strtoupper( substr( $sslcommerz_username, 0, 3 ) ) . '-' . $this->session->data['order_id'];

		$data['action'] = 'https://www.sslcommerz.com.bd/gwprocess/';
		if($testbox == 1) {
			$data['action'] = 'https://www.sslcommerz.com.bd/gwprocess/testbox/';
			$data['testbox'] = true;
		}

		$data['products'] = array();
		$products = $this->cart->getProducts();

		foreach ($products as $product) {
			$data['products'][] = array(
				'name'     => htmlspecialchars($product['name']),
				'price'    => $this->currency->format($product['price'], $order_info['currency_code'], false, false),
			);
		}

		$data['discount_amount_cart'] = 0;

		$total = $this->currency->format($order_info['total'] - $this->cart->getSubTotal(), $order_info['currency_code'], false, false);

		if ($total > 0) {
			$data['products'][] = array(
				'name'     => $this->language->get('text_total'),
				'price'    => $total,
			);
		} else {
			$data['discount_amount_cart'] -= $total;
		}

		$data['sslcommerz_username'] = $sslcommerz_username;
		$data['sslcommerz_amount'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
		$data['sslcommerz_currency'] = $order_info['currency_code'];
		$data['sslcommerz_transaction_id'] = $transaction_id;
		$data['sslcommerz_success_url'] = $this->url->link('checkout/success');
		$data['sslcommerz_fail_url'] = $this->url->link('checkout/checkout', '', 'SSL');
		$data['sslcommerz_cancel_url'] = $this->url->link('checkout/checkout', '', 'SSL');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/sslcommerz.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/payment/sslcommerz.tpl', $data);
		} else {
			return $this->load->view('default/template/payment/sslcommerz.tpl', $data);
		}
	}

	public function callback() {
		$tran_id = isset($this->request->post['tran_id']) ? $this->request->post['tran_id'] : null;
		if ($tran_id && strlen($tran_id) > 0) {
			$this->language->load('payment/sslcommerz');
			$this->load->model('checkout/order');

			$order_id = substr($tran_id, 4, strlen($tran_id));
			$order_info = $this->model_checkout_order->getOrder($order_id);

			$val_id = isset($this->request->post['val_id']) ? $this->request->post['val_id'] : '';
			$amount = isset($this->request->post['amount']) ? $this->request->post['amount'] : 0;
			$store_amount = isset($this->request->post['store_amount']) ? $this->request->post['store_amount'] : 0;
			$card_type = isset($this->request->post['card_type']) ? $this->request->post['card_type'] : '';
			$card_no = isset($this->request->post['card_no']) ? $this->request->post['card_no'] : '';

			$username = $this->config->get('sslcommerz_username');
			$password = $this->config->get('sslcommerz_password');
			$testbox = $this->config->get('sslcommerz_testbox') == 1 ? true : false;
			$url = $testbox ? 'https://www.sslcommerz.com.bd/validator/api/testbox/validationserverAPI.php' : 'https://www.sslcommerz.com.bd/validator/api/validationserverAPI.php';

			$val_id = urlencode($val_id);
			$store_id = urlencode($username);
			$store_passwd = urlencode($password);
			$requested_url = ($url . "?val_id=".$val_id."&Store_Id=".$store_id."&Store_Passwd=".$store_passwd."&v=1&format=json");

			$handle = curl_init();
			curl_setopt($handle, CURLOPT_URL, $requested_url);
			curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
			$ssl_response = curl_exec($handle);
			$code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

			if( $code == 200 && !( curl_errno( $handle ) ) ) {
				$result = json_decode( $ssl_response );
				$status = $result->status;
				$tran_date = $result->tran_date;
				$tran_id = $result->tran_id;
				$val_id = $result->val_id;
				$amount = $result->amount;
				$store_amount = $result->store_amount;
				$bank_tran_id = $result->bank_tran_id;
				$card_type = $result->card_type;
				$card_no = $result->card_no;
				$card_issuer = $result->card_issuer;
				$card_brand = $result->card_brand;
				$card_issuer_country = $result->card_issuer_country;
				$card_issuer_country_code = $result->card_issuer_country_code;

				$apiconnect = $result->APIConnect;
				$validated_on = $result->validated_on;
				$gw_version = $result->gw_version;

				$payment_status = 'unknown';

				if(in_array(strtoupper($apiconnect), array('INVALID_REQUEST', 'FAILED', 'INACTIVE'))) {
					$payment_status = 'failed';
					$this->session->data['error'] = $this->language->get('text_invalid_payment');
				} elseif( in_array( strtoupper( $status ), array( 'INVALID_TRANSACTION' ) ) ) {
					$payment_status = 'failed';
					$this->session->data['error'] = $this->language->get('text_invalid_payment');
				} elseif( in_array( strtoupper( $status ), array( 'VALIDATED', 'VALID' ) ) ) {
					$payment_status = 'success';
				} else {
					$payment_status = 'unknown';
				}
			} else {
				$payment_status = 'unknown';
			}

			$notify = $this->config->get('sslcommerz_notify') == 1 ? true : false;

			if($payment_status == 'failed') {
				$this->redirect($this->url->link('checkout/checkout', '', 'SSL'));
			} elseif($payment_status == 'unknown') {
				$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('sslcommerz_unknown_order_status_id'), sprintf($this->language->get('text_unknown_payment'), $tran_id), $notify);
			} else {
				$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('sslcommerz_success_order_status_id'), sprintf($this->language->get('text_successful_payment'), $tran_id), $notify);
			}
			curl_close($handle);
		}
	}
}