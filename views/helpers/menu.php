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
	 * @param array $item
	 * @return MenuHelper to allow chained calls
	 */
	public function add($menu_name, $item) {
		if (!isset($this->_menus[$menuName]))
			$this->_menus[$menuName] = new SimpleMenu();
		$this->_menus[$menuName]->add($item);
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
		if (!isset($this->_menus[$menu_name]))
		  return null;

		$items = $this->getLinks($menu_name);

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
		if (!isset($this->_menus[$menu_name]))
			return null;

		$items = $this->getLinks($menu_name, false);

		return join($separator, $items);
	}

	/**
	 *
	 * get the menu items for DIY display of the menu
	 * @param string $menu_name
	 * @param boolean $first_link
	 * @return array of the menu's links
	 */
	public function getLinks($menu_name, $last_link = true) {
		$links = array();
		if (isset($this->_menus[$menu_name])) {
			$items = $this->_menus[$menu_name]->getItems();
			if (!$last_link) { // do not display the last link if the $first_link = true
				$last_item_id = count($items) - 1;
				$items[$last_item_id]['link'] = null;
			}

			foreach ($items as $item) {
				if (empty($item['link'])) {
					$links[] = $item['name'];
				} else {
					$links[] = $this->Html->link($item['name'], $item['link'], $item['options']);
				}
			}
		}
		return $links;
	}

	/**
	 *
	 * return true if the menu has items and false otherwise
	 * @param string $menu_name
	 * @return boolean false if empty menu true if has items
	 */
	public function hasItems($menu_name) {
		return isset($this->_menus[$menu_name])
			&& 0 < count($this->_menus[$menu_name]->getItems());
	}
}