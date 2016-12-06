# Database: Migrations

**NOTE:** This document is based off the laravel documentation. Much credits to this maintainers.

## Introduction.

Migrations are like like version control for your database, allowing your team to easily modify
and share the application's database schema. Migrations are typically paired with the `Illuminate/Database`
schema builder to easily build your application's database schema. If you have ever had to telpl a teammate
to manually add a column to their local database schema, you've faced the problem taht database migrations
solve.

The `Blueprint` class provides database agnostic support for creating and manipulation
tables accross all of the applications. And Supported database systems.

## Generating Migrations

To create a migration; use the following command:

```bash
php vendor/bin/phinx create MyFirstMigration -c config-phinx.php
```

The new migration file will be placed in your `src/migrations` directory.
The `-c` flag option may used to point out your configuration file.

## Migration structure

A migration class contains two methods: `up` and `down`. The `up` method is used to add new tables, columns,
or indexes to your database, while the `down` method should simply reverse the operations performed by
the `up` method.

Within both of these methods you may use the schema builder to expressively create and modify tables.
For example, this migration examples a `users` table:

````php
<?php

use Activism\Be\Eloquent\Connect;
use Illuminate\Database\Schema\Blueprint;

class UsersMigration extends Connect
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('widgets', function(Blueprint $table){  
            $table->increments('id');
            $table->string('username');
            $table->string('email');
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->drop('users');
    }
}
```

## Running migrations

To run all of your outstanding migrations, execute the migration command:

```bash
php vendor/bin/phinx migrate -c config-phinx.php
```

**NOTE:** If you are using some vagrant instances, you should run this command form within your virtual machine.

### Rolling back migrations

To rollback the migrations, you may use the folliwng command:

```bash
php vendor\bin\phinx rollback -c config-phinx.php
```

## Tables

### Creating tables
