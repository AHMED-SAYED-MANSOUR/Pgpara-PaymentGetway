<?php
class ModelExtensionPaymentPgara extends Model {
    public function testApi($merchant_id, $username, $password) {
        $url = 'https://postest.pgpara.com/api/auth';
        $data = array(
            'merchantId' => $merchant_id,
            'username' => $username,
            'password' => $password
        );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        if (curl_errno($ch)) {
            $error_message = curl_error($ch);
            curl_close($ch);
            return array('error' => $error_message);
        }

        curl_close($ch);
        $response_data = json_decode($body, true);

        return array(
            'http_code' => $http_code,
            'response' => $response_data
        );
    }
}
?>
