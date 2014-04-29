<?php
require_once("../init.php");
require_once("../admin/model/class.Classes.php");
require_once("../admin/model/class.ClassMemberships.php");
require_once("../model/common/class.User.php");

$user = User::findByUserName("Guest");
$class_arr = Classes::getAllClasses();
$memberships = ClassMemberships::getMembershipsOfUser($user->id);

foreach($class_arr as $cls){
	$member=false;
		foreach($memberships as $mem)
			if($cls->id == $mem["class_id"]){
				$member = true;
		}
		if(!$member){
			ClassMemberships::AddMembership($user->id,$cls->id);
		}
}
