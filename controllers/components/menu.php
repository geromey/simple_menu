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

	/**
	 *
	 * menus before being sent to the view
	 * @var array
	 */
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
	 * @param string $menuName
	 * @param string $name
	 * @param array $link
	 * @param array $options
	 */
	public function add($menuName, $name, $link = null, $options = null) {
		if (!isset($this->_menus[$menuName]))
			$this->_menus[$menuName] = array();
		$this->_menus[$menuName][] = array($name, $link, $options);
		return $this;
	}
}