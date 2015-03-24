<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use google\appengine\api\users\User;
use google\appengine\api\users\UserService;

class Home extends CI_Controller {

	public function index()
	{
        $user = UserService::getCurrentUser();
        if (!$user) {
            header('Location: ' . UserService::createLoginURL($_SERVER['REQUEST_URI']));
        }

		$this->load->view('templates/header');
		$this->load->view('home/index');
		$this->load->view('templates/footer');
	}

    public function about()
    {
        $this->load->view('templates/header');
        $this->load->view('home/about');
        $this->load->view('templates/footer');
    }
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */