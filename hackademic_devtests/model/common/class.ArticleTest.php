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
     * Tries to fetch the two articles we inserted
     *  and makes sure it's an array of Article items.
     */
    public function test_getNarticles() {
      $articles = Article::getNarticles(0,2,"Foobar","title");
      assert(is_array($articles));
      assert(sizeof($articles) > 0);
      $this->assertInstanceOf('Article', $articles[0]);
      assert(strpos($articles[0]->title,"Foobar") !== false);
    }

	/*
	 * Tries to fetch a range,all and a Single article
	 * and tests that in case we get one article it returns an
	 * article object
	 * */
    public function test_getAllArticles(){
		global $db;
		/* get two articles */
		$articles = Article::getAllArticles(0,2);
		assert(is_array($articles));
      	assert(sizeof($articles) === 2);
		$this->assertInstanceOf('Article', $articles[0]);

		/* get all articles */
		$rs = $db->read("SELECT COUNT(*) as num FROM articles",NULL,self::$action_type); /*TODO: check that $count is a number and not e.g. a result_set*/
		$foo = $db->fetchArray($rs);
		$count = $foo['num'];
		$articles = Article::getAllArticles();
		assert(is_array($articles));
      	assert(sizeof($articles) === $count);
		$this->assertInstanceOf('Article', $articles[0]);
		
		/* get one article, it should return a single article element */
		$articles = Article::getAllArticles(0,1);
		$this->assertInstanceOf('Article', $articles);
	}
	
	/* Gets number of articles based on different */
	public function test_getNumberOfArticles(){
		global $db;
		$rs = $db->read("SELECT COUNT(*) as num FROM articles",NULL,self::$action_type); /*TODO: check that $count is a number and not e.g. a result_set*/
		$count = $db->fetchArray($rs)['num'];
		$articles = Article::getNumberOfArticles();
		assert($count === $articles);
		
		$rs = $db->read("SELECT COUNT(*) as num FROM articles WHERE title LIKE 'Foobar'",NULL,self::$action_type); /*TODO: check that $count is a number and not e.g. a result_set*/
		$count = $db->fetchArray($rs)['num'];
		$articles = Article::getNumberOfArticles("Foobar","title");
		assert($count === $articles);

		$rs = $db->read("SELECT COUNT(*) as num FROM articles WHERE created_by LIKE 'test_case'",NULL,self::$action_type); /*TODO: check that $count is a number and not e.g. a result_set*/
		$count = $rs->fetchArray()['num'];
		$articles = Articles::getNumberOfArticles("test_case","created_by");
		assert($count === $articles);
	}
	
	public function test_getArticle(){
		global $db;
		$rs = $db->read("SELECT * FROM articles WHERE title LIKE 'Foobar' LIMIT 0,1");
		$id = $rs->fetchArray()['id'];
		$articles = Article::getArticle($id);
		assert($articles->id === $id);
		assert(strpos($articles->title,'Foobar') !== false);
		$this->assertInstanceOf('Article', $articles);
	}
/*
 * TODO: NOTE: we can use the phpunit's data provider directive to get data instead of doing sql queries
 */
}
