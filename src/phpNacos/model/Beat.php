<?php


namespace phpNacos\model;


class Beat extends Model
{
    protected $clientBeatInterval;
    protected $code;
    protected $lightBeatEnabled;

    /**
     * @return mixed
     */
    public function getClientBeatInterval()
    {
        return $this->clientBeatInterval;
    }

    /**
     * @param mixed $clientBeatInterval
     */
    public function setClientBeatInterval($clientBeatInterval)
    {
        $this->clientBeatInterval = $clientBeatInterval;
    } //int

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function setLightBeatEnabled($lightBeatEnabled)
    {
        $this->lightBeatEnabled = $lightBeatEnabled;
    }
}
