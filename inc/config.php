<?php
	if(!isset($_SESSION)) {
		session_start();
	}

	// Domänen med http
	defined("SITE_URL")
		|| define("SITE_URL", "http://" . $_SERVER['SERVER_NAME']);

	// Dir separerare.
	defined("DS")
		|| define("DS", DIRECTORY_SEPARATOR);

	// Root väg
	defined("ROOT_PATH")
		|| define("ROOT_PATH", realpath(dirname(__FILE__) . DS . ".." . DS));

	// Class mappen
	defined("CLASSES_DIR")
		|| define("CLASSES_DIR", "classes");

	// Pages mappen
	defined("PAGES_DIR")
		|| define("PAGES_DIR", "pages");

	// Inc mappen
	defined("INC_DIR")
		|| define("INC_DIR", "inc");

	// Template mappen
	defined("TEMPLATE_DIR")
		|| define("TEMPLATES_DIR", "templates");

	// Lägg till alla mappar till include path
	set_include_path(implode(PATH_SEPARATOR, array(
		realpath(ROOT_PATH . DS . CLASSES_DIR),
		realpath(ROOT_PATH . DS . PAGES_DIR),
		realpath(ROOT_PATH . DS . INC_DIR),
		realpath(ROOT_PATH . DS . TEMPLATES_DIR),
		get_include_path()
	)));
