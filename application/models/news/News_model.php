<?php
/**
 * Created by PhpStorm.
 * User: Scrun3r
 * Date: 01-Aug-15
 * Time: 3:47 PM
 */

class News_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_news($slug = FALSE)
    {
        if ($slug === FALSE)
        {
            $query = $this->db->get('news');
            return $query->result_array();
        }


        $column=(is_numeric($slug))?'id':'slug';

        $query = $this->db->get_where('news', array($column => $slug));

        return $query->row_array();
    }

    public function set_news()
    {
        $slug = url_title($this->input->post('title'), 'dash', TRUE);

        $data = array(
            'title' => $this->input->post('title'),
            'slug' => $slug,
            'text' => $this->input->post('text')
        );

        $id = $this->input->post('id');

        if( !empty($id) )
        {
            $this->db->where('id', $id);
            $result=$this->db->update('news', $data);
        }
        else
        {
            $result=$this->db->insert('news', $data);
        }

        return $result;
    }

    public function delete_news($id)
    {
        //extra check
        if( empty($id) )return false;

        return $this->db->delete('news', array('id' => $id));
    }
}