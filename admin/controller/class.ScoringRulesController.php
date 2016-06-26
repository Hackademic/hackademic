<?php

require_once HACKADEMIC_PATH."admin/model/class.ClassMemberships.php";
require_once HACKADEMIC_PATH."admin/model/class.ClassChallenges.php";
require_once HACKADEMIC_PATH."admin/model/class.Classes.php";
require_once HACKADEMIC_PATH."admin/controller/class.HackademicBackendController.php";
require_once HACKADEMIC_PATH."admin/model/class.ScoringRuleBackend.php";
require_once HACKADEMIC_PATH."model/common/class.Challenge.php";
require_once HACKADEMIC_PATH."model/common/class.Utils.php";
require_once HACKADEMIC_PATH."model/common/class.ScoringRule.php";

class ScoringRulesController extends HackademicBackendController
{

    public function go()
    {
        $this->setViewTemplate('scoringrules.tpl');

        if (!isset($_GET['class_id'])) {
            header('Location: '.SOURCE_ROOT_PATH."admin/pages/manageclass.php");
            die();
        }
        $_POST['class_id'] = $class_id = $_GET['class_id'];
        $_POST['challenge_id'] = $challenge_id = $_GET['cid'];

        $class = Classes::getClass($class_id);

        if (isset($_POST['updaterule'])) {
            if ($_POST['updaterule']=='') {
                header('Location: '.SOURCE_ROOT_PATH."admin/pages/scoringrules.php?id=$class_id&action=editerror");
                die();
            } elseif ($_POST['updaterule'] == 'Edit Rule') {
                $newRule = $this->_requestToRuleObject($_POST);
                if (ScoringRule::isDefaultRule($newRule) == false ) {

                    $rule = ScoringRule::getScoringRuleByChallengeClassId($challenge_id, $class_id);

                    if ($rule == NO_RESULTS ) {
                        ScoringRuleBackend::addScoringRule(
                            $_POST['challenge_id'],
                            $_POST['class_id'],
                            $_POST['attempt_cap'],
                            $_POST['attempt_cap_penalty'],
                            $_POST['time_between_first_and_last_attempt'],
                            $_POST['time_penalty'],
                            $_POST['time_reset_limit_seconds'],
                            $_POST['request_frequency_per_minute'],
                            $_POST['request_frequency_penalty'],
                            $_POST['experimentation_bonus'],
                            $_POST['multiple_solution_bonus'],
                            $_POST['banned_user_agents'],
                            $_POST['base_score'],
                            $_POST['banned_user_agents_penalty'],
                            $_POST['first_try_solves'],
                            $_POST['penalty_for_many_first_try_solves']
                        );
                    } else {
                        ScoringRuleBackend:updateScoringRule(
                            $rule->id,
                            $_POST['challenge_id'],
                            $_POST['class_id'],
                            $_POST['attempt_cap'],
                            $_POST['attempt_cap_penalty'],
                            $_POST['time_between_first_and_last_attempt'],
                            $_POST['time_penalty'],
                            $_POST['time_reset_limit_seconds'],
                            $_POST['request_frequency_per_minute'],
                            $_POST['request_frequency_penalty'],
                            $_POST['experimentation_bonus'],
                                $_POST['multiple_solution_bonus'],
                            $_POST['banned_user_agents'],
                            $_POST['base_score'],
                            $_POST['banned_user_agents_penalty'],
                            $_POST['first_try_solves'],
                            $_POST['penalty_for_many_first_try_solves']
                        );

                    }$this->addSuccessMessage(
                        "Scoring rule has been updated succesfully"
                    );
                } else {
                      $this->addSuccessMessage(
                          "Scoring rule has been updated succesfully"
                      );
                }
            }
        }

        if (isset($_GET['action']) && $_GET['action'] == "editerror") {
            $this->addErrorMessage("Fields should not be empty");
        }
        if (isset($_POST['deleterule']) && $_POST['deleterule'] == "Delete Rule") {
            $rule = ScoringRule::getScoringRuleByChallengeClassId($challenge_id, $class_id);
            if ($rule != false && ScoringRule::isDefaultRule($rule) == false ) {
                ScoringRuleBackend::deleteScoringRule($rule->id);
                $this->addErrorMessage("Scoring rule has been deleted succesfully");
            }
        }


        $rule = ScoringRule::getScoringRuleByChallengeClassId($challenge_id, $class_id);
        if ($rule == NO_RESULTS) {
            $this->addSuccessMessage(
                "This challenge does not have any specific scoring rules</br> the
				default ones where loaded"
            );
            $rule = ScoringRule::getScoringRule(DEFAULT_RULES_ID);
        }
        $class_name = Classes::getClass($class_id);
        $class_name = $class_name->name;

        $challenge_name = Challenge::getChallenge($challenge_id);
        $challenge_name = $challenge_name->title;

        $rule_names = array();
        $rule_name['attempt_cap'] = 'Maximum Attempts';
        $rule_name['attempt_cap_penalty'] = 'Penalty If Maximum Attempts Reached';
        $rule_name['time_between_first_and_last_attempt'] = 'Challenge Duration (seconds)';
        $rule_name['time_penalty'] = 'Penalty For Late Challenges';
        $rule_name['time_reset_limit_seconds'] = 'When to Reset the late timer (seconds)';
        $rule_name['request_frequency_per_minute'] = 'Maximum Attempts per minute';
        $rule_name['request_frequency_penalty'] = ' Penalty for too many attempts per second';
        $rule_name['experimentation_bonus'] = ' Bonus points for more attempts after the succesful one';
        $rule_name['multiple_solution_bonus'] = 'Bonus points for more SUCCESFUL attempts after the succesful one';
        $rule_name['banned_user_agents'] = 'A list of user agent keywords which are banned (keywords seperated by commas )';
        $rule_name['banned_user_agents_penalty'] = 'Penalty for use of banned user agents';
        $rule_name['first_try_solves'] = 'Cheating prevention, how many challenges the user must solve on the first try to be considered cheating?';
        $rule_name['penalty_for_many_first_try_solves'] = 'Point penalty for many rapid fire solutions';
        $rule_name['base_score'] = 'Whats the score for a succesful attempt if no penalties or bonuses apply?';

        /*Skip $id, $class_id $challenge_id*/
        unset($rule->id);
        unset($rule->class_id);
        unset($rule->challenge_id);
        $this->addToView('rule_names', $rule_name);
        $this->addToView('rules', $rule);
        $this->addToView('class_name', $class_name);
        $this->addToView('challenge_name', $challenge_name);
        return $this->generateView();
    }
    private function _requestToRuleObject($request)
    {
        $rule = new ScoringRule();
        $rule->class_id = $request['class_id'];
        $rule->attempt_cap = $request['attempt_cap'];
        $rule->attempt_cap_penalty = $request['attempt_cap_penalty'];
        $rule->time_between_first_and_last_attempt = $request['time_between_first_and_last_attempt'];
        $rule->time_penalty = $request['time_penalty'];
        $rule->time_reset_limit_seconds = $request['time_reset_limit_seconds'];
        $rule->request_frequency_per_minute = $request['request_frequency_per_minute'];
        $rule->request_frequency_penalty = $request['request_frequency_penalty'];
        $rule->experimentation_bonus = $request['experimentation_bonus'];
        $rule->multiple_solution_bonus = $request['multiple_solution_bonus'];
        $rule->banned_user_agents = $request['banned_user_agents'];
        $rule->base_score = $request['base_score'];
        $rule->banned_user_agents_penalty = $request['banned_user_agents_penalty'];
        $rule->first_try_solves = $request['first_try_solves'];
        $rule->penalty_for_many_first_try_solves = $request['penalty_for_many_first_try_solves'];
        return $rule;
    }
}
