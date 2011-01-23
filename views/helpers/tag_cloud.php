<?php

class TagCloudHelper extends AppHelper {
    public $helpers = array('Html');

    /**
     * Parse tag array and sets size value
     *
     * Calculation for tag cloud
     *
     * a = the smallest count (or occurrence).
     * b = the count of the tag being computed.
     * c = the largest count.
     * w = the smallest font-size.
     * x = the font-size for the tag. It is the unknown.
     * y = the largest font-size.
     *
     * x =  (((b-a) * (y-w)) / (c-a)) + w
     *
     * @param $tags
     * @return array
     */
    function parse($tags = array()) {
        $Tag = ClassRegistry::init('Tag.Tag');
        $maxQty = $Tag->field('MAX(Tag.used)', array(1 => 1));
        $minQty = $Tag->field('MIN(Tag.used)', array(1 => 1));
        $maxFontsize = 210;
        $minFontsize = 95;
        if (!empty($tags[0]['Tag']['id'])) {
            $tags = Set::sort($tags, '{n}.Tag.name', 'asc');
        } else {
            $tags = Set::sort($tags, '{n}.name', 'asc');
        }
        foreach ($tags as $key => $item) {
            if (!empty($item['Tag']['id'])) $item = $item['Tag'];
            $tags[$key] = $item;
            $size = ((($item['used'] - $minQty) * ($maxFontsize - $minFontsize)) / ($maxQty - $minQty)) + $minFontsize;
            $tags[$key]['size'] = $size;
            $tags[$key]['label'] = str_replace(" ", "&nbsp;", $item['name']);
        }
        return $tags;
    }
}
