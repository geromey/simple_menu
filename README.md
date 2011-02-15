# SimpleMenu Plugin for CakePHP #

You can contact me for questions, suggestions, advices.
You can fork it :)

Originally inspired by
 * http://bakery.cakephp.org/articles/rees/2010/08/14/breadcrumbs
 * http://tv.cakephp.org/video/CakeFoundation/2010/12/24/pierre_martin_-_using_and_reusing_plugins_across_cakephp_applications  
 * https://github.com/ebotunes/cakephp-bits/blob/plugins/helpers/sidebar.php

This plugin makes easy the menu, breadcrumb and sidebar management from controllers and views.


## Installation ##


in your plugin folder:

	git clone git@github.com:geromey/simple_menu.git

### Using the menu ###

in app_controller:

	var $components = array(/*...*/ 'SimpleMenu.Menu');
	var $helpers = array(/*...*/ 'SimpleMenu.Menu');

in controllers:

	function beforeFilter() {
		parent::beforeFilter();
		$this->Menu->add('general', array('name'=>__('News',true), 'link'=>array('controller'=>'news','action' =>'index')));
		$this->Menu->add('general', array('name'=>__('Contact',true), 'link'=>array('controller'=>'pages','action' =>'display','contact')));
		$this->Menu->add('general', array('name'=>__('Links',true), 'link'=>array('controller'=>'links','action' =>'index')));

		$this->Menu->add('breadcrumbs', array('name'=>__('Home',true), 'link'=>array('controller'=>'pages','action'=>'display','home')));

		// in the news controller
		$this->Menu->add('breadcrumbs', array('name'=>__('News',true), 'link'=>array('action'=>'index')));

in views:

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

### Using the sidebar ###

in app_controller:

	var $components = array(/*...*/ 'SimpleMenu.Sidebar');
	var $helpers = array(/*...*/ 'SimpleMenu.Sidebar');

in controllers:

	$sidebar->addBox(array('title'=>'Some Title','content'=>'blabla bla<br>bla bla'));
	// add the general menu to the sidebar
	$sidebar->addBox(array('title'=>'General Menu','menu'=>'general'));

in your layout:

	<?php echo $this->Sidebar->getSidebar() ?>