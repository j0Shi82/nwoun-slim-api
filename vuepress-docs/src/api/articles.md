# Articles

## GET /v1/articles/discussiontags

Get all current tags that you can filter discussion with

### Response <`application/json`>

```json
[
    {
        "term": String,    // name of the tag
        "id": Number       // id of the tag
    }
]
```

### Live Test

<api-tester endpoint="/v1/articles/discussiontags" method="GET" />

## GET /v1/articles/sites

Fetch crawled sites with a sample URL

### Response <`application/json`>

```json
[
    {
        "link": StringLink,
        "site": StringIdent
    },
    //...
]
```

### Live Test

<api-tester endpoint="/v1/articles/sites" method="GET" />

## GET /v1/articles/all

Fetch a set of articles

- get tag ids from `/v1/articles/discussiontags`
- get site ids from `/v1/articles/sites`

### Parameters

| Name | Value | Optional | Default
| ----------- | ----------- | ----------- | ----------- |
| limit | 10-100 | true | 50
| page | 1-X | true | 1
| tags | comma-separated ids (1,2,3) | true |
| types |comma-separated types | true | official,news,guides,discussion,media
| site | ident | true | 

### Response <`application/json`>

```json
[
    {
        "site": "nwreddit",
        "title": "Barovia merchant",
        "link": "https:\/\/www.reddit.com\/r\/Neverwinter\/comments\/y6f55t\/barovia_merchant\/",
        "timestamp": 1666023097,
        "type": "discussion"
    },
    // ...
]
```

### Live Test

<api-tester endpoint="/v1/articles/all" method="GET" :hasQuery="true" />