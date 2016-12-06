# Database: Migrations

**NOTE:** This document is based off the laravel document. Much credits to this maintainers.

## Introduction.

Migrations are like like version control for your database, allowing your team to easily modify
and share the application's database schema. Migrations are typically paired with the `Illuminate/Database`
schema builder to easily build your application's database schema. If you have ever had to telpl a teammate
to manually add a column to their local database schema, you've faced the problem taht database migrations
solve.

The `Blueprint` class provides database agnostic support for creating and manipulation
tables accross all of the applications. And Supported database systems. 
