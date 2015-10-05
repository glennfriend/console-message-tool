<?php

namespace blocks;

class BaseBlock
{

    /**
     *  output value
     */
    protected $value = '';

    /**
     *
     */
    public function __construct()
    {
        // please rewrite
    }

    /**
     *  quick output
     */
    public function __toString()
    {
        return $this->getTemplate();
    }

    /* --------------------------------------------------------------------------------
        
    -------------------------------------------------------------------------------- */

    /**
     *  讀取 template.php
     */
    protected function getTemplate()
    {
        $className = get_class($this);
        $classNames = explode('\\', $className);
        if ( !isset($classNames[1]) ) {
            return null;
        }

        $blockName = $classNames[1];
        $file = \Config::get('app.base.path') . '/app/'. APP_PORTAL .'_mods/blocks/'. $blockName . '/template.php';
        if ( !file_exists($file) ) {
            return null;
        }

        ob_start();
            include $file;
            $tmp = ob_get_contents();
        ob_end_clean();
        return $tmp;
    }

    /**
     *  output
     */
    public function toHtml()
    {
        return $this->value;
    }

}