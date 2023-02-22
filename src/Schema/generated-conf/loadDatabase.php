<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->initDatabaseMaps(array (
  'crawl' => 
  array (
    0 => '\\App\\Schema\\Crawl\\ArticleContentTags\\Map\\ArticleContentTagsTableMap',
    1 => '\\App\\Schema\\Crawl\\ArticleTitleTags\\Map\\ArticleTitleTagsTableMap',
    2 => '\\App\\Schema\\Crawl\\Article\\Map\\ArticleTableMap',
    3 => '\\App\\Schema\\Crawl\\AuctionAggregates\\Map\\AuctionAggregatesTableMap',
    4 => '\\App\\Schema\\Crawl\\AuctionCrawlLog\\Map\\AuctionCrawlLogTableMap',
    5 => '\\App\\Schema\\Crawl\\AuctionDetails\\Map\\AuctionDetailsTableMap',
    6 => '\\App\\Schema\\Crawl\\AuctionItems\\Map\\AuctionItemsTableMap',
    7 => '\\App\\Schema\\Crawl\\Devtracker\\Map\\DevtrackerTableMap',
    8 => '\\App\\Schema\\Crawl\\Settings\\Map\\SettingsTableMap',
    9 => '\\App\\Schema\\Crawl\\Tag\\Map\\TagTableMap',
    10 => '\\App\\Schema\\Crawl\\User\\Map\\UserTableMap',
  ),
));
