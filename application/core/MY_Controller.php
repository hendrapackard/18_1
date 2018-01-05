<?php
class MY_Controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        //Memanggil model secara otomatis berdasarkan nama controllernya
        $model = get_class($this);
        if (file_exists(APPPATH. 'models/' . $model . '_model.php')) {
            $this->load->model($model . '_model', strtolower($model), true);
        }
    }
}