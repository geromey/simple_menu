<?php
/**
 * Menu Helper
 *
 * Menu view helper allowing to add menu items and display menus
 *
 * @author Gerome Romey
 * @package SimpleMenu
 * @subpackage SimpleMenu.views.helpers
 */
class MenuHelper extends AppHelper
{
	public $helpers = array('Html');

	/**
	 *
	 * Array which contains the menus
	 * @var unknown_type
	 */
	protected $_menus = array();

	/**
	 *
	 * init the menu items by getting the var menus from the view
	 */
	public function beforeRender() {
		parent::beforeRender();
		if (ClassRegistry::isKeySet('view')) {
			$view = ClassRegistry::getObject('view');
			$menu = $view->getVar('menus');
			if (is_array($menu))
				$this->_menus = array_merge($this->_menus, $menu);
		}
	}

	/**
	 *
	 * Add a menu item to a menu
	 * @param string $menu_name
	 * @param string $name
	 * @param array $link
	 * @param array $options
	 * @return MenuHelper to allow chained calls
	 */
	public function add($menu_name, $name, $link = null, $options = null) {
		if (!isset($menu_name))
			$this->_menus[$menu_name] = array();
		$this->_menus[$menu_name] = array($name, $link, $options);
		return $this;
	}

	/**
	 *
	 * Returns the html code of a specific menu
	 * The $style can be:
	 * - 'ul': output the menu in the form of a <ul><li>
	 * - 'div': output each item in a div
	 * - any other string: output the menu using the $style as separator
	 *   example: ' > ' or ' | ' or just spaces ' '
	 * @param string $menu_name Name of the menu
	 * @param string $style or the menu
	 * @return string html code of the menu
	 */
	public function get($menu_name, $style = 'ul') {
		if (empty($this->_menus[$menu_name]))
		  return null;

		$items = $this->getItems($menu_name);

		switch ($style) {
			case 'div':
				foreach ($items as $id => $item)
				{
					$items[$id] = $this->Html->div(null, $item);
				}
				return join('', $items);

			case 'ul':
				foreach ($items as $id => $item)
				{
					$items[$id] = $this->Html->tag('li',$item);
				}
				return $this->Html->tag('ul',join('', $items));
				break;
			default:
				return join($style, $items);
		}
	}

	/**
	 *
	 * Display the breadcrumbs
	 * This automatically remove the last link considaring it is the current page
	 * Just because the breadcrumbs look better that way :)
	 *
	 * @param string $menu_name
	 * @param string $separator
	 * @return string html code of the breadcrumbs
	 */
	public function getCrumbs($menu_name = 'breadcrumbs', $separator = ' > ') {
		if (empty($this->_menus[$menu_name]))
			return null;
		// Change the last link to text only as it is supposed to be the current page
		$last_item_id = count($this->_menus[$menu_name]) - 1;
		$this->_menus[$menu_name][$last_item_id] = array($this->_menus[$menu_name][$last_item_id][0]);

		$items = $this->getItems($menu_name);

		return join($separator, $items);
	}


	/**
	 *
	 * get the menu items for DIY display of the menu
	 * @param unknown_type $menu_name
	 * @return array of the menu's items
	 */
	public function getItems($menu_name) {
		$items = array();
		if (isset($this->_menus[$menu_name]) && is_array($this->_menus[$menu_name])) {
			foreach ($this->_menus[$menu_name] as $item) {
				if (empty($item[1]))
					$items[] = $item[0];
				else
					$items[] = $this->Html->link($item[0], $item[1], $item[2]);
			}
		}
		return $items;
	}


}