<?php

namespace App\Tests\Controller;

use Exception;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;

class SecurityControllerTest extends WebTestCase
{
    protected $client;

    protected $databaseTool;

    protected $repoUser;

    protected function setUp(): void
    {
        $this->client = self::createClient();

        $this->repoUser = self::getContainer()->get(UserRepository::class);

        $this->databaseTool = self::getContainer()->get(DatabaseToolCollection::class)->get();

        $this->databaseTool->loadAliceFixture([
            dirname(__DIR__) . '/Fixtures/UserFixtures.yaml'
        ]);
    }

    public function testGetLoginPage()
    {
        $this->client->request('GET', '/login');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        /* OU */
        //$this->assertResponseIsSuccesful();
    }

    public function testHeading1LoginPage()
    {
        $this->client->request('GET', '/login');

        $this->assertSelectorTextContains('h1', 'Se connecter');
    }

    public function testAdminArticleNotLoggedIn()
    {
        $this->client->request('GET', '/admin');

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }

    public function  testAdminUserNotLoggedIn()
    {
        $this->client->request('GET', '/admin/user');

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }

    public function testAdminArticleBadUserLoggedIn()
    {
        $user = $this->repoUser->find(3);

        $this->client->loginUser($user);

        $this->client->request('GET', '/admin');

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testAdminUserBadUserLoggedIn()
    {
        $user = $this->repoUser->find(3);

        $this->client->loginUser($user);

        $this->client->request('GET', '/admin/user');

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testAdminArticleGoodUserLoggedIn()
    {
        $user = $this->repoUser->findOneByEmail('admin@example.com');

        $this->client->loginUser($user);

        $this->client->request('GET', '/admin');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testAdminUserGoodUserLoggedIn()
    {
        $user = $this->repoUser->findOneByEmail('admin@example.com');

        $this->client->loginUser($user);

        $this->client->request('GET', '/admin/user');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testGetRegisterPage()
    {
        $this->client->request('GET', '/register');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testHeading1RegisterPage()
    {
        $this->client->request('GET', '/register');

        $this->assertSelectorTextContains('h1', 'inscrire');
    }

    public function testRegisterNewUser()
    {
        $crawler = $this->client->request('GET', '/register');

        $form = $crawler->selectButton('S\'inscrire')->form([
            'register_form[prenom]' => 'John',
            'register_form[nom]' => 'Doe',
            'register_form[username]' => 'John Doe',
            'register_form[age]' => 50,
            'register_form[mail]' => 'john@doe.com',
            'register_form[password][first]' => 'Test1234',
            'register_form[password][second]' => 'Test1234',
            'register_form[address]' => 'Paris',
            'register_form[zipCode]' => '75001'
        ]);

        $this->client->submit($form);

        $newUser = $this->repoUser->findOneByEmail('john@doe.com');

        if (!$newUser) {
            throw new Exception('User not created.');
        }

        $this->assertResponseRedirects();
    }

    public function testRegisterNewUserWithInvalidEmail()
    {
        $crawler = $this->client->request('GET', '/register');

        $form = $crawler->selectButton('S\'inscrire')->form([
            'register_form[prenom]' => 'John',
            'register_form[nom]' => 'Doe',
            'register_form[username]' => 'John Doe',
            'register_form[age]' => 50,
            'register_form[mail]' => 'john@d',
            'register_form[password][first]' => 'Test1234',
            'register_form[password][second]' => 'Test1234',
            'register_form[address]' => 'XX rue du haha',
            'register_form[ville]' => 'Paris',
            'register_form[zipCode]' => '75001'
        ]);

        $this->client->submit($form);

        $this->assertSelectorTextContains('div.invalid-feedback', 'Veuillez rentrer un email valide.');
    }

    public function testRegisterNewUserWithInvalidZipCode()
    {
        $crawler = $this->client->request('GET', '/register');

        $form = $crawler->selectButton('S\'inscrire')->form([
            'register_form[prenom]' => 'John',
            'register_form[nom]' => 'Doe',
            'register_form[username]' => 'John Doe',
            'register_form[age]' => 50,
            'register_form[mail]' => 'john@doe.com',
            'register_form[password][first]' => 'Test1234',
            'register_form[password][second]' => 'Test1234',
            'register_form[address]' => 'XX rue du haha',
            'register_form[ville]' => 'Paris',
            'register_form[zipCode]' => 'fizfogg'
        ]);

        $this->client->submit($form);

        $this->assertSelectorTextContains('div.invalid-feedback', 'Veuillez rentrer un code postal valide.');
    }

    public function testRegisterNewUserWithInvalidPassword()
    {
        $crawler = $this->client->request('GET', '/register');

        $form = $crawler->selectButton('S\'inscrire')->form([
            'register_form[prenom]' => 'John',
            'register_form[nom]' => 'Doe',
            'register_form[username]' => 'John Doe',
            'register_form[age]' => 50,
            'register_form[mail]' => 'john@doe.com',
            'register_form[password][first]' => 'fbefipzbrqofbf',
            'register_form[password][second]' => 'fbefipzbrqofbf',
            'register_form[address]' => 'XX rue du haha',
            'register_form[ville]' => 'Paris',
            'register_form[zipCode]' => '75001'
        ]);

        $this->client->submit($form);

        $this->assertSelectorTextContains('div.invalid-feedback', 'Votre mot de passe doit comporter au moins 6 caractères, une lettre majuscule, une lettre minuscule et 1 chiffre sans espace blanc');
    }

    public function testRegisterNewUserWithInvalidRepeatedPassword()
    {
        $crawler = $this->client->request('GET', '/register');

        $form = $crawler->selectButton('S\'inscrire')->form([
            'register_form[prenom]' => 'John',
            'register_form[nom]' => 'Doe',
            'register_form[username]' => 'John Doe',
            'register_form[age]' => 50,
            'register_form[mail]' => 'john@doe.com',
            'register_form[password][first]' => 'Test1234',
            'register_form[password][second]' => 'fbefipzbrqofbf',
            'register_form[address]' => 'XX rue du haha',
            'register_form[ville]' => 'Paris',
            'register_form[zipCode]' => '75001'
        ]);

        $this->client->submit($form);

        $this->assertSelectorTextContains('div.invalid-feedback', 'Les valeurs ne correspondent pas.');
    }
}