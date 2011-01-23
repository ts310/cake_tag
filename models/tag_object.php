<?php

class TagObject extends TagAppModel {
    public $useTable = "tags_objects";
    public $actsAs = array(
        'Containable',
        'Sorting.Incremental' => array('unique' => array('object_id', 'object'))
    );

    public $belongsTo = array(
        'Tag' => array(
            'className' => 'Tag.Tag',
            'counterCache' => true
        )
    );

    public $validate = array(
        'tag_id' => array(
            'unique' => array(
                'rule' => 'isAssociationUnique',
                'message' => 'Same association already exist!'
            )
        )
    );

    public function beforeDelete() {
        if($this->id) {
            $data = $this->findById($this->id);
            $Tag = ClassRegistry::init('Tag.Tag');
            $tag = $Tag->findById($data[$this->alias]['tag_id']);
            $used = $tag['Tag']['used'] - 1;
            if ($used > 0) {
                $Tag->id = $tag['Tag']['id'];
                $Tag->saveField('used', $used);
            } else {
                $Tag->delete($tag['Tag']['id']);
            }
        }
        return parent::beforeDelete();
    }

    public function isAssociationUnique() {
        $conditions = array(
            "{$this->alias}.tag_id"    => $this->data[$this->alias]['tag_id'],
            "{$this->alias}.object"    => $this->data[$this->alias]['object'],
            "{$this->alias}.object_id" => $this->data[$this->alias]['object_id']
        );
        return !$this->hasAny($conditions);
    }
}
