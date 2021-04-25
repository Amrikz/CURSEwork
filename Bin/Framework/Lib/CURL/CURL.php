<?php


namespace Bin\Framework\Lib\CURL;


class CURL
{
    public $handle;

    private $headers = [];
    private $response;

    public function __construct($url = null)
    {
        $this->handle = curl_init($url);
        $this->options(CURLINFO_HEADER_OUT, true);
        $this->options(CURLOPT_HEADER, true);
        $this->options(CURLOPT_COOKIEFILE, "");
        $this->options(CURLOPT_RETURNTRANSFER, true);
        $this->options(CURLOPT_FOLLOWLOCATION, true);
        $this->options(CURLOPT_MAXREDIRS, 30);
        return $this;
    }


    public function __destruct()
    {
        curl_close($this->handle);
    }


    public function options($option, $value = null)
    {
        if (!is_array($option) && isset($value))
            return curl_setopt($this->handle, $option, $value);
        elseif (is_array($option))
            return curl_setopt_array($this->handle, $option);
        return false;
    }


    public function execute()
    {
        $this->options(CURLOPT_HTTPHEADER, $this->headers);
        $this->response = curl_exec($this->handle);
        if ($this->response == true)
            return true;
        return makeError(arrayToStr(["CURL ERROR #".$this->errno() => [$this->error(), $this->strerror()]], ', ', true));
    }


    public function body($apply_headers = false)
    {
        if ($apply_headers)
        {
            foreach ($this->response_headers() as $header)
                header($header, true);
        }
        $header_size = $this->info(CURLINFO_HEADER_SIZE);
        return substr($this->response, $header_size);
    }


    public function response_headers()
    {
        $header_size    = $this->info(CURLINFO_HEADER_SIZE);
        $header_str     = substr($this->response, 0, $header_size);
        return explode("\r\n", $header_str);
    }


    public function info($option = null)
    {
        if (isset($option)) $info = curl_getinfo($this->handle, $option);
        else $info = curl_getinfo($this->handle);

        return $info;
    }


    public function errno()
    {
        return curl_errno($this->handle);
    }


    public function error()
    {
        return curl_error($this->handle);
    }


    public function strerror()
    {
        return curl_strerror($this->errno());
    }

    //Complex methods//

    public function postArgs($arr, $form_data = false)
    {
        if ($form_data) $query = $arr;
        else $query = http_build_query($arr);

        return $this->options(CURLOPT_POSTFIELDS, $query);
    }


    public function headers($arr = null, $scratch = false)
    {
        if ($arr === null) return $this->headers;
        if ($scratch) $this->headers = [];
        $headers = http_build_headers($arr, true);
        foreach ($headers as $value)
            $this->headers[] = $value;
        return true;
    }
}