<?php

class SS_Node implements NodeInterface
{
    protected $serverIP;
    protected $serverPort;
    protected $method;
    protected $password;
    protected $remark;

    public function __construct($serverIP, $serverPort, $method = "aes-256-cfb", $password, $remark)
    {
        $this->serverIP = $serverIP;
        $this->serverPort = $serverPort;
        $this->method = $method;
        $this->password = $password;
        $this->remark = $remark;
    }

    /**
     * @return mixed
     */
    public function getServerIP()
    {
        return $this->serverIP;
    }

    /**
     * @param mixed $serverIP
     */
    public function setServerIP($serverIP)
    {
        $this->serverIP = $serverIP;
    }

    /**
     * @return mixed
     */
    public function getServerPort()
    {
        return $this->serverPort;
    }

    /**
     * @param mixed $serverPort
     */
    public function setServerPort($serverPort)
    {
        $this->serverPort = $serverPort;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * @param mixed $remark
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;
    }


    function generateLink()
    {

        return $this->generateSSLink();
    }

    function generateSSLink()
    {
        $code = $this->method . ":" . $this->password . "@" . $this->serverIP . ":" . $this->serverPort;

        $base64Code = Util::urlsafe_b64encode($code);

        return "ss://$base64Code#" . $this->remark;
    }

}