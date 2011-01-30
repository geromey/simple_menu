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
      $View = ClassRegistry::getObject('view');
      $menu = $View->getVar('menus');
      if (is_array($menu))
        $this->_menus = $menu;
    }
  }

  /**
   *
   * Add a menu item to a menu
   * @param string $menu_name
   * @param string $name
   * @param array $link
   * @param array $options
   */
  public function add($menu_name,$name, $link = null, $options = null) {
    if (!isset($menu_name))
      $this->_menus[$menu_name] = array();
    $this->_menus[$menu_name] = array($name, $link, $options);
  }


/**
 * Returns the html code of a specific menu
 *
 * @param string $separator Text to separate crumbs.
 * @param string $startText This will be the first crumb, if false it defaults to first crumb in array
 * @return string Composed bread crumbs
 * @access public
 */
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
 */
	public function get($menu_name, $style = 'ul') {
		if (empty($this->_menus[$menu_name]))
		  return null;

		$items = array();
	  foreach ($this->_menus[$menu_name] as $item) {
	      $items[] = $this->_formatItem($item);
	  }

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

	protected function _formatItem($item) {
	  if (empty($item[1]))
	    return $item[0];
	  return $this->Html->link($item[0], $item[1], $item[2]);
	}

}