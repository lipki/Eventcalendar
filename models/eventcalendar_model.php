<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Eventcalendar_model extends Base_model {

    public function __construct() {
        
        parent::__construct();
        
        $this->load->model('Eventcalendarcategory_model', 'eventcalendarcategory_model', true);
        $this->load->model('Article_model', 'article_model', true);
        
        // Event Calendar Tables
        $this->table        = 'module_eventcalendar';
        $this->lang_table   = 'module_eventcalendar_lang';
        $this->pk_name      = 'id_event';
        
        // Event Calendar Category Tables
        $this->category_table        = 'module_eventcalendar_category';
        $this->category_lang_table   = 'module_eventcalendar_category_lang';
        $this->category_pk_name      = 'id_category';
    }
    
    function _get_events($where = FALSE, $lang = FALSE) {
        
        $lang = ($lang === FALSE) ? FALSE : $lang;
        $where = ($where === FALSE) ? FALSE : $where;
        
        $data = array();
        
        $events     = $this->eventcalendar_model->get_lang_list($where, $lang);
        $categories = $this->eventcalendarcategory_model->get_lang_list(FALSE, $lang);
        
        if(count($events > 0)) {
            
            $data = $events;
            
            foreach ($data as $Ekey => $Evalue) {
                if($Evalue['id_category'] != 0 && $Evalue['id_category'] != '')
                    foreach ($categories as $Ckey => $Cvalue)
                        if($Cvalue['id_category'] == $Evalue['id_category'] && $Cvalue['lang'] == $Evalue['lang'])
                            $data[$Ekey]['category'] = $Cvalue;
            }
        }
        
        return $data;
    }
    /**
    * Modded for Expanded Use 
    * Get one row_array
    *
    * @access	public
    * @param 	int		The result id
    * @return	object	A row object
    *
    */
    public function get_row_array($id = NULL, $pk_name = NULL, $table = NULL)
    {
        $pk_name = (! is_null($pk_name)) ? $pk_name : $this->pk_name;
        $table = (! is_null($table)) ? $table : $this->table;
        
        $this->{$this->db_group}->where($pk_name, $id);
        $query = $this->{$this->db_group}->get($table);

        return $query->row_array();
    }
    
   /**
    * Saves the Event
    *
    * @param 	array	Standard data table
    * @param 	array	Lang depending data table
    *
    * @return	int	Event saved ID
    *
    **/
    function save($data, $lang_data) 
    {
        $user = User()->get_user();
        
        if( ! $data[$this->pk_name] OR $data[$this->pk_name] == '') {
            $data['created'] = $data['updated'] = date('Y-m-d H:i:s');
            $data['author']  = $data['updater'] = $user['screen_name'];
        } else {
            $data['updater'] = $user['screen_name'];
            $data['updated'] = date('Y-m-d H:i:s');
        }

        // Dates
        $data['start_date'] = ($data['start_date']) ? getMysqlDatetime($data['start_date'], '%d.%m.%Y') : '0000-00-00';
        $data['end_date'] = ($data['end_date']) ? getMysqlDatetime($data['end_date'], '%d.%m.%Y') : '0000-00-00';

        return parent::save($data, $lang_data);
    }
    
}