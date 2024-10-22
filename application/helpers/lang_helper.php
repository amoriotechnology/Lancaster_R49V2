<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('display')) {

    function display($text = null) {
        $ci = & get_instance();
        $ci->load->database();
        $table = 'language';
        $phrase = 'phrase';
        $setting_table = 'web_setting';
        $default_lang = 'english';

        //set language  
        $data = $ci->db->get($setting_table)->row();
        if (!empty($data->language)) {
            $language = $data->language;
        } else {
            $language = $default_lang;
        }

        if (!empty($text)) {

            if ($ci->db->table_exists($table)) {

                if ($ci->db->field_exists($phrase, $table)) {

                    if ($ci->db->field_exists($language, $table)) {

                        $row = $ci->db->select($language)
                                ->from($table)
                                ->where($phrase, $text)
                                ->get()
                                ->row();

                        if (!empty($row->$language)) {
                            return html_escape($row->$language);
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}

 if (!function_exists('multiple_file_upload')) {
    function multiple_file_upload($file,$index, $filename,$filepath)
       {
           $CI =& get_instance();
           $CI->load->library('upload');
           $_FILES['file']['name'] = $_FILES[$file]['name'][$index];
           $_FILES['file']['type'] = $_FILES[$file]['type'][$index];
           $_FILES['file']['tmp_name'] = $_FILES[$file]['tmp_name'][$index];
           $config['max_size'] = '5000';
           $config['upload_path'] = $filepath;
           $config['allowed_types'] = IMAGE_ALLOWED_TYPES;
           $new_filename = $filename.'_'.time();
           $config['file_name'] = $new_filename;
           $CI->upload->initialize($config);
           if (!$CI->upload->do_upload('file')) {
               $error = array('error' => $CI->upload->display_errors());
               return $error;
           } else {
               $data = array('upload_data' => $CI->upload->data());
               return $data;
           }
       }
   }
if (!function_exists('checkFileType')) {
    function checkFileType($filename) {
        $fileExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $pdfExtension = 'pdf';
        if (in_array($fileExtension, $imageExtensions)) {
            return 'image';
        }
        if ($fileExtension === $pdfExtension) {
            return 'pdf';
        }
        return 'unknown';
    }
}
   // Common funtion in Attachments
if (!function_exists('insertAttachments')) {
    function insertAttachments($id,$filename,$filepath,$created_by,$module_name) {
        $ci = & get_instance();
        $ci->load->database();
        $data = array(
            'attachment_id' => $id,
            'files'         => $filename,
            'image_dir'     => $filepath,
            'created_by'    => $created_by,
            'sub_menu'      => $module_name,
        );
        $res = $ci->db->insert('attachments',$data);
        return $ci->db->insert_id;
    }
}