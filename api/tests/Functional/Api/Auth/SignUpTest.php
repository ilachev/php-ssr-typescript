<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api\Auth;

use App\Model\User\Service\PasswordHasher;
use App\Tests\Functional\AuthFixture;
use App\Tests\Functional\DbWebTestCase;

class SignUpTest extends DbWebTestCase
{
    private const URI = '/api/auth/signup';

    protected function setUp(): void
    {
        parent::setUp();

        $this->addFixture(new AuthFixture(new PasswordHasher()));
        $this->executeFixtures();
    }

    public function testGet(): void
    {
        $this->client->request('GET', self::URI);

        self::assertEquals(405, $this->client->getResponse()->getStatusCode());
    }

    public function testSuccess(): void
    {
        $this->client->request('POST', self::URI, [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'test-john@app.test',
            'password' => 'password',
        ], JSON_THROW_ON_ERROR));

        self::assertEquals(201, $this->client->getResponse()->getStatusCode());
        self::assertJson($content = $this->client->getResponse()->getContent());

        $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

        self::assertEquals([], $data);
    }

    public function testNotValid(): void
    {
        $this->client->request('POST', self::URI, [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'first_name' => '',
            'last_name' => '',
            'email' => 'not-email',
            'password' => 'short',
        ], JSON_THROW_ON_ERROR));

        self::assertEquals(400, $this->client->getResponse()->getStatusCode());
        self::assertJson($content = $this->client->getResponse()->getContent());

        $data = json_decode($content, true);

        self::assertArrayHasKey('violations', $data);
        self::assertNotEmpty($data['violations']);
    }

    public function testExists(): void
    {
        $this->client->request('POST', self::URI, [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'first_name' => 'Tom',
            'last_name' => 'Bent',
            'email' => 'auth-user@app.test',
            'password' => 'password',
        ], JSON_THROW_ON_ERROR));

        self::assertEquals(400, $this->client->getResponse()->getStatusCode());
        self::assertJson($content = $this->client->getResponse()->getContent());

        $data = json_decode($content, true);

        self::assertArrayHasKey('error', $data);
        self::assertNotEmpty($data['error']);
    }
}
