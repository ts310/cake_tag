# Tagging plugin for CakePHP

Usage: 

- Add Tagging behavior to model.

    var $actsAs = array(
        'Tag.Tagging'
    );

- Add tags form field

    echo $this->Form->input('tags', array('type' => 'text'));
