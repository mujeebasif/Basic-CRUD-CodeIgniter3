<?php
/**
 * Created by PhpStorm.
 * User: Scrun3r
 * Date: 01-Aug-15
 * Time: 3:59 PM
 */
class News extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('news/news_model');
    }

    public function index()
    {
        $this->load->library('session');
        $data['alert']=$this->session->flashdata('alert');

        $data['news'] = $this->news_model->get_news();
        $data['title'] = 'News list';

        $this->load->view('templates/header', $data);
        $this->load->view('news/index', $data);
        $this->load->view('templates/footer');
    }

    public function view($slug = NULL)
    {
        $data['news_item'] = $this->news_model->get_news($slug);

        if (empty($data['news_item']))
        {
            show_404();
        }

        $data['title'] = $data['news_item']['title'];

        $this->load->view('templates/header', $data);
        $this->load->view('news/view', $data);
        $this->load->view('templates/footer');
    }

    public function edit($id=0)
    {
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');

        if( !empty($id) )
        $data['news_item'] = $this->news_model->get_news($id);

        $data['title'] = 'Edit';

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('text', 'text', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data);
            $this->load->view('news/edit');
            $this->load->view('templates/footer');
        }
        else
        {
            $saved = $this->news_model->set_news();

            $this->load->library('session');

            if($saved)
            {

                $alert=array('msg'=>'Record Saved Successfully!','type'=>'success');
                $this->session->set_flashdata('alert',$alert);

                redirect('news');
            }
            else
            {
                $alert=array('msg'=>'Record Saving Failed. try again.','type'=>'warning');
                $this->session->set_flashdata('alert',$alert);

                redirect('news');
            }

        }
    }

    //4ajax
    public function delete($id = 0)
    {
        if(empty($id))
        {
            header('HTTP/1.1 400 Bad Request',true,400);
            echo 'Required Filed missing! id';
            return false;
        }

        $deleted = $this->news_model->delete_news($id);

        if( empty($deleted) )
        {
            header('HTTP/1.1 500 Server Error',true,500);
            echo 'Record Deletion Failed. DB error.';
            return false;
        }

        echo 'Deleted';
        return true;
    }
}