<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use google\appengine\api\users\User;
use google\appengine\api\users\UserService;

class Number extends CI_Controller {

	public function index()
	{
        $data = array();

        $user = UserService::getCurrentUser();
        if (!$user) {
            header('Location: ' . UserService::createLoginURL($_SERVER['REQUEST_URI']));
        } else {
            $data['logged_in'] = TRUE;
            $data['username'] = $user->getEmail();
        }

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $formData = [
                'no1' => $_POST['no1'],
                'no2' => $_POST['no2'],
            ];
            $formData = http_build_query($formData);

            $context = [
                'http' => [
                    'method' => 'POST',
                    'header'=> "Content-type: application/x-www-form-urlencoded\r\n"
                        . "Content-Length: " . strlen($formData) . "\r\n",
                    'content' => $formData,
                ]
            ];
            $context = stream_context_create($context);

            $result = file_get_contents('http://gae-php-tutorial-100.appspot.com/number-post', false, $context);
            $data['number_1'] = $_POST['no1'];
            $data['number_2'] = $_POST['no2'];
            $data['number_result'] = $result;

            // set values from memcache
            $memcache = new Memcache;
            if (!$memcache->get($user->getUserId())) {
                $resultStr = serialize([$result]);
                $memcache->set($user->getUserId(), $resultStr);
            } else {
                $resultArr = unserialize($memcache->get($user->getUserId()));
                $resultArr[] = $result;

                $resultStr = serialize($resultArr);
                $memcache->set($user->getUserId(), $resultStr);
            }
        }

		$this->load->view('templates/header', $data);
		$this->load->view('number/index', $data);
		$this->load->view('templates/footer');
	}

    public function average()
    {
        $data = array();

        $user = UserService::getCurrentUser();
        if (!$user) {
            header('Location: ' . UserService::createLoginURL($_SERVER['REQUEST_URI']));
        } else {
            $data['logged_in'] = TRUE;
            $data['username'] = $user->getEmail();

            // get numbers from memcache
            $memcache = new Memcache;
            $resultStr = $memcache->get($user->getUserId());
            if ($resultStr) {
                $resultArr = unserialize($resultStr);
                if ($resultArr) {
                    $average = array_sum($resultArr) / count($resultArr);
                } else {
                    $average = 'Not present in cache.';
                }
                $data['average'] = $average;
                $data['number_array'] = $resultArr;
            }

            $this->load->view('templates/header', $data);
            $this->load->view('number/average', $data);
            $this->load->view('templates/footer');
        }
    }
}

/* End of file number.php */
/* Location: ./application/controllers/number.php */