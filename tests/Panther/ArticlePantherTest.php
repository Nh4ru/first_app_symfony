<?php

namespace App\Tests\Panther;

use Facebook\WebDriver\WebDriverBy;
use Symfony\Component\Panther\PantherTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;

// Test end to end
class ArticlePantherTest extends PantherTestCase
{
    protected $client;

    protected $databaseTool;

    protected function setUp(): void
    {
        $this->client = self::createPantherClient();

        $this->databaseTool = self::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->databaseTool->loadAliceFixture([
            dirname(__DIR__) . '/Fixtures/UserFixtures.yaml',
            dirname(__DIR__) . '/Fixtures/TagFixtures.yaml',
            dirname(__DIR__) . '/Fixtures/ArticleFixtures.yaml',
        ]);
    }

    public function testArticleNumberPage()
    {
        $crawler = $this->client->request('GET', '/article/liste');
        $this->assertCount(6, $crawler->filter('.blog-list .blog-card'));
    }

    public function testArticleBtnShowMore()
    {
        $crawler = $this->client->request('GET', '/article/liste');

        $this->client->waitFor('.btn-show-more');

        $this->client->executeScript("document.querySelector('.btn-show-more').click()");

        $this->client->waitForEnabled('.btn-show-more', 5);

        $crawler = $this->client->refreshCrawler();

        $this->assertCount(12, $crawler->filter('.blog-list .blog-card'));
    }

    public function testLastPageBtnShowMore()
    {
        $crawler = $this->client->request('GET', '/article/liste');

        $this->client->waitFor('.btn-show-more');

        foreach (range(1, 3) as $i) {
            $this->client->executeScript("document.querySelector('.btn-show-more').click()");

            $this->client->waitForEnabled('.btn-show-more', 3);
        }

        $this->assertSelectorIsNotVisible('.btn-show-more');
    }

    public function testFormSearchTextFilter()
    {
        $crawler = $this->client->request('GET', '/article/liste');

        $this->client->waitFor('.form-filter', 5);

        $search = $this->client->findElement(WebDriverBy::cssSelector('.form-filter input[type="text"]'));
        $search->sendKeys('Article de test');

        $this->client->waitFor('.content-response', 5);

        // Wait for the animation Flipper
        sleep(1);

        $crawler = $this->client->refreshCrawler();

        $this->assertCount(1, $crawler->filter('.blog-list .blog-card'));
    }

    public function testCheckboxCategorie()
    {
        $crawler = $this->client->request('GET', '/article/liste');
    }
}