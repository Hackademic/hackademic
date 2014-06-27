<?php 
  // HACKADEMIC_PLUGIN_PATH points to the system plugin folder
  require_once(HACKADEMIC_PLUGIN_PATH . "teachingModules/controllers/EditModuleController.php");

  $controller = new EditModuleController();
  echo $controller->go();
 
  ?>