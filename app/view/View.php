<?php

class View {
	protected $view;

	public static function render($filename) {
	    echo '<div id="container">';
	    require Config::get('PATH_TEMPLATE').'header.php';
	    require Config::get('PATH_VIEW').$filename.'.php';
	    require Config::get('PATH_TEMPLATE').'footer.php';
	    echo '</div>';
	}
}