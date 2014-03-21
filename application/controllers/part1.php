<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Part1 extends CI_Controller {
    function __construct(){	
        parent::__construct();
        $this->load->model('part1_model','',TRUE);
    }
    public function index(){
        $content = strtolower(get_class($this)).'/'.__FUNCTION__;
        $this->load->view($content);
    }
    public function allGrid(){
        $allGetValues = $this->input->get(NULL,TRUE);
        $list = $this->part1_model->getAllGridData($allGetValues);
         $this->output
              ->set_content_type('application/json')
              ->set_output(json_encode($list));
    }
}
