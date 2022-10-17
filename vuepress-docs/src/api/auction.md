# Auctions

## GET /v1/auctions/engine

Gets stats from the crawl engine

### Response <`application/json`>

```json
{
    "isActive": 1|0,      // active crawls within the last 15 minutes
    "itemsPerDay": Float, // total items crawled within the last 24 hours
    "totalItems": Number  // total items in the database
}
```

### Live Test

<api-tester endpoint="/v1/auctions/engine" method="GET" />

## GET /v1/auctions/patreon

Gets all crawl engine petreon supporters

### Response <`application/json`>

```json
[
    {
        "title": "{TIER_TITLE}"             // title of the petron support tier
        "members": [
            {
                "name": "{MEMBER_NAME}"     // member name of the support tier
            },
            // ...
        ]
    },
    // ...
]
```

### Live Test

<api-tester endpoint="/v1/auctions/patreon" method="GET" />

## GET /v1/auctions/items

Gets the latest crawled info for items within a certain date range

### Parameters

| Name | Value | Optional
| ----------- | ----------- | ----------- |
| start | YYYY-MM-DD | true |
| end | YYYY-MM-DD | true |

### Response <`application/json`>

```json
[
    {
        "ItemDef": String,
        "ItemName": String,
        "SearchTerm": String,
        "Quality": "Common|Uncommon|Rare|Purple|Legendary|Mythic",
        "Categories": [String],
        "CrawlCategory": String,
        "AllowAuto": true|false,
        "Server": "GLOBAL",
        "UpdateDate": "YYYY-MM-DD hh:mm:ss.ms",
        "LockedDate": "YYYY-MM-DD hh:mm:ss.ms",
        "Count": int,
        "Low": int,
        "Mean": int,
        "Inserted": timestamp
    },
    //...
]
```

### Live Test

<api-tester endpoint="/v1/auctions/items" method="GET" :hasQuery="true" />

## GET /v1/auctions/itemdetails

Gets all datapoints for a specific item

### Parameters

| Name | Value | Optional
| ----------- | ----------- | ----------- |
| item_def | String | false |
| server | "GLOBAL" | true |

### Response <`application/json`>

```json
[
    {
        "insertedDate": "YYYY-MM-DD",
        "insertedTimestamp": Timestamp,
        "avgLow": Number,
        "avgMean": Number,
        "avgMedian": Number,
        "avgCount": Number
    }
    //...
]
```

### Live Test

<api-tester endpoint="/v1/auctions/itemdetails" method="GET" :hasQuery="true" />