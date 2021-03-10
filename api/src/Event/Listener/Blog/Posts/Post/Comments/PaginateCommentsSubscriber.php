<?php

namespace App\Event\Listener\Blog\Posts\Post\Comments;

use App\Service\Gravatar;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\NativeQuery;
use Doctrine\ORM\Query;
use JetBrains\PhpStorm\ArrayShape;
use Knp\Component\Pager\Event\ItemsEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PaginateCommentsSubscriber implements EventSubscriberInterface
{
    public const MAIN_TABLE = 'blog_posts_post_comments';
    public const MAIN_TABLE_ALIAS_REGEXP = '/FROM\s+(?P<table>[\w_]+)\s+(AS\s+)?(?P<alias>[\w_]+)/';
    public const LIMIT_REGEXP = '/(LIMIT\s+\S+\s*((,\s*\S+)|(\s+OFFSET\s+\S+))\s*)/';

    #[ArrayShape(['knp_pager.items' => 'array'])]
    public static function getSubscribedEvents(): array
    {
        return [
            'knp_pager.items' => ['items', 1],
        ];
    }

    public function items(ItemsEvent $event): void
    {
        if ($event->target instanceof NativeQuery) {
            $sql = $event->target->getSQL();

            if (!preg_match(self::MAIN_TABLE_ALIAS_REGEXP, $sql, $m)) {
                throw new \InvalidArgumentException('Can\'t determine the main table alias');
            }

            if (self::MAIN_TABLE !== $m['table']) {
                return;
            }

            $event->items = [];

            $parameters = $event->target->getParameters();

            $event->count = (int) (clone $event->target)
                ->setResultSetMapping((new Query\ResultSetMapping())->addScalarResult('c', 'c', Types::INTEGER))
                ->setSQL('SELECT COUNT(*) AS c FROM ('.preg_replace(
                        self::LIMIT_REGEXP,
                        '',
                        str_replace(['::parent::', '::ids::'], ['AND t.parent_id IS NULL', ''], $sql)
                    ).') AS s')
                ->execute($parameters, Query::HYDRATE_SINGLE_SCALAR);

            $parameters->add(new Query\Parameter(':limit', $event->getLimit(), Types::INTEGER));
            $parameters->add(new Query\Parameter(':offset', $event->getOffset(), Types::INTEGER));

            $parents = (clone $event->target)
                ->setSQL(str_replace(['::parent::', '::ids::'], ['AND t.parent_id IS NULL', ''], $sql))
                ->execute($parameters);

            $parentIds = array_map(static fn (array $elem) => $elem['id'], $parents);

            if (!count($parentIds)) {
                $event->stopPropagation();

                return;
            }

            $parameters->add(new Query\Parameter(':limit', null));
            $parameters->add(new Query\Parameter(':offset', 0, Types::INTEGER));

            $withChildren = (clone $event->target)
                ->setSQL(
                    str_replace(
                        ['::parent::', '::ids::'],
                        [
                            '',
                            '',
                        ],
                        $sql
                    )
                )
                ->execute($parameters);

            $event->items = array_slice($this->buildTree($withChildren), $event->getOffset(), $event->getLimit());

            $event->stopPropagation();
        }
    }

    private function buildTree(array $items, ?string $parentId = null): array
    {
        $result = [];

        foreach ($items as $element) {
            if ($element['parent_id'] === $parentId) {
                $children = $this->buildTree($items, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                } else {
                    $element['children'] = [];
                }
                $element['date_atom'] = (new DateTimeImmutable($element['date']))->format(DATE_ATOM);
                $element['date'] = (new \IntlDateFormatter(
                    'ru_Ru',
                    \IntlDateFormatter::NONE,
                    \IntlDateFormatter::NONE,
                    null,
                    null,
                    "d MMMM y 'в' HH:mm"
                ))->format(new DateTimeImmutable($element['date']));
                $element['avatar'] = Gravatar::url($element['author_email'], 40);
                $element['user_role'] = 'ROLE_ADMIN' === $element['user_role'] ? 'Администратор' : null;
                $result[$element['id']] = $element;
                unset($items[$element['id']]);
            }
        }

        return array_values($result);
    }
}
