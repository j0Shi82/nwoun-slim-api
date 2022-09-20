<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->initDatabaseMaps(array (
  'crawl' => 
  array (
    0 => '\\App\\Schema\\Crawl\\ArticleContentTags\\Map\\ArticleContentTagsTableMap',
    1 => '\\App\\Schema\\Crawl\\ArticleTitleTags\\Map\\ArticleTitleTagsTableMap',
    2 => '\\App\\Schema\\Crawl\\Article\\Map\\ArticleTableMap',
    3 => '\\App\\Schema\\Crawl\\AuctionAggregates\\Map\\AuctionAggregatesTableMap',
    4 => '\\App\\Schema\\Crawl\\AuctionDetails\\Map\\AuctionDetailsTableMap',
    5 => '\\App\\Schema\\Crawl\\AuctionItems\\Map\\AuctionItemsTableMap',
    6 => '\\App\\Schema\\Crawl\\Devtracker\\Map\\DevtrackerTableMap',
    7 => '\\App\\Schema\\Crawl\\Settings\\Map\\SettingsTableMap',
    8 => '\\App\\Schema\\Crawl\\Tag\\Map\\TagTableMap',
  ),
));
