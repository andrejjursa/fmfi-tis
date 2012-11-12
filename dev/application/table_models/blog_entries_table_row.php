<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Blog_entries_table_row extends Abstract_table_row {
    
    protected $relation_comments = '';
    
    protected $relation_images = '';
    
    protected $relation_tags = '';
    
    protected function init() {
        $this->relation_comments = $this->load->table_relation('blog_entries', 'blog_comments');
        $this->relation_images = $this->load->table_relation('blog_entries', 'blog_images');
        $this->relation_tags = $this->load->table_relation('blog_entries', 'blog_tags');
    }
    
    protected function resetRelations() {
        $this->relation_comments->reset();
        $this->relation_images->reset();
        $this->relation_tags->reset();
    }
    
    public function getComments() {
        return $this->relation_comments->get($this->getId());
    }
    
    public function getImages() {
        return $this->relation_images->get($this->getId(), $this->data('images'));
    }
    
    public function getTags() {
        return $this->relation_tags->get($this->getId());
    }
    
    public function addTag($tag_id, $after_id = NULL) {
        return $this->relation_tags->add($this->getId(), $tag_id, $after_id);
    }
    
    public function removeTag($tag_id) {
        return $this->relation_tags->delete($this->getId(), $tag_id);
    }
    
    public function removeAllTags() {
        return $this->relation_tags->deleteAll($this->getId());
    }
    
    public function setTags($tags) {
        return $this->relation_tags->setTo($this->getId(), $tags);
    }
}

?>