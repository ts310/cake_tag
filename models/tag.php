<?php

class Tag extends TagAppModel {
    public $actsAs = array(
        'Containable'
    );

    public $validate = array(
        'name' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'message' => 'Name is required'
            )
        )
    );

    /**
     * Update used field
     * @return 
     * @param object $model
     */
    // public function updateUsed() {
        // $TagObject = ClassRegistry::init('Tag.TagObject');
        // if ($tags = $this->find('all')) {
            // foreach($tags as $tag) {
                // $this->set('id', $tag['Tag']['id']);
                // $this->saveField('used', $TagObject->find('count', array(
                    // 'contain' => false,
                    // 'conditions' => array('TagObject.tag_id' => $tag['Tag']['id'])
                // )));
            // }
        // }
        // return true;
    // }

    /**
     * Remove tags has no reference
     * @return Mixed
     */
    // public function removeNotUsed() {
        // $TagObject = ClassRegistry::init('Tag.TagObject');
        // $sql = "DELETE FROM {$this->tablePrefix}{$this->table}
        // WHERE id NOT IN (
            // SELECT tag_id FROM {$TagObject->tablePrefix}{$TagObject->table}
        // )";
        // return $this->query($sql);
    // }
}
