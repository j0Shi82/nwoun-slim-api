<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->initDatabaseMapFromDumps(array (
  'crawl' => 
  array (
    'tablesByName' => 
    array (
      'article' => '\\App\\Schema\\Crawl\\Article\\Map\\ArticleTableMap',
      'article_tags' => '\\App\\Schema\\Crawl\\ArticleContentTags\\Map\\ArticleContentTagsTableMap',
      'article_title_tags' => '\\App\\Schema\\Crawl\\ArticleTitleTags\\Map\\ArticleTitleTagsTableMap',
      'auction_aggregates' => '\\App\\Schema\\Crawl\\AuctionAggregates\\Map\\AuctionAggregatesTableMap',
      'auction_crawl_log' => '\\App\\Schema\\Crawl\\AuctionCrawlLog\\Map\\AuctionCrawlLogTableMap',
      'auction_details' => '\\App\\Schema\\Crawl\\AuctionDetails\\Map\\AuctionDetailsTableMap',
      'auction_items' => '\\App\\Schema\\Crawl\\AuctionItems\\Map\\AuctionItemsTableMap',
      'devtracker' => '\\App\\Schema\\Crawl\\Devtracker\\Map\\DevtrackerTableMap',
      'settings' => '\\App\\Schema\\Crawl\\Settings\\Map\\SettingsTableMap',
      'tag' => '\\App\\Schema\\Crawl\\Tag\\Map\\TagTableMap',
      'user' => '\\App\\Schema\\Crawl\\User\\Map\\UserTableMap',
    ),
    'tablesByPhpName' => 
    array (
      '\\Article' => '\\App\\Schema\\Crawl\\Article\\Map\\ArticleTableMap',
      '\\ArticleContentTags' => '\\App\\Schema\\Crawl\\ArticleContentTags\\Map\\ArticleContentTagsTableMap',
      '\\ArticleTitleTags' => '\\App\\Schema\\Crawl\\ArticleTitleTags\\Map\\ArticleTitleTagsTableMap',
      '\\AuctionAggregates' => '\\App\\Schema\\Crawl\\AuctionAggregates\\Map\\AuctionAggregatesTableMap',
      '\\AuctionCrawlLog' => '\\App\\Schema\\Crawl\\AuctionCrawlLog\\Map\\AuctionCrawlLogTableMap',
      '\\AuctionDetails' => '\\App\\Schema\\Crawl\\AuctionDetails\\Map\\AuctionDetailsTableMap',
      '\\AuctionItems' => '\\App\\Schema\\Crawl\\AuctionItems\\Map\\AuctionItemsTableMap',
      '\\Devtracker' => '\\App\\Schema\\Crawl\\Devtracker\\Map\\DevtrackerTableMap',
      '\\Settings' => '\\App\\Schema\\Crawl\\Settings\\Map\\SettingsTableMap',
      '\\Tag' => '\\App\\Schema\\Crawl\\Tag\\Map\\TagTableMap',
      '\\User' => '\\App\\Schema\\Crawl\\User\\Map\\UserTableMap',
    ),
  ),
));
