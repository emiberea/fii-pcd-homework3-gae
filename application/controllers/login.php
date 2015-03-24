<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use google\appengine\api\users\User;
use google\appengine\api\users\UserService;

class Login extends CI_Controller {

	public function index()
	{
        if ($this->session->userdata('logged_in') == FALSE) {
            $user = UserService::getCurrentUser();
            if (!$user) {
                header('Location: ' . UserService::createLoginURL($_SERVER['REQUEST_URI']));
            } else {
                $this->session->set_userdata('logged_in', TRUE);
                $this->session->set_userdata('google_user_id', $user->getUserId());
                $this->session->set_userdata('google_email', $user->getEmail());
                $this->session->set_userdata('google_nickname', $user->getNickname());
            }

        }

        redirect('/home');
	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */