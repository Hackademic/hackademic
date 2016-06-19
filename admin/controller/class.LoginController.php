<?php

require_once HACKADEMIC_PATH."model/common/class.Session.php";
require_once HACKADEMIC_PATH."admin/controller/class.DashboardController.php";
require_once HACKADEMIC_PATH."admin/controller/class.HackademicBackendController.php";
require_once HACKADEMIC_PATH."model/common/class.User.php";

class LoginController extends HackademicBackendController
{

    private static $_action_type = 'admin_login';

    public function go()
    {
        $this->setViewTemplate('admin_login.tpl');
        $this->addPageTitle('Log in');

        if (self::isLoggedIn()) {
            header('Location: '.SOURCE_ROOT_PATH."?url=admin/dashboard");
            die();
        } else {
            if (isset($_POST['submit']) && $_POST['submit']=='Login'
                && isset($_POST['username']) && isset($_POST['pwd'])
            ) {
                if ($_POST['username']=='' || $_POST['pwd']=='') {
                    if ($_POST['username']=='') {
                        $this->addErrorMessage("Username must not be empty");
                        return $this->generateView(self::$_action_type);
                    } else {
                        $this->addErrorMessage("Password must not be empty");
                        return $this->generateView(self::$_action_type);
                    }
                } else {
                    $session = new Session();
                    $username = $_POST['username'];
                    $this->addToView('username', $username);
                    $user=User::findByUsername($username);
                    if (!$user) {
                        $this->addErrorMessage("Incorrect username or password");
                        return $this->generateView(self::$_action_type);
                    } elseif (!$session->pwdCheck($_POST['pwd'], $user->password)) {
                        $this->addErrorMessage("Incorrect username or password");
                        return $this->generateView(self::$_action_type);
                    } elseif (!$user->type) {
                        $this->addErrorMessage("You are not an administrator");
                        return $this->generateView(self::$_action_type);
                    } else {
                        // this sets variables in the session
                        $session->completeLogin($user);
                        header('Location: '.SOURCE_ROOT_PATH."?url=admin/login");
                        die();
                    }
                }
            } else {
                $this->addPageTitle('Log in');
                return $this->generateView(self::$_action_type);
            }
        }
    }
}
