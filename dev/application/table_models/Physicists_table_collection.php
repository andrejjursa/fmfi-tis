<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

class Physicists_table_collection extends Abstract_table_collection {
    
    /**
     * Adds filter for all physicists living in suplied year.
     * 
     * @param type $year year.
     * @return Physicists_table_collection reference back to this object.
     */
    public function filterLivedInYear($year) {
        $this->query->where('death_year >=', $year);
        $this->query->where('birth_year <=', $year);
        
        return $this;
    }
    
    /**
     * Adds filter to find one record with minimum birth_year value.
     * 
     * @return Physicists_table_collection reference back to this object.
     */
    public function filterMinYear() {
        $this->query->order_by('birth_year', 'ASC');
        $this->query->limit(1);
        
        return $this;
    }
    
    /**
     * Adds filter to find only displayed physicists records.
     * 
     * @return Physicists_table_collection reference back to this object.
     */
    public function filterOnlyDisplayed() {
        $this->query->where('displayed', '1');
        
        return $this;
    }
}

?>