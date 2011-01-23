# Tagging plugin for CakePHP

Depend on cake_soring plugin.
http://github.com/ts310/cake_sorting

Usage: 

- Add Tagging behavior to model.

      var $actsAs = array(
          'Tag.Tagging'
      );

- Add tags form field

      echo $this->Form->input('tags', array('type' => 'text'));
