<?php 
  // HACKADEMIC_PLUGIN_PATH points to the system plugin folder
  require_once(HACKADEMIC_PLUGIN_PATH . "teachingModules/controllers/AddModuleController.php");

  $controller = new AddModuleController();
  echo $controller->go();
 
  ?>