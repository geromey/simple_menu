<?php
/**
 *
 * Enable Controllers and components to add sideboxes
 * @author Gerome Romey
 * @package SimpleMenu
 * @subpackage controllers.components
 *
 */

class SidebarComponent extends Object {

	/**
	 *
	 * menus before being sent to the view
	 * @var array
	 */
	protected $_boxes = array();

	/**
	 *
	 * Default values
	 * @var unknown_type
	 */
	protected $_defaultBox = array(
		'element' => '',
		'menu' => '',
		'content' => '',
		'title' => null,
		'index' => false,
		'params' => array()
	);

	/**
	 *
	 * Save the boxes into the view variables to allow the helper to access it
	 * @param $Controller
	 */
	public function beforeRender(Controller $Controller) {
		if (!empty($this->_boxes))
			$Controller->set('sidebar_boxes',$this->_boxes);
	}


	/**
	 *	Takes a single parameter, an indexed array with the following keys:
	 *
	 * 	- content - The HTML content of the box.
	 * 	- element - If 'content' is empty, this will be interpreted as a Cake element (defined in views/elements/<element>.ctp). If 'content' is non-empty, this will be used as the ID of this box's div
	 * 	- title - The title of the box, which will be wrapped in an HTML tag specified by $options['title_tag']. A value of null will prevent the title tag being rendered at all.
	 *  - params - A parameter array to be passed to renderElement
	 *  - index - an optional numeric index, specifying the position of this box in the sidebar, starting at 0
	 *
	 * The passed box array must contain *either* a (non-empty) content or element. All other keys are optional.
	 *
	 * @param box
	 */
	public function addBox($box) {
		$box = array_merge($this->_defaultBox, $box);

		$elems = $this->_boxes;

		if (is_numeric($box['index'])) {
			$elems[$box['index']] = $box;
		} else {
			$elems[] = $box;
		}

		$this->_boxes = $elems;
		return $this;
	}
}
