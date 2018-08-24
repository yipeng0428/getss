<?php


class SSR_Node extends SS_Node
{

    protected $protocol;
    protected $obfs;

    /**
     * SSRNode constructor.
     * @param $protocol
     * @param $obfs
     */
    public function __construct($serverIP, $serverPort, $method = "aes-256-cfb", $password, $remark = "", $protocol = "origin", $obfs = "plain")
    {
        $this->serverIP = $serverIP;
        $this->serverPort = $serverPort;
        $this->method = $method;
        $this->password = $password;
        $this->remark = $remark;
        $this->protocol = $protocol;
        $this->obfs = $obfs;
    }

    /**
     * @return string
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * @param string $protocol
     */
    public function setProtocol($protocol)
    {
        $this->protocol = $protocol;
    }

    /**
     * @return string
     */
    public function getObfs()
    {
        return $this->obfs;
    }

    /**
     * @param string $obfs
     */
    public function setObfs($obfs)
    {
        $this->obfs = $obfs;
    }


    function generateLink()
    {
        return $this->generateSSRLink();
    }


    function generateSSRLink()
    {
        $code = $this->serverIP . ":" .
            $this->serverPort . ":" .
            $this->protocol . ":" .
            $this->method . ":" .
            $this->obfs . ":" .
            Util::urlsafe_b64encode($this->password) .
            "/?group=" .
            Util::urlsafe_b64encode("free") .
            "&remarks=" .
            Util:: urlsafe_b64encode($this->remark . $this->getServerIP());
        return "ssr://" . Util::urlsafe_b64encode($code);
    }

}