<?php

namespace App\DataFixtures\Market\Stores;

use App\DataFixtures\Market\Author\AuthorFixture;
use App\Model\Market\Entity\Author\Author;
use App\Model\Market\Entity\Stores\Store\Comment\Comment;
use App\Model\Market\Entity\Stores\Store\Comment\Id;
use App\Model\Market\Entity\Stores\Store\Comment\Status;
use App\Model\Market\Entity\Stores\Store\Store;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentFixture extends Fixture implements DependentFixtureInterface
{
    private const PARENT_COMMENTS = [
        [
            'text' => 'Так разобрать реакт по косточкам - просто бомба!!! Parent draft',
            'status' => Status::DRAFT,
        ],
        [
            'text' => 'Так разобрать реакт по косточкам - просто бомба!!! Parent declined',
            'status' => Status::DECLINED,
        ],
        [
            'text' => 'Так разобрать реакт по косточкам - просто бомба!!! Parent 1 approved',
            'status' => Status::APPROVED,
        ],
        [
            'text' => 'Так разобрать реакт по косточкам - просто бомба!!! Parent 2 approved',
            'status' => Status::APPROVED,
        ],
    ];

    private const CHILDREN_COMMENTS = [
        [
            'text' => 'Так разобрать реакт по косточкам - просто бомба!!! Children draft',
            'status' => Status::DRAFT,
        ],
        [
            'text' => 'Так разобрать реакт по косточкам - просто бомба!!! Children declined',
            'status' => Status::DECLINED,
        ],
        [
            'text' => 'Так разобрать реакт по косточкам - просто бомба!!! Children 1 approved',
            'status' => Status::APPROVED,
        ],
        [
            'text' => 'Так разобрать реакт по косточкам - просто бомба!!! Children 2 approved',
            'status' => Status::APPROVED,
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        /** @var Author $author */
        $author = $this->getReference(AuthorFixture::REFERENCE_ADMIN);
        /** @var Store $store */
        $store = $this->getReference(StoreFixture::REFERENCE_ADIDAS);

        foreach (self::PARENT_COMMENTS as $parentCommentData) {
            $parentComment = $this->createComment(
                $author,
                $store,
                $parentCommentData['text'],
                new Status($parentCommentData['status']),
                new DateTimeImmutable()
            );
            $manager->persist($parentComment);
        }

        $manager->flush();

        foreach (self::CHILDREN_COMMENTS as $childrenCommentData) {
            $childrenComment = $this->createComment(
                $author,
                $store,
                $childrenCommentData['text'],
                new Status($childrenCommentData['status']),
                new DateTimeImmutable(),
                $parentComment
            );
            $manager->persist($childrenComment);
        }

        $manager->flush();
    }

    private function createComment(
        Author $author,
        Store $store,
        string $text,
        Status $status,
        DateTimeImmutable $date,
        ?Comment $parent = null,
    ): Comment {
        $comment = new Comment(
            Id::next(),
            $store,
            $author,
            $date,
            $text,
            $parent
        );
        if ($status->isApproved()) {
            $comment->approve();
        } elseif ($status->isDeclined()) {
            $comment->decline();
        }

        return $comment;
    }

    public function getDependencies(): array
    {
        return [
            AuthorFixture::class,
            StoreFixture::class,
        ];
    }
}
