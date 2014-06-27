<?php 
  // HACKADEMIC_PLUGIN_PATH points to the system plugin folder
  require_once(HACKADEMIC_PLUGIN_PATH . "teachingModules/controllers/ManageModulesController.php");

  $controller = new ManageModulesController();
  echo $controller->go();
 
  ?>