<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation
{
    function __construct($config =array())
    {
        parent::__construct($config);
    }

    function add_to_error_array($field = '', $message = '')

    {
        if (! isset($this->_error_array[$field]))
        {
            $this->_error_array[$field] = $message;
        }

        return;
    }

    function error_array()
    {
        if (count($this->_error_array) === 0)
            return FALSE;
        else
            return $this->_error_array;
    }
}
