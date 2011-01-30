<?php
/**
 * Menu Helper
 *
 * Menu view helper allowing to add menu items and display menus
 *
 * @author Gerome Romey
 * @package SimpleMenu
 * @subpackage controllers.components
 */
class MenuComponent extends Object {
  protected $_menus = array();

  /**
   *
   * If menu not empty, set the var menus in the view
   * @param Controller $Controller
   */
  public function beforeRender(Controller $Controller) {
    if (!empty($this->_menus))
      $Controller->set('menus',$this->_menus);
  }

  /**
   *
   * Add an item to the menu. this item can be a link or just text if no link specified
   * @param string $menu_name
   * @param string $name
   * @param array $link
   * @param array $options
   */
  public function add($menu_name, $name, $link = null, $options = null) {
    if (!isset($this->_menus[$menu_name]))
      $this->_menus[$menu_name] = array();
    $this->_menus[$menu_name][] = array($name, $link, $options);
  }
}
