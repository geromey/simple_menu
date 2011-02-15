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
	 * @var key array of SimpleMenu
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
	 * @param array $item
	 */
	public function add($menuName, $item) {
		if (!isset($this->_menus[$menuName]))
			$this->_menus[$menuName] = new SimpleMenu();
		$this->_menus[$menuName]->add($item);
		return $this;
	}

	public function getMenu($menuName)
	{
		if (!isset($this->_menus[$menuName]))
			$this->_menus[$menuName] = new SimpleMenu();
		return $this->_menus[$menuName];
	}
}

class SimpleMenu {
	protected $_items = array();

	protected $_defaultItem = array(
		'name' => '',
		'link' => null,
		'options' => null,
	);

	public function add($item) {
		$item = array_merge($this->_defaultItem, $item);
		$this->_items[] = $item;
		return $this;
	}

	public function getItems() {
		return $this->_items;
	}

}