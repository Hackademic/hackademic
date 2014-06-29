<?php


require_once("../../../config.inc.php");
require_once('../../../model/common/class.Plugin.php');
require_once("../../../model/common/class.HackademicDB.php");
require_once("../../../model/common/class.Utils.php");


class ArticleTest extends PHPUnit_Framework_TestCase {
	
	private $article;
	private $article2;

	private static $action_type = "article_test_action";
    
    public function setUp() {
		Utils::defineConstants();
        global $db;
        $db = new HackademicDB();
        require_once('../../../model/common/class.Article.php');
        require_once('../../../admin/model/class.ArticleBackend.php');
        
        $this->article = new Article();
		$this->article2 = new Article();
		$this->article->title = $this->article2->title = "Foobar Article";
		$this->article->content = $this->article2->content = "Foobar Content";
		$this->article->date_posted = $this->article2->date_posted = "2013-08-18 00:00:17";
		$this->article->created_by = $this->article->created_by = "test_cases";
		$this->article->is_published = $this->article2->is_published = 1;
        
        ArticleBackend::addArticle($this->article->title, $this->article->content, $this->article->date_posted, $this->article->created_by, $this->article->is_published);
        ArticleBackend::addArticle($this->article->title."2", $this->article->content."2", $this->article->date_posted, $this->article->created_by, $this->article->is_published);
		$sql = "SELECT * FROM articles WHERE title LIKE :search_string LIMIT :start, :limit";
		/*Todo: get the ids of the articles just inserted */
    }
    public function tearDown(){ 
		$this->assertTrue(null !== $this->article->id);
		$this->assertTrue(null !== $this->article2->id);
		ArticleBackend::deleteArticle($this->article->id);
		ArticleBackend::deleteArticle($this->article2->id);
	}

    /**
     *  
     */
    public function test_doesChallengeExist() {
      	$challenge = new Challenge();
      	assert( false === Challenge::doesChallengeExist('NonExistentChallengeNameToRunUnitTest'));
      	assert( true === Challenge::doesChallengeExist(Challenge::getChallenge(0)->name));
    }
	/*
	 * Tests if getPublicChallenges returns only the completely public challenges
	 * Only challenge->title == a1 should be selected
	 */
    public function test_getPublicChallenges(){
    	$chal1 = new Challenge();
    	foreach($chal1 as $key=>$value)
    		$value =  'a1';
    	$chal1->visibility = 'public';
    	$chal1->availability = 'public';
    	$chal1->publish = 1;
    	$chal1->duration = 1;
    	$chal1->id = NULL;

    	$chal2 = clone $chal1;
    	$chal2->visibility = 'private';
    	$chal2->pkg_name = 'a2';
 	
    	$chal3 = clone $chal2;
    	$chal3->availability = 'private';
    	$chal3->pkg_name = 'a3';
    	
    	$chal4 = clone $chal1;
    	$chal4->availability = 'private';
    	$chal4->pkg_name = 'a4';
    	
    	$chal5 = clone $chal1;
    	$chal5->publish = 0;
    	$chal5->pkg_name = 'a5';
    	
    	ChallengeBackend::addChallenge($chal1);
    	ChallengeBackend::addChallenge($chal2);
    	ChallengeBackend::addChallenge($chal3);
    	ChallengeBackend::addChallenge($chal4);
    	ChallengeBackend::addChallenge($chal5);
    	$challenges = Challenge::getPublicChallenges();
    	assert(FALSE != $challenges);
    	
    	$found = array(false,false,false,false,false);
		foreach($challenges as $obj){
			if( 'a1' == $obj->pkg_name)
				$found[0] = true;
			if( 'a2' == $obj->pkg_name)
				$found[1] = true;
			if( 'a3' == $obj->pkg_name)
				$found[2] = true;
			if( 'a4' == $obj->pkg_name)
				$found[3] = true;
			if( 'a5' == $obj->pkg_name)
				$found[4] = true;
		}
		assert(true === $found[0]);
		assert(false === $found[1]);
		assert(false === $found[2]);
		assert(false === $found[3]);
		assert(false === $found[4]);
		$ids = array();
		$ids[0] = ChallengeBackend::getChallengeByPkgName($chal1->pkg_name)->id;
		$ids[1] = ChallengeBackend::getChallengeByPkgName($chal2->pkg_name)->id;
		$ids[2] = ChallengeBackend::getChallengeByPkgName($chal3->pkg_name)->id;
		$ids[3] = ChallengeBackend::getChallengeByPkgName($chal4->pkg_name)->id;
		$ids[4] = ChallengeBackend::getChallengeByPkgName($chal5->pkg_name)->id;
    	foreach($ids as $id)
			ChallengeBackend::deleteChallenge($id);
    }
	public function test_getChallengeByPkgName(){
		$challenge = new Challenge();
		foreach($challenge as $key=>$value){
			$value = 'fooTestPackageUnitTests123';
		}
		$challenge->id = NULL;
		$challenge->publish = 1;
		$challenge->duration = 1;
		
		$challenge = Challenge::getChallengeByPkgName('fooTestPackageUnitTests123');
		assert('fooTestPackageUnitTests123' === $challenge->title);
		ChallengeBackend::deleteChallenge($challenge->id);
	}
	
	public function test_getChallengesFrontend(){
		$chal1 = new Challenge();
		foreach($chal1 as $key=>$value)
			$value =  'a1';
		$chal1->visibility = 'public';
		$chal1->availability = 'public';
		$chal1->publish = 1;
		$chal1->duration = 1;
		$chal1->id = NULL;
	
		$chal2 = clone $chal1;
		$chal3 = clone $chal1;
		$chal4 = clone $chal1;
		ChallengeBackend::addChallenge($chal1);
		ChallengeBackend::addChallenge($chal2);
		ChallengeBackend::addChallenge($chal3);
		ChallengeBackend::addChallenge($chal4);
		
		User::addUser('testing_user1','testing_user1','testing_user1',
		'testing_user1','2010-01-01 00:00:00',1,0,'testing_user1');
		
		Classes::addClass('test_class', '2010-01-01 00:00:00');		
		$class_id = Classes::getClassByName('test_class');

		$membership = new ClassMemberships();
		$membership->date_created = '2010-01-01 00:00:00';
		$membership->class_id = $class_id;
		$membership->user_id = $user_id;
		
		ClassChallenges::addMembership($challenge1_id, $class_id);
		ClassChallenges::addMembership($challenge2_id, $class_id);
		ClassChallenges::addMembership($challenge3_id, $class_id);
		ClassChallenges::addMembership($challenge4_id, $class_id);
	}	
}