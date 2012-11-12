<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

class Physicists_table_collection extends Abstract_table_collection {
    
    public function filterLivedInYear($year) {
        $this->query->where('death_year >=', $year);
        $this->query->where('birth_year <=', $year);
        
        return $this;
    }
    
    public function filterMinYear() {
        $this->query->order_by('birth_year', 'ASC');
        $this->query->limit(1);
        
        return $this;
    }
    
    public function filterOnlyDisplayed() {
        $this->query->where('displayed', '1');
        
        return $this;
    }
}

?>