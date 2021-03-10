<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\FrontendUrlBuilder;
use App\Service\Sitemap\SitemapBuilder;
use JetBrains\PhpStorm\Pure;
use SimpleXMLElement;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SitemapCommand extends Command
{
    public function __construct(
        private SitemapBuilder $builder,
        private FrontendUrlBuilder $urlBuilder,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('sitemap')
            ->setDescription('Generates sitemap');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $data = $this->builder->getSitemapData();

        $sitemapIndex = new SimpleXmlElement(
            '<?xml version="1.0" encoding="utf-8"?>
            <sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></sitemapindex>'
        );

        foreach ($data as $block) {
            $sitemap = $sitemapIndex->addChild('sitemap');
            $sitemap->addChild('loc', $this->urlBuilder->generate(sprintf(
                'sitemap/%s',
                $block['name'],
            )));

            $fp = fopen(sprintf('var/sitemap/%s', $block['name']), 'wb');
            $urlSet = $this->createUrlSet();
            foreach ($block['data'] as $page) {
                $url = $urlSet->addChild('url');
                foreach ($page as $strType => $str) {
                    $url->addChild($strType, (string) $str);
                }
            }
            fwrite($fp, $urlSet->asXML());
            fclose($fp);
        }

        $fp = fopen('var/sitemap/sitemap.xml', 'wb');
        fwrite($fp, $sitemapIndex->asXML());
        fclose($fp);

        $output->writeln('<info>Done!</info>');

        return 1;
    }

    #[Pure]
    private function createUrlSet(): SimpleXMLElement
    {
        return new SimpleXMLElement(
            '<?xml version="1.0" encoding="utf-8"?>
            <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>
            '
        );
    }
}
