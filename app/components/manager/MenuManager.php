<?php
/**
 *  MenuManager
 *  
 */
class MenuManager
{

    CONST LOWEST_ROLE = 'role-visit';

    /**
     *
     */
    static protected $_options = array();

    /**
     *
     */
    static protected $_mainKey = null;

    /**
     *
     */
    static protected $_subKey = null;

    /**
     *  add option
     *      - 如果 main key 相同, 則後面會覆蓋前面的設定
     *
     *  @return boolean
     */
    static public function addOption( $option )
    {
        $option += array(
            'main' => array(),
            'sub'  => array()
        );

        $key = null;
        if ( isset($option['main']['key']) ) {
            $key = $option['main']['key'];
        }

        if ( !$key ) {
            return false;
        }

        // auto setting role
        if ( !isset($option['main']['role']) ) {
            $option['main']['role'] = self::LOWEST_ROLE;
        }
        foreach ( $option['sub'] as $index => $sub ) {
            if ( !isset($option['sub'][$index]['role']) ) {
                $option['sub'][$index]['role'] = self::LOWEST_ROLE;
            }
        }

        // auto setting label
        if ( !isset($option['main']['label']) ) {
            $option['main']['label'] = ucfirst($option['main']['key']);
        }
        foreach ( $option['sub'] as $index => $sub ) {
            if ( !isset($option['sub'][$index]['label']) ) {
                $option['sub'][$index]['label'] = ucfirst($option['sub'][$index]['key']);
            }
        }

        // save to
        self::$_options[$key] = $option;
        return true;
    }

    /**
     *
     */
    static public function getMainKey()
    {
        return self::$_mainKey;
    }

    /**
     *  設定現在在那一個 main menu
     *
     *  @return boolean
     */
    static public function setMainKey( $key )
    {
        $menu = self::getMenu($key);
        if ( !$menu ) {
            return false;
        }
        self::$_mainKey = $key;
        return true;
    }

    /**
     *
     */
    static public function getSubKey()
    {
        return self::$_subKey;
    }

    /**
     *  設定現在在那一個 sub menu
     *      - 該程式會 validate
     *
     *  @return boolean
     */
    static public function setSubKey( $subKey )
    {
        $mainKey = self::getMainKey();
        if ( !$mainKey ) {
            return false;
        }

        if ( !isset(self::$_options[$mainKey]) ) {
            return false;
        }
        $option = self::$_options[$mainKey];

        foreach ( $option['sub'] as $index => $sub ) {
            if ( $sub['key'] === $subKey ) {
                self::$_subKey = $subKey;
                return true;
            }
        }

        return false;
    }

    /* --------------------------------------------------------------------------------
        extends
    -------------------------------------------------------------------------------- */

    /**
     *  get menu
     *  取得 focus 的 main menu
     *
     *  @return array or null
     */
    static public function getMenu( $key )
    {
        if ( $key && isset(self::$_options[$key]) ) {
            return self::$_options[$key];
        }
        return null;
    }

    /**
     *  取得 focus 的 main menu
     *
     *  @return array or empty array
     */
    static public function getMain()
    {
        $mainKey = self::getMainKey();
        if ( !$mainKey ) {
            return array();
        }
        return self::getMenu( $mainKey );
    }

    /**
     *  取得 focus 的 sub menu
     *
     *  @return array or empty array
     */
    static public function getSub()
    {
        $mainKey = self::getMainKey();
        $subKey  = self::getSubKey();
        if ( !$mainKey || !$subKey ) {
            return array();
        }

        $menu = self::getMenu( $mainKey );
        foreach ( $menu['sub'] as $sub ) {
            if ( $sub['key'] === $subKey ) {
                return $sub;
            }
        }
        return array();
    }

    /**
     *  
     */
    static public function getAllMenu()
    {
        return self::$_options;
    }

}

