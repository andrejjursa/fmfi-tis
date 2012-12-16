<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

/**
 * @package TableModels
 */
class Inventions_table_row extends Abstract_table_row {
    
    /**
     * @var Abstract_table_relation list of all physicists related to this invention.
     */
    protected $physicists = null;
    
    /**
     * @var Abstract_table_relation relation to photo image.
     */
    protected $photo = null;
    
    /**
     * @var Abstract_table_relation relation to images for this invention.
     */
    protected $images;
    
    /**
     * @var Abstract_table_relation relation to periods.
     */
    protected $periods;
    
    /**
     * @var Abstract_table_relation relation to miniapps.
     */
    protected $miniapps;
    
    /**
     * Initialise all relations.
     */ 
    protected function init() {
        $this->physicists = $this->load->table_relation('inventions', 'physicists');
        $this->photo = $this->load->table_relation('inventions', 'one_image');
        $this->images = $this->load->table_relation('inventions', 'images');
        $this->periods = $this->load->table_relation('inventions', 'periods');
        $this->miniapps = $this->load->table_relation('inventions', 'miniapps');
    }
    
    /**
     * Reset all relations.
     */
    protected function resetRelations() {
        $this->physicists->reset();
        $this->photo->reset();
        $this->images->reset();
        $this->periods->reset();
        $this->miniapps->reset();
    }
    
    /**
     * Get all related physicists.
     * 
     * @param boolean $displayed_only return only displayed physicists when set to TRUE.
     * @return array<Abstract_table_row> related physicists.
     */
    public function getPhysicists($displayed_only = FALSE) {
        if ($displayed_only) {
            $this->physicists->setWhere('physicists.displayed = ?', array(1));
        } else {
            $this->physicists->setWhere(NULL);
        }
        return $this->physicists->setOrderBy('name')->get($this->getId());
    }
    
    /**
     * Returns all periods.
     * 
     * @return array<Abstract_table_row> periods.
     */
    public function getPeriods() {
        return $this->periods->get($this->getId()); 
    }
    
    /**
     * Check if this invention belongs to given period.
     * 
     * @return boolean TRUE if belongs.
     */
    public function getBelongsToPeriod($period) {
        return in_array($period, $this->periods->allIds($this->getId()));
    }
    
    /**
     * Returns photo object as instance of Images_table_row or blank
     * instance if no photo provided.
     * 
     * @return Abstract_table_row photo object.
     */
    public function getPhotoObject() {
        $photos = $this->photo->get($this->getId(), $this->getPhoto());
        if (count($photos)) { return $photos[0]; }
        return $this->load->table_row('images');    
    }
    
    /**
     * Get all related images for this invention.
     * 
     * @return array<Abstract_table_row> related images.
     */
    public function getImages() {
        return $this->images->get($this->getId());
    }
    
    /**
     * Returns all miniapps.
     * 
     * @return array<Abstract_table_row> miniapps.
     */
    public function getMiniapps() {
        return $this->miniapps->setOrderBy('name')->get($this->getId());
    }
    
    public function getDataForEditor() {
        $data = $this->data();
        
        $data['images'] = implode(',', $this->images->allIds($this->getId()));
        $data['miniapps'] = implode(',', $this->miniapps->allIds($this->getId()));
        
        return $data;
    }
    
    public function prepareEditorSave($formdata) {
        if (!isset($formdata['displayed'])) { $formdata['displayed'] = '0'; }
        
        $this->load->helper('application');
        
        if (isset($formdata['images'])) {
            $images = expandRelationListToArray($formdata['images']);
            $this->images->setTo($this->getId(), $images);
        }
        unset($formdata['images']);
        
        if (isset($formdata['miniapps'])) {
            $miniapps = expandRelationListToArray($formdata['miniapps']);
            $this->miniapps->setTo($this->getId(), $miniapps);
        }
        unset($formdata['miniapps']);
        
        $this->data($formdata);
    }
}

?>