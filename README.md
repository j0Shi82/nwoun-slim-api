API for https://www.gond.tools/

# Corresponding Repos:

-   Frontend: https://github.com/j0Shi82/nwoun-gond-tools
-   Crawler: https://github.com/j0Shi82/nwoun-community-crawler (not yet public)

# Setup

-   `composer.phar install`
-   `.env.example` -> `.env` and edit server values
-   `dev/php.example.ini` -> `dev/php.ini` and edit value to match your environment
-   `composer propel` to build the database schema
-   `composer.phar start` to start the server

# Deployment

-   Upload all files except `.example`, `.git*`, `LICENSE`, `README.md` and `dev`
-   Entry point for the API is `www.yourdomain.com/public/v1/devtracker`.
-   Probably the best to let a subdomain point to `public` so you can `api.yourdomain.com/v1/devtracker` etc.

# Live API

The live API is present at `https://api.uncnso.red`. There is no access control policy. Please use responsible or this will change.

# Docs

[https://docs.uncnso.red](https://docs.uncnso.red)

## Development

-   `cd vuepress-docs`
-   `pnpm install`
-   `pnpm docs:dev`

## Deployment

-   `pnpm docs:build`
-   upload `vuepress-docs/src/dist`
