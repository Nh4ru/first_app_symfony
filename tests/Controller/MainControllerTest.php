<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Component\HttpFoundation\Response;

class MainControllerTest extends WebTestCase
{
    protected $client;

    protected $databaseTool;

    protected function setUp(): void
    {
        $this->client = self::createClient();

        $this->databaseTool = self::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->databaseTool->loadAliceFixture([
            dirname(__DIR__) . '/Fixtures/UserFixtures.yaml',
            dirname(__DIR__) . '/Fixtures/TagFixtures.yaml',
            dirname(__DIR__) . '/Fixtures/ArticleFixtures.yaml',
        ]);
    }

    public function testGetHomePage()
    {
        $this->client->request('GET', '');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        /* OU */
        //$this->assertResponseIsSuccesful();
    }

    public function testHeading1HomePage()
    {
        $this->client->request('GET', '');
        $this->assertSelectorTextContains('h1.title', 'WELCOME ON MY SYMFONY APP');
    }

    public function testNavbarHomePage()
    {
        $this->client->request('GET', '');

        $this->assertSelectorExists('header');

        $this->assertSelectorExists('footer');
    }

    public function testArticlesNumberHomePage()
    {
        $crawler = $this->client->request('GET', '');

        $this->assertCount(6, $crawler->filter('.blog-card'));
    }
}