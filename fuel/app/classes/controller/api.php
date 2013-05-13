<?php

/** 
 * @return 
 *
 * HTTP Status Response Codes
 * 200 - OK.
 * 201 - Created.
 * 400 - Bad Request.
 * 401 - Unauthorized. 
 * 404 - Not Found. 
 *
 */
class Controller_Api extends Controller_Rest
{ 
    protected $format           = 'json';
    protected $require_admin    = false;
    protected $require_role     = 'administrator';

    /**
     * Response Header
     *
     */
    private $_head      = array();

    /**
     * Response Summary
     *
     */
    private $_summmary  = array();

    /**
     * Response Data
     *
     */
    protected $_data  = array();

    protected $_uid;

    public function router($method,$params)
    {

        $user       = \Auth::instance()->get_user_id();
        $this->_uid  = $user[1];

        #if image upload then get csrf token from post
        $is_image = Input::post('image');

        $by_pass_ajax = ($is_image === 'upload') ? true : false;

        $csrf_token = Input::cookie('fuel_csrf_token');

        if((!Security::check_token($csrf_token) or (!Input::is_ajax() and !$by_pass_ajax)) and Fuel::$env !== Fuel::DEVELOPMENT and Fuel::$env !== Fuel::STAGE)
            return $this->error('Invalid state.', 401);

        if(!$this->require_admin)
            return parent::router($method, $params);

        $authorised = $this->is_roles();

        if(!$authorised)
            return $this->error('Not authorized.', 401);

        parent::router($method, $params);

    }

    protected function success($message = 'OK.', $code = 200, $response = array())
    {

        $this->_head['status']      = $code;
        $this->_head['resource']    = Input::uri();
        $this->_head['message']     = $message;
        $this->_head['success']      = true;

        return $this->response(
            array_merge( array( 'head' => $this->_head), $response)
                , $code);

    }

    protected function error($message = 'Invalid state.', $code = 400, $description = "")
    {

        $this->_head['status']      = $code;
        $this->_head['resource']    = Input::uri();
        $this->_head['message']     = $message;
        $this->_head['error']       = true;
        $this->_head['description'] = $description;

        return $this->response(
            array( 'head' => $this->_head )
                , $code);

    }
}