# SimpleMenu Plugin for CakePHP #

Originally inspired by
 * http://bakery.cakephp.org/articles/rees/2010/08/14/breadcrumbs
 * http://tv.cakephp.org/video/CakeFoundation/2010/12/24/pierre_martin_-_using_and_reusing_plugins_across_cakephp_applications  

This plugin make easy the menu creation from controllers and views.

When it makes more sense setting the items of yours menus in the controllers,
It is not a straight forward thing to do in cakePHP.

This SimpleMenu allow you to do just that and for as many menus as you want.

This plugin works great for Breadcrumbs as well!


## Installation ##


in your plugin folder:

git clone git@github.com:geromey/simple_menu.git


in app_controller:
	var $components = array(/*...*/ 'SimpleMenu.Menu');
	var $helpers = array(/*...*/ 'SimpleMenu.Menu');

anywhere in the controllers:

	function beforeFilter() {
		parent::beforeFilter();
		$this->Menu->add('general', __('News',true), array('controller'=>'news','action' =>'index'));
		$this->Menu->add('general', __('Contact',true), array('controller'=>'pages','action' =>'display','contact'));
		$this->Menu->add('general', __('Links',true), array('controller'=>'links','action' =>'index'));

		$this->Menu->add('breadcrumbs',__('Home',true), array('controller'=>'pages','action'=>'display','home'));

		// in the news controller
		$this->Menu->add('breadcrumbs',__('News',true), array('action'=>'index'));

in views (mostly layouts):

	<div id="navbar">
		<?php echo $this->Menu->get('general', 'ul') ?>
	</div>

	<div class="breadcrumbs">
		<?php echo $this->Menu->getCrumbs() ?>
	</div>
	
	<div class="DIY-menu">
		<?php foreach($this->Menu->getItems('general') as $item): ?>
			<p><?php echo $item ?></p> 
		<?php endforeach ?>
	</div>
	
	
	