# Devtracker

## GET /v1/devtracker/cats

Get a list of categories for the devtracker

### Response <`application/json`>

```json
[
    {
        "id": Number,
        "title": String,
        "url": String
    },
    //...
]
```

### Live Test

<api-tester endpoint="/v1/devtracker/cats" method="GET" />

## GET /v1/devtracker/devlist

Get the list of devs

### Response <`application/json`>

```json
[
    {
        "postCount": Number,
        "lastActive": Timestamp,
        "devName": String,
        "devId": Number,
        // deprecated
        "post_count": Number,
        "last_active": Timestamp,
        "dev_name": String,
        "dev_id": Number,
    //...
]
```

### Live Test

<api-tester endpoint="/v1/devtracker/devlist" method="GET" />

## GET /v1/devtracker/topiclist

Get the list of topics the devs posted in

### Parameters

| Name | Value | Optional | Default
| ----------- | ----------- | ----------- | ----------- |
| threshold | 5-X | true | 5

### Response <`application/json`>

```json
[
    {
        "postCount": 11,
        "lastActive": 1666052054,
        "discussionId": "1265984",
        "discussionName": "Official: Wizard fixes coming to Preview",
        // deprecated
        "post_count": 11,
        "last_active": 1666052054,
        "discussion_id": "1265984",
        "discussion_name": "Official: Wizard fixes coming to Preview"
    },
    //...
]
```

### Live Test

<api-tester endpoint="/v1/devtracker/topiclist" method="GET" :hasQuery="true" />

## GET /v1/devtracker/list

Get a list of dev posts

### Parameters

| Name | Value | Optional | Default
| ----------- | ----------- | ----------- | ----------- |
| page | 1-X | true | 1
| dev | Number | true | 
| discussion_id | Number | true | 

- get dev ids from `/v1/devtracker/devlist`
- get discussion ids from `/v1/devtracker/topiclist`

### Response <`application/json`>

```json
[
    {
        "timestamp": Timestamp,
        "devName": String,          // => /v1/devtracker/devlist
        "devId": Number,            // => /v1/devtracker/devlist
        "discussionId": String,     // reddit or arcgames id
        "commentId": String,        // reddit or arcgames id
        "categoryId": String,       // => /v1/devtracker/cats
        "discussionName": String,   // => /v1/devtracker/topiclist
        "body": String,
        // deprecated
        "dev_name": String,
        "dev_id": Number, 
        "discussion_id": String,
        "comment_id": String,
        "category_id": String,
        "discussion_name": String,
    }
]
```

### Live Test

<api-tester endpoint="/v1/devtracker/list" method="GET" :hasQuery="true" />

## GET /v1/devtracker/devinfo

Returns info about a specific dev

### Parameters

| Name | Value | Optional | Default
| ----------- | ----------- | ----------- | ----------- |
| dev | String | false | 
| id | Number | false | 0

- need to provide either `dev` or `id`. Precedence is `id` -> `dev`
- `dev` is used to look up Reddit data
- `id` is used to look up Arcgames data

### Response <`application/json`>

```json
[
    {
        "img": Url
    }
]
```

### Live Test

<api-tester endpoint="/v1/devtracker/devinfo" method="GET" :hasQuery="true" />