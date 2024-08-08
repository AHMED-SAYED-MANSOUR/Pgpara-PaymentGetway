<?php

class ControllerExtensionPaymentPgara extends Controller
{
    public function index()
    {
        $this->load->language('extension/payment/pgara');
        $data['button_confirm'] = $this->language->get('button_confirm');
        $data['action'] = $this->url->link('extension/payment/pgara/confirm', '', true);

        return $this->load->view('extension/payment/pgara', $data);
    }

    public function confirm()
    {
        $this->load->language('extension/payment/pgara');
        $this->load->model('checkout/order');

//        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
        $order_id = $this->session->data['order_id'];

        $card_number = $this->request->post['card_number'];
        $expiry_date = $this->request->post['expiry_date'];
        $cvv = $this->request->post['cvv'];
        $email = $this->request->post['email'];

        if ($this->validatePaymentDetails($card_number, $expiry_date, $cvv)) {
            $api_key = $this->config->get('payment_pgara_api_key');
            $amount = $this->model_checkout_order->getOrder($order_id)['total'];

            // Call the payment gateway API
            $response = $this->callPgaraApi($api_key, $amount, $order_id, $card_number, $expiry_date, $cvv, $email);

            if ($response['status'] == 'success') {
                $this->model_checkout_order->addOrderHistory($order_id, $this->config->get('payment_pgara_order_status_id'));
                $this->response->redirect($this->url->link('checkout/success'));
            } else {
                $this->session->data['error'] = $response['message'];
                $this->response->redirect($this->url->link('checkout/failure'));
            }
        } else {
            $this->session->data['error'] = 'Invalid payment details.';
            $this->response->redirect($this->url->link('checkout/failure'));
        }

    }
    public function validatePaymentDetails($card_number, $expiry_date, $cvv){
        if(!empty($card_number) || !empty($expiry_date) || !empty($cvv)){
            return 1;
        }
        else
        {
            return 0;
        }
    }

    private function callPgaraApi($api_key, $amount, $order_id , $card_number, $expiry_date, $cvv,$email)
    {

        return ['status' => 'success', 'transaction_id' => '123456'];
    }

//    private function callPgaraApi($api_key, $amount, $order_id, $card_number, $expiry_date, $cvv, $email)
//    {
//        $url = $this->get_api_url('payment/pay3d');
//        $token = $this->get_access_token();
//
//        // Implement the logic to call the Pgara API
//        $postData = [
//            'api_key' => $api_key,
//            'amount' => $amount,
//            'order_id' => $order_id,
//            'card_number' => $card_number,
//            'expiry_date' => $expiry_date,
//            'cvv' => $cvv,
//            'email' => $email
//        ];
//
//        $ch = curl_init('https://api.pgpara.com/payment');
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_POST, true);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
//        $response = curl_exec($ch);
//        curl_close($ch);
//
//        return json_decode($response, true);
//    }


    // Test or Live Mode
//    private function get_api_url($endpoint) {
//        if ($this->testmode === 'yes') {
//            return 'https://postest.pgpara.com/api/' . $endpoint;
//        } else {
//            return 'https://posapi.pgpara.com/api/' . $endpoint;
//        }
//    }

    // access Token
//    private function get_access_token() {
//        $url = $this->get_api_url('auth');
//
//        $postData = array(
//            'merchantId' => (int)$this->merchant_id,
//            'username' => $this->api_username,
//            'password' => $this->api_password
//        );
//
//        $ch = curl_init();
//
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_POST, true);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
//        curl_setopt($ch, CURLOPT_TIMEOUT, 45);
//
//        $response = curl_exec($ch);
//
//        if (curl_errno($ch)) {
//            // Handle error
//            curl_close($ch);
//            return '';
//        }
//
//        curl_close($ch);
//
//        $result = json_decode($response, true);
//
//        if (isset($result['data']['access_token'])) {
//            return $result['data']['access_token'];
//        } else {
//            // Handle unexpected result
//            return '';
//        }
//    }

}

