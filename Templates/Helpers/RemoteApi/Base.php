<?php
namespace Modules\Templates\Helpers\RemoteApi;

class Base
{

    const MODE_SANDBOX = 'sandbox';
    const MODE_LIVE    = 'live';

    protected static $auth_url        = '';
    protected static $api_live_url    = '';
    protected static $api_sandbox_url = '';
    protected static $token           = null;

    public function __construct()
    {
        $this::$api_live_url    = printq_system_settings_value('servers.templates_api.api_url', '');
        $this::$api_sandbox_url = printq_system_settings_value('servers.templates_api.sandbox_api_url', '');
        if ($this->getMode() == Base::MODE_LIVE) {
            $this::$auth_url = $this::$api_live_url.'login';
        } else {
            $this::$auth_url = $this::$api_sandbox_url.'login';
        }
    }

    public function getMode()
    {
        return printq_system_settings_value('servers.templates_api.api_mode', 'live');
    }

    /**
     * @param  string  $endpoint
     * @param          $data
     * @param  array   $additional_headers
     * @param  bool    $is_post
     *
     * @return mixed
     * @throws \Zend_Json_Exception|\Exception
     */
    protected function makeRequest($endpoint, $data, $additional_headers = [], $is_post = true)
    {

        $url = $this->getApiUrl().$endpoint;

        $ch   = curl_init();
        $ah   = $additional_headers;
        $ah[] = 'ApiKey: '.$this->getApiKey();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $ah);

        if ($is_post) {
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        } else {

            if ($data) {
                $finalUrl = false === strpos($url, '?') ? $url.'?' : $url;
                if (is_array($data)) {
                    $finalUrl .= http_build_query($data);
                } else {
                    $finalUrl .= $data;
                }
            } else {
                $finalUrl = $url;
            }
            curl_setopt($ch, CURLOPT_URL, $finalUrl);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 90);

        $result = curl_exec($ch);

        $debugMsg    = 'URL: '.$url."\n";
        $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        if ($contentType != 'application/pdf') {
            $debugMsg .= 'Data: '.print_r($data, 1)."\n";
        } else {
            $debugMsg .= 'Data: PDF content'."\n";
        }
        $debugMsg .= 'Response: '.$result."\n";

        if (false === $result) {
            throw new \Exception('API Request failed: '.curl_error($ch));
        }

        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if (200 != $httpcode) {
            return false;
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getApiUrl()
    {
        if ($this->getMode() == Base::MODE_LIVE) {
            return static::$api_live_url;
        }
        return static::$api_sandbox_url;
    }

    /**
     * @param  int  $storeId
     *
     * @return mixed
     */
    public function getApiKey($storeId = null)
    {
        if ($this->getMode() == Base::MODE_LIVE) {
            return printq_system_settings_value('servers.templates_api.api_key', '');
        }

        return printq_system_settings_value('servers.templates_api.sandbox_api_key', '');
    }

    /**
     * @param  int  $storeId
     *
     * @return mixed
     */
    public function getSecretKey($storeId = null)
    {
        return printq_system_settings_value('general.general.jwt', '');
    }
}
