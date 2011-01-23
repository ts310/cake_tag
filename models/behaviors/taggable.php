<?php

/**
 * Taggable behavior
 *
 * @author Tsuyoshi Saito
 */
class TaggableBehavior extends ModelBehavior {

    public function setup(&$model, $settings = array()) {
        $settings = (array) $settings;
        // Bind relation
        $model->bindModel(array(
            'hasAndBelongsToMany' => array(
                'Tag' => array(
                    'className'  => 'Tag.Tag',
                    'with'       => 'Tag.TagObject',
                    'foreignKey' => 'object_id',
                    'conditions' => array('TagObject.object'  => $model->alias),
                    'order'      => array('TagObject.sorting' => 'asc')
                )
            )
        ), false);
    }

    public function tag(&$model, $name = null) {
        if (empty($name)) return false;
        $Tag = ClassRegistry::init('Tag.Tag');
        $data = $Tag->find('first', array(
            'conditions' => array(
                'Tag.name LIKE' => $name
            )
        ));
        if (!$data) {
            $Tag->create();
            $saved = $Tag->save(array(
                'name' => $name,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ));
            if ($saved) {
                $Tag->id;
                $data = $Tag->read();
            }
        }
        return $data;
    }

    public function afterSave(&$model) {
        if (isset($model->data[$model->alias]['tags'])) {
            extract($model->hasAndBelongsToMany['Tag'], EXTR_SKIP);
            $TagObject = ClassRegistry::init('Tag.' . $with);
            $Tag = ClassRegistry::init('Tag.Tag');
            if ($model->id){
                $conditions = array(
                    $with . '.object' => $model->alias,
                    $with . '.' . $foreignKey => $model->id
                );
                $TagObject->deleteAll($conditions, true, true);
                $tags = Set::normalize($model->data[$model->alias]['tags'], false);
                if (!empty($tags) && count($tags) > 0) {
                    $i = 0;
                    foreach ($tags as $tag) {
                        $tagged = $this->tag($model, $tag);
                        if ($tagged) {
                            $TagObject->create();
                            $data = array(
                                'tag_id' => $tagged['Tag']['id'],
                                'object' => $model->alias,
                                $foreignKey => $model->id,
                                'sorting' => $i++
                            );
                            if ($saved = $TagObject->save($data)) {
                                $Tag->id = $tagged['Tag']['id'];
                                $Tag->saveField('used', $tagged['Tag']['used'] + 1);
                            }
                        }
                    }
                }
            }
        }
        return true;
    }

    public function afterFind(&$model, $results, $primary = false) {
        foreach ($results as $key => $result) {
            if (isset($result['Tag'])) {
                $tags = join(', ', Set::extract($result['Tag'], '{n}.name'));
                $results[$key][$model->alias]['tags'] = $tags;
            }
        }
        return $results;
    }
}

?>
