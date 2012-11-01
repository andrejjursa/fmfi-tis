<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Blog_entries_table_collection extends Abstract_table_collection {
    
    public function onlyNewEntries() {
        $timestamp = strtotime('now -1 week');
        $this->query->where('crdate >= ', $timestamp);
        
        return $this;
    }
    
}

?>