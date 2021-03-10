<?php

declare(strict_types=1);

namespace App\DataFixtures\Market\Author;

use App\DataFixtures\UserFixture;
use App\Model\Market\Entity\Author\Author;
use App\Model\Market\Entity\Author\Email;
use App\Model\Market\Entity\Author\Id;
use App\Model\Market\Entity\Author\Name;
use App\Model\User\Entity\User\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AuthorFixture extends Fixture implements DependentFixtureInterface
{
    public const REFERENCE_ADMIN = 'market_author_admin';
    public const REFERENCE_USER = 'market_author_user';

    public function load(ObjectManager $manager): void
    {
        /** @var User $admin */
        $admin = $this->getReference(UserFixture::REFERENCE_ADMIN);

        $author = $this->createAuthor($admin);
        $manager->persist($author);
        $this->setReference(self::REFERENCE_ADMIN, $author);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixture::class,
        ];
    }

    private function createAuthor(User $user): Author
    {
        return new Author(
            new Id($user->getId()->getValue()),
            new Name(
                $user->getName()->getFirst(),
                $user->getName()->getLast()
            ),
            new Email($user->getEmail() ? $user->getEmail()->getValue() : null)
        );
    }
}
