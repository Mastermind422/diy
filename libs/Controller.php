<?php

/**
 * @property  model
 * @author      Obed Ademang <kizit2012@gmail.com>
 * @copyright   Copyright (C), 2015 Obed Ademang
 * @license     MIT LICENSE (https://opensource.org/licenses/MIT)
 *              Refer to the LICENSE file distributed within the package.
 *
 * 
 */
class Controller {
    private $_errorMessage = null;
    private $_successMessage = null;
    private $_menuItems = array();
    private $_navAttrs = array(
        'fixed' => 'top',
        'contrast' => 'light',
        'brandName' => array('name' => 'DoItYourself', 'url' => '../home/index'),
        'centerContent' => False,
        'alignment' => 'left',
        'search' => False,
        'searchAlignment' => 'right',
        'searchTarget' => '#',
        'searchBtnClass' => 'default',
        'logoPath' => ''
    );

    /**
     * Controller constructor.
     */
    public function __construct() {
        Session::init(); //Begin session on every page ...
        $this->view = new View(); //Controls view processes ...
        $this->formData = new Form(); //Controls form data passing ...
        $this->view->dexport('base_url', BASE_URL);
        $this->frontend = $this->view->frontend(FRONTEND_UI);
        $this->view->dexport('nav', $this->frontend->navigation($this->_menuItems, $this->_navAttrs));
        $this->view->dexport('bootstrapCSS', $this->frontend->getPathToStatics()['css']);
        $this->view->dexport('bootstrapJS', $this->frontend->getPathToStatics()['js']);
    }

    /**
     * @param $name
     * @param string $modelPath
     */
    public function loadModel($name, $modelPath = 'model/') {
        (empty($name)) ? die("Expects a name of a model to load!!") : $path = $modelPath . $name . '_model.php';
        if (file_exists($path)) {
            require $path;
            $modelName = $name . '_Model';
            $this->model = new $modelName();
        }
    }

    /**
     * location - Shortcut for a page redirect
     *
     * @param string $url 
     */
    public function location($url) {
        header("Location: $url");
        exit(0);
    }

    /**
     * @param $message
     */
    public function setErrorMessage($message){
        $this->_errorMessage = $message;
        apc_store('errorMessage', $this->_errorMessage);
    }

    /**
     * @return mixed
     */
    public function fetchErrorMessage(){
        return apc_fetch('errorMessage');
    }

    /**
     * @param $message
     */
    public function setSuccessMessage($message){
        $this->_successMessage = $message;
        apc_store('successMessage', $this->_successMessage);
    }

    /**
     * @return mixed
     */
    public function fetchSuccessMessage(){
        return apc_fetch('successMessage');
    }

    /**
     * @param array $navAttrs
     */
    public function setNavAttrs($navAttrs) {
        $this->_navAttrs = $navAttrs;
    }

    /**
     * @param $key
     * @param array $value
     */
    public function addMenuItem($key, $value = array()) {
        # Check whether a menu key already exists
        if(array_key_exists($key, $this->_menuItems) !== True){
            # Check whether the values given has keys text, url and icon
            if(DUtil::array_keys_exists($value, array('text', 'url', 'icon')) === True){
                $this->_menuItems[$key] = $value;
            } else {
                die();
            }
        }
    }
}
