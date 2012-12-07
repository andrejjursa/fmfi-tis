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
     * Initialise all relations.
     */ 
    protected function init() {
        $this->physicists = $this->load->table_relation('inventions', 'physicists');
        $this->photo = $this->load->table_relation('inventions', 'one_image');
        $this->images = $this->load->table_relation('inventions', 'images');
    }
    
    /**
     * Reset all relations.
     */
    protected function resetRelations() {
        $this->physicists->reset();
        $this->photo->reset();
        $this->images->reset();
    }
    
    /**
     * Get all related physicists.
     * 
     * @return array<Abstract_table_row> related physicists.
     */
    public function getPhysicists() {
        return $this->physicists->get($this->getId());
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
    
    public function getDataForEditor() {
        $data = $this->data();
        
        $data['images'] = implode(',', $this->images->allIds($this->getId()));
        
        return $data;
    }
    
    public function prepareEditorSave($formdata) {
        if (!isset($formdata['displayed'])) { $formdata['displayed'] = '0'; }
        
        if (isset($formdata['images']) && $formdata['images'] != '0') {
            $images = explode(',', $formdata['images']);
            $this->images->setTo($this->getId(), $images);
        }
        unset($formdata['images']);
        
        $this->data($formdata);
    }
}

?>