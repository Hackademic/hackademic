<?php

require_once HACKADEMIC_PATH."model/common/class.Session.php";
require_once HACKADEMIC_PATH."controller/class.LandingPageController.php";
require_once HACKADEMIC_PATH."controller/class.HackademicController.php";
require_once HACKADEMIC_PATH."model/common/class.User.php";

class LoginController extends HackademicController
{

    private static $_action_type = 'login';

    public function go()
    {

        $this->setViewTemplate('landingpage.tpl');
        $this->addPageTitle('Log in');


        if (self::isLoggedIn() && Session::isValid($_GET['token'])) {
            $controller = new LandingPageController();
            return $controller->go();
        } else {
            if (defined('EXHIBITION_MODE') && EXHIBITION_MODE == true) {
                $session = new Session();
                $username = 'Guest';
                // start the session
                $session->loginGuest();
                header('Location:'.SOURCE_ROOT_PATH."?url=home");
                die();
            }
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
                        header('Location:'.SOURCE_ROOT_PATH."?url=mainlogin&msg=username");
                        die();//return $this->generateView(self::$action_type);
                    } elseif (!$session->pwdCheck($_POST['pwd'], $user->password)) {
                        header('Location:'.SOURCE_ROOT_PATH."?url=mainlogin&msg=password");
                        die();
                    } elseif ($user->is_activated != 1) {
                        header('Location:'.SOURCE_ROOT_PATH."?url=mainlogin&msg=activate");
                        die();
                    } else {
                        // start the session
                        $session->completeLogin($user);
                        if ($user->type) {
                            //error_log("HACKADEMIC:: admin dashboard SUCCESS", 0);
                            //var_dump($_SESSION);//die();
                            header('Location:'.SOURCE_ROOT_PATH."?url=admin/dashboard");
                            die();
                        } else {
                            //error_log("HACKADEMIC:: USER HOME SUCCESS", 0);
                            header('Location:'.SOURCE_ROOT_PATH."?url=home");
                            die();
                        }
                    }
                }
            } else {
                $this->addPageTitle('Log in');
                return $this->generateView(self::$_action_type);
            }
        }
    }
}
