API for https://www.nwo-uncensored.com/

# Corresponding Repos:
- Frontend: https://github.com/j0Shi82/nwoun-homepage-index
- Crawler: https://github.com/j0Shi82/nwoun-community-crawler

# Setup

- `composer.phar install`
- `.env.example` -> `.env` and edit server values
- `dev/php.example.ini` -> `dev/php.ini` and edit value to match your environment
- `composer.phar start` to start the server

# Deployment

- Upload all files except `.example`, `.git*`, `LICENSE`, `README.md` and `dev`
- Entry point for the API is `www.yourdomain.com/public/v1/devtracker`.
- Probably the best to let a subdomain point to `public` so you can `api.yourdomain.com/v1/devtracker` etc.

# Live API

The live API is present at `https://api.uncnso.red`. There is no access control policy. Please use responsible or this will change.

All responses are `Content-Type: application/json`.

### GET /v1/devtracker/list

Retrieves a list of dev posts, sorted by date descending

Params:

``` js
{
    dev: '',            // specific dev id
    discussion_id: 0,   // specific discussion id
    search_term: '',    // basic search term
    count: 20,          // amount of dev posts to retrieve (max 50)
    start_page: 0       // page to start from
}
```

Examples:

- https://api.uncnso.red/v1/devtracker/list?dev=1659280
- https://api.uncnso.red/v1/devtracker/list?discussion_id=1262138
- https://api.uncnso.red/v1/devtracker/list?search_term=bug
- https://api.uncnso.red/v1/devtracker/list?count=50
- https://api.uncnso.red/v1/devtracker/list?start_page=4

Answer:

```json
[
    {
        body: "",               // post body with html
        comment_id: "",         // comment id if the post is a comment
        dev_id: "",             // dev_id - compatible with dev param
        dev_name: "",           // developer name on the forum
        discussion_id: 0,       // discussion id - compatible with discussion_id param
        discussion_name: "",    // discussion title
        timestamp: 1234567890   // last updated timestamp
    }
]
```