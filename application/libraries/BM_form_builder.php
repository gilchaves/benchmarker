<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once 'formBuilder.php';

/**
 * Description of BM_form_builder
 *
 * @author fulvi
 */
class BM_form_builder extends formBuilder {

    protected $CI;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->helper('url', 'form');
    }

    public function set_options_for($input_name, $options, bool $multiselect = false) {
        $index = $this->search_structure_key('id', $input_name);
        $temp_item = $this->form_structure[$index];
        $temp_value = $this->form_values[$index];
        unset($this->form_structure[$index]);
        unset($this->form_values[$index]);
        $temp_item['options'] = $options;
        $temp_item['type'] = ($multiselect) ? 'multiselect' : 'select';
        $this->form_structure[($multiselect) ? $input_name . '[]' : $input_name] = $temp_item;
        $this->form_values[($multiselect) ? $input_name . '[]' : $input_name] = $temp_value;
    }

    public function set_extra_for($input_name, $extra) {
        $this->form_structure[$this->search_structure_key('id', $input_name)]['extra'] = $extra;
    }

    public function build_input_select($input_name, array $input_data) {
        extract($input_data);

        if (!isset($options)) {
            $options = [];
        }

        $extra_data = [
            'id' => $id,
            'name' => $input_name,
        ];

        if (isset($extra)) {
            $extra_data = array_merge($extra_data, $extra);
        }

        $selected = (isset($this->form_values[$input_name]) ? $this->form_values[$input_name] : set_value($input_name, ''));
        $this->CI->load->helper('form');
        return form_dropdown($input_name, $options, $selected, $extra_data);
    }

    public function build_input_multiselect($input_name, array $input_data) {
        extract($input_data);

        if (!isset($options)) {
            $options = [];
        }

        $extra_data = [
            'id' => $id,
            'name' => $input_name,
        ];

        if (isset($extra)) {
            $extra_data = array_merge($extra_data, $extra);
        }
        $selected = (isset($this->form_values[$input_name]) ? $this->form_values[$input_name] : set_value($input_name, []));
        $this->CI->load->helper('form');
        return form_multiselect($input_name, $options, $selected, $extra_data);
    }

    public function build_input_textarea($input_name, array $input_data) {

        extract($input_data);
        $extra_data = [
            'id' => $id,
            'name' => $input_name,
        ];

        if (isset($extra)) {
            $extra_data = array_merge($extra_data, $extra);
        }
        $value = (isset($this->form_values[$input_name]) ? $this->form_values[$input_name] : set_value($input_name, ''));
        $this->CI->load->helper('form');
        return form_textarea($input_name, $value, $extra_data);
    }

    private function build_input($input_name, array $input_data) {

        extract($input_data);
        $extra_data = [
            'id' => $id,
            'name' => $input_name,
            'type' => ($type ?? 'text'),
            'placeholder' => ($placeholder ?? ''),
            'maxlength' => ($size),
        ];

        if (isset($extra)) {
            $extra_data = array_merge($extra_data, $extra);
        }

        return form_input($data, (isset($this->form_values[$input_name]) ? $this->form_values[$input_name] : set_value($input_name, '')), $extra_data);
    }

    private function search_structure_key($column_key, $value) {
        foreach ($this->form_structure as $key => $val) {
            if ($val[$column_key] === $value) {
                return $key;
            }
        }
        return null;
    }

}
