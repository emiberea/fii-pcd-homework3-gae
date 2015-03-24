<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use google\appengine\api\users\User;
use google\appengine\api\users\UserService;

class Home extends CI_Controller {

	public function index()
	{
        $data = array();
        $user = UserService::getCurrentUser();
        if (!$user) {
            $data['logged_in'] = FALSE;
            $data['username'] = 'Anonymous user';
        } else {
            $data['logged_in'] = TRUE;
            $data['username'] = $user->getEmail();
        }

		$this->load->view('templates/header', $data);
		$this->load->view('home/index');
		$this->load->view('templates/footer');
	}

    public function about()
    {
        $data = array();
        $user = UserService::getCurrentUser();
        if (!$user) {
            $data['logged_in'] = FALSE;
            $data['username'] = 'Anonymous user';
        } else {
            $data['logged_in'] = TRUE;
            $data['username'] = $user->getEmail();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('home/about');
        $this->load->view('templates/footer');
    }
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */