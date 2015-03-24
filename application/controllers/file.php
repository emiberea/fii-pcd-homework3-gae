<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'google/appengine/api/cloud_storage/CloudStorageTools.php';
use google\appengine\api\cloud_storage\CloudStorageTools;
use google\appengine\api\users\User;
use google\appengine\api\users\UserService;

class File extends CI_Controller {

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

        $options = [ 'gs_bucket_name' => 'fii-pcd-homework3.appspot.com' ];
        $data['upload_url'] = CloudStorageTools::createUploadUrl('/file/upload', $options);

		$this->load->view('templates/header', $data);
		$this->load->view('file/index', $data);
		$this->load->view('templates/footer');
	}

    public function upload()
    {
        $gs_name = $_FILES['uploaded_files']['tmp_name'];
        move_uploaded_file($gs_name, 'gs://fii-pcd-homework3.appspot.com/'. $_FILES['uploaded_files']['name']);
        CloudStorageTools::serve('gs://fii-pcd-homework3.appspot.com/'. $_FILES['uploaded_files']['name']);
    }

    public function test()
    {
        $object_url = 'gs://fii-pcd-homework3.appspot.com/'.time().rand(0,1000).'.txt';
        $options = stream_context_create(['gs'=>['acl'=>'public-read']]);

        $my_file = fopen($object_url, 'w', false, $options);
        for($i = 0; $i < 900; $i++) {
            fwrite($my_file, 'Number '.$i.' - '.rand(0,1000).'\n');
        }
        fclose($my_file);

        $object_public_url = CloudStorageTools::getPublicUrl($object_url, false);

        header('Location:' .$object_public_url);
    }
}

/* End of file file.php */
/* Location: ./application/controllers/file.php */