<?php
namespace zimtis\arrayvalidation\model;

/**
 *
 * @author ZimTis
 *
 * @since 0.9.2 added
 */
class CallableResult
{

    /**
     * Whas this callable a success
     *
     * @var boolean
     */
    private $result;

    /**
     * string that will be returnes on error
     *
     * @var string
     */
    private $errorString;

    /**
     *
     * @return boolean
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     *
     * @param boolean $result
     * @return \zimtis\arrayvalidation\model\CallableResult
     */
    public function setResult($result)
    {
        $this->result = $result;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getErrorString()
    {
        return $this->errorString;
    }

    /**
     *
     * @param unknown $errorString
     * @return \zimtis\arrayvalidation\model\CallableResult
     */
    public function setErrorString($errorString)
    {
        $this->errorString = $errorString;
        return $this;
    }
}