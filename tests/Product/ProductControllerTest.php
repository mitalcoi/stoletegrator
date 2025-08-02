<?php

namespace Tests\Product;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Product\DataFixtures\ProductFixtures;
use Product\DataFixtures\UserFixtures;
use Product\Repository\ProductRepository;
use Product\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    private SchemaTool $schemaTool;
    private KernelBrowser $client;

    protected function setUp(): void
    {
        self::ensureKernelShutdown();
        $this->client = static::createClient();
        $container = static::getContainer();

        $this->em = $container->get(EntityManagerInterface::class);
        $this->schemaTool = new SchemaTool($this->em);
        $metadata = $this->em->getMetadataFactory()->getAllMetadata();

        if (!empty($metadata)) {
            $this->schemaTool->dropDatabase();
            $this->schemaTool->createSchema($metadata);
        }

        // Загружаем фикстуры
        $loader = new Loader();
        $loader->addFixture(new ProductFixtures());
        $loader->addFixture(new UserFixtures());

        $executor = new ORMExecutor($this->em, new ORMPurger());
        $executor->execute($loader->getFixtures());
    }

    protected function tearDown(): void
    {
        if (isset($this->schemaTool)) {
            $this->schemaTool->dropDatabase();
        }

        parent::tearDown();
    }

    public function testProductListAsGuest(): void
    {
        $this->client->loginUser($this->client->getContainer()->get(UserRepository::class)->getByIdentifier('test_user'));
        $this->client->request('GET', '/api/products');

        $this->assertResponseIsSuccessful();
        $this->assertResponseFormatSame('json');

        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertIsArray($data);
        $this->assertCount(3, $data);
        $this->assertArrayHasKey('id', $data[0]);
        $this->assertArrayHasKey('name', $data[0]);
        $this->assertArrayHasKey('isFavorite', $data[0]);
        $this->assertFalse($data[0]['isFavorite']);
    }

    public function testProductListWithFilters(): void
    {
        $this->client->loginUser($this->client->getContainer()->get(UserRepository::class)->getByIdentifier('test_user'));
        $this->client->request('GET', '/api/products?category=fruits&sort=name');
        $data = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertResponseIsSuccessful();
        $this->assertResponseFormatSame('json');
        $this->assertCount(2, $data);
    }

    public function testToggleFavoriteAndFavoritesList(): void
    {
        $this->client->loginUser($this->client->getContainer()->get(UserRepository::class)->getByIdentifier('test_user'));

        $product = $this->client->getContainer()->get(ProductRepository::class)->findOneBy([]);
        $this->assertNotNull($product);

        $this->client->request('POST', '/api/products/' . $product->getId() . '/favorite');
        $this->assertResponseIsSuccessful();

        $this->client->request('GET', '/api/products/favorites');
        $this->assertResponseIsSuccessful();

        $data = json_decode( $this->client->getResponse()->getContent(), true);
        $this->assertNotEmpty($data);
        $this->assertEquals($product->getId(), $data[0]['id']);
    }

}
