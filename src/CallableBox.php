<?php
namespace zimtis\arrayvalidation;

/**
 *
 * @author ZimTis
 *
 * @since 0.0.9 added
 *
 */
class CallableBox {
    /**
     * Contains the information for the callback, can be a closure or a string with fully qualified name of a function
     * /namespace/function | function
     * /namespace/Class::function | static function
     * /namespace/Class:function | non-static function, must be public
     *
     * In case of a non-static function, this will contain a array.
     * In short, this attribute contains the information for the call_user_func - function
     *
     * @var mixed
     */
    private $callable;

    public function __construct($callable){
        if ($callable instanceof \Closure) {
            $this->callable = $callable;
        } else if (is_string($callable)) {
            $result = array();
            $patter = "/^([a-zA-Z0-9_\\\]+?):([a-zA-Z0-9_]+?)$/";
            preg_match($patter, trim($callable), $result);

            if (count($result) != 0) {
                $this->callable = array(
                                        $result[1],
                                        $result[2] );
            } else {
                $this->callable = $callable;
            }
        } else {
            $this->callable = null;
        }
    }

    /**
     *
     * @return mixed
     */
    public function getCallable(){
        return $this->callable;
    }
}