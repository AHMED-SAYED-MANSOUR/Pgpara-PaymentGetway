<?php
class ControllerExtensionPaymentPgara extends Controller
{
    private $error = array();

    public function index()
    {
        $this->load->language('extension/payment/Pgara');

        $this->document->setTitle($this->language->get('pgpara'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            // Store access token if test settings were successful
            if (isset($this->request->post['access_token'])) {
                $this->request->post['payment_Pgara_access_token'] = $this->request->post['access_token'];
            }

            $this->model_setting_setting->editSetting('payment_Pgara', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true));
        }

        $data['heading_title'] = $this->language->get('pgpara');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');

        $data['entry_api_key'] = $this->language->get('entry_api_key');
        $data['entry_merchant_id'] = $this->language->get('entry_merchant_id');
        $data['entry_username'] = $this->language->get('entry_username');
        $data['entry_password'] = $this->language->get('entry_password');
        $data['entry_method'] = $this->language->get('entry_method');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $data['entry_test_mode'] = $this->language->get('entry_test_mode');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_test'] = $this->language->get('button_test');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['api_key'])) {
            $data['error_api_key'] = $this->error['api_key'];
        } else {
            $data['error_api_key'] = '';
        }

        if (isset($this->error['merchant_id'])) {
            $data['error_merchant_id'] = $this->error['merchant_id'];
        } else {
            $data['error_merchant_id'] = '';
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
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('extension/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('pgpara'),
            'href' => $this->url->link('extension/payment/Pgara', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['action'] = $this->url->link('extension/payment/Pgara', 'user_token=' . $this->session->data['user_token'], true);

        $data['cancel'] = $this->url->link('extension/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true);

        $data['test_action'] = $this->url->link('extension/payment/Pgara/testSettings', 'user_token=' . $this->session->data['user_token'], true);

      //  if (isset($this->request->post['payment_Pgara_api_key'])) {
      //      $data['payment_Pgara_api_key'] = $this->request->post['payment_Pgara_api_key'];
       // } else {
       //     $data['payment_Pgara_api_key'] = $this->config->get('payment_Pgara_api_key');
      //  }

        if (isset($this->request->post['payment_Pgara_merchant_id'])) {
            $data['payment_Pgara_merchant_id'] = $this->request->post['payment_Pgara_merchant_id'];
        } else {
            $data['payment_Pgara_merchant_id'] = $this->config->get('payment_Pgara_merchant_id');
        }

        if (isset($this->request->post['payment_Pgara_username'])) {
            $data['payment_Pgara_username'] = $this->request->post['payment_Pgara_username'];
        } else {
            $data['payment_Pgara_username'] = $this->config->get('payment_Pgara_username');
        }

        if (isset($this->request->post['payment_Pgara_password'])) {
            $data['payment_Pgara_password'] = $this->request->post['payment_Pgara_password'];
        } else {
            $data['payment_Pgara_password'] = $this->config->get('payment_Pgara_password');
        }

       // if (isset($this->request->post['payment_Pgara_method'])) {
       //     $data['payment_Pgara_method'] = $this->request->post['payment_Pgara_method'];
       // } else {
       //     $data['payment_Pgara_method'] = $this->config->get('payment_Pgara_method');
       // }

        if (isset($this->request->post['payment_Pgara_status'])) {
            $data['payment_Pgara_status'] = $this->request->post['payment_Pgara_status'];
        } else {
            $data['payment_Pgara_status'] = $this->config->get('payment_Pgara_status');
        }

       // if (isset($this->request->post['payment_Pgara_sort_order'])) {
       //     $data['payment_Pgara_sort_order'] = $this->request->post['payment_Pgara_sort_order'];
       // } else {
       //     $data['payment_Pgara_sort_order'] = $this->config->get('payment_Pgara_sort_order');
       // }

        if (isset($this->request->post['payment_Pgara_test_mode'])) {
            $data['payment_Pgara_test_mode'] = $this->request->post['payment_Pgara_test_mode'];
        } else {
            $data['payment_Pgara_test_mode'] = $this->config->get('payment_Pgara_test_mode');
        }

        if (isset($this->request->post['payment_Pgara_access_token'])) {
            $data['payment_Pgara_access_token'] = $this->request->post['payment_Pgara_access_token'];
        } else {
            $data['payment_Pgara_access_token'] = $this->config->get('payment_Pgara_access_token');
        }

        $data['user_token'] = $this->session->data['user_token'];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/payment/Pgara', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/payment/Pgara')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->request->post['payment_Pgara_api_key']) {
            $this->error['api_key'] = $this->language->get('error_api_key');
        }

        if (!$this->request->post['payment_Pgara_merchant_id']) {
            $this->error['merchant_id'] = $this->language->get('error_merchant_id');
        }

        if (!$this->request->post['payment_Pgara_username']) {
            $this->error['username'] = $this->language->get('error_username');
        }

        if (!$this->request->post['payment_Pgara_password']) {
            $this->error['password'] = $this->language->get('error_password');
        }

        return !$this->error;
    


    }
public function test() {
    $json = array();

    if ($this->request->server['REQUEST_METHOD'] == 'POST') {
        $this->load->language('extension/payment/Pgara');
        $this->load->model('setting/setting');

        $this->load->model('extension/payment/pgara'); // Load the model to handle the API request

        $merchant_id = $this->request->post['payment_Pgara_merchant_id'];
        $username = $this->request->post['payment_Pgara_username'];
        $password = $this->request->post['payment_Pgara_password'];
        $test_mode = $this->request->post['payment_Pgara_test_mode'];

        $response = $this->model_extension_payment_pgara->testApi($merchant_id, $username, $password, $test_mode);

        if ($response && isset($response['access_token'])) {
            $json['success'] = $response['access_token'];
        } else {
            $json['error'] = $this->language->get('error_test');
        }
    } else {
        $json['error'] = $this->language->get('error_request_method');
    }

    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
}

  public function testSettings() {
        $this->load->language('extension/payment/pgara');
        $json = array();

        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $this->load->model('extension/payment/pgara');
            $merchant_id = $this->request->post['payment_Pgara_merchant_id'];
            $username = $this->request->post['payment_Pgara_username'];
            $password = $this->request->post['payment_Pgara_password'];

            $result = $this->model_extension_payment_pgara->testApi($merchant_id, $username, $password);

            if (isset($result['error'])) {
                $json['error'] = $result['error'];
            } else if (isset($result['response']['access_token'])) {
                $json['success'] = 'Successfully authenticated!';
            } else {
                $json['error'] = 'Authentication failed!';
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
    
    
  public function getAccessToken() {
    $this->load->language('extension/payment/Pgara');

    // Extract POST data
    $merchant_id = isset($this->request->post['payment_Pgara_merchant_id']) ? (int)$this->request->post['payment_Pgara_merchant_id'] : 0;
    $username = isset($this->request->post['payment_Pgara_username']) ? $this->request->post['payment_Pgara_username'] : '';
    $password = isset($this->request->post['payment_Pgara_password']) ? $this->request->post['payment_Pgara_password'] : '';


    // Prepare API request
    $url = 'https://postest.pgpara.com/auth';
    $data = array(
        'merchantId' => $merchant_id,
        'username'   => $username,
        'password'   => $password
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    $response = curl_exec($ch);
    curl_close($ch);

    // Log or print the raw response for debugging
    error_log("API Response: " . $response);

    $json_response = json_decode($response, true);

    if (isset($json_response['access_token'])) {
        $json = array(
            'access_token' => $json_response['access_token']
        );
    } else {
        $json = array(
            'error' => isset($json_response) ? $json_response : 'Unknown error'
        );
    }

    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
}



}
