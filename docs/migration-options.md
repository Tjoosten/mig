# Database: Migrations

> **NOTE:** This document is based off the laravel documentation. Much credits to this maintainers.

## Introduction.

Migrations are like like version control for your database, allowing your team to easily modify
and share the application's database schema. Migrations are typically paired with the `Illuminate/Database`
schema builder to easily build your application's database schema. If you have ever had to tell a teammate
to manually add a column to their local database schema, you've faced the problem that database migrations
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

> **NOTE:** If you are using some vagrant instances, you should run this command form within your virtual machine.

### Rolling back migrations

To rollback the migrations, you may use the folliwng command:

```bash
php vendor\bin\phinx rollback -c config-phinx.php
```

## Tables

### Creating tables

To create a new database file, use the `create` method on the `schema` binding. The `create` method
accepts two arguments. The first is the name of the table, while the second is a `Closure` which
receives a `Blueprint` object that may be used to define the new table:

```php
$this->schema->create('users', function (Blueprint $table) {
    $table->increments('id');
});
```

Of course, when creating the table, you may use any of the schema builder's column methods to
define the table's columns.

#### Checking For Table / Column Existence

You may easily check for the existence of table or column using the `hasTable` and `hasColumn` methods:

```php
if ($this->schema->hasTable('users')) {
    //
}

if ($this->schema->hasColumn('users', 'email')) {
    //
}
```

#### Connection & Storage Engine

If you want to perform a schema operation on a database connection that is not your default connection,
use the `connection` method:

```php
$this->schema->connection('foo')->create('users', function ($table) {
    $table->increments('id');
});
```

You may use the `engine` property on the schema builder to define the table's storage engine:

```php
$this->schema->create('users', function ($table) {
    $table->engine = 'InnoDB';
    $table->increments('id');
});
```

## Rename / Dropping Tables

To rename an existing database table, use the `rename` method:

```php
$this->schema->rename($from, $to);
```

To drop an existing table, you may use the `drop` or `dropIfExists` methods:

```php
$this->table->drop('users');
$this->table->dropIfExists('users');
```

#### Renaming Tables with Foreign Keys

Before renaming a table, you should verify that any foreign key constraints on the table have an explicit
name in your migration files instead of letting the application assign a convention based name.
Otherwise, the foreign key constraint name will refer to the old table name.

## Columns

### Creating columns

The `table` method on the `schema` object may be used to update existing tables. Like the `create` method,
the `table` method accepts two arguments: the name of the table and a `Closure` that receives a `Blueprint`
instance you may use to add columns to the table:

```php
$this->schema->table('users', function (Blueprint $table) {
    $table->string('email');
});
```

#### Available Column Types

Of course, the schema builder contains a variety of column types that you may specify when building your tables:

Command                                     | Description
------------------------------------------- | --------------------------------------------------------------------------------------
`$table->bigIncrements('id');`              |  Incrementing ID (primary key) using a "UNSIGNED BIG INTEGER" equivalent.
`$table->bigInteger('votes');`              |  BIGINT equivalent for the database.
`$table->binary('data');`                   |  BLOB equivalent for the database.
`$table->boolean('confirmed');`             |  BOOLEAN equivalent for the database.
`$table->char('name', 4);`                  |  CHAR equivalent with a length.
`$table->date('created_at');`               |  DATE equivalent for the database.
`$table->dateTime('created_at');`           |  DATETIME equivalent for the database.
`$table->dateTimeTz('created_at');`         |  DATETIME (with timezone) equivalent for the database.
`$table->decimal('amount', 5, 2);`          |  DECIMAL equivalent with a precision and scale.
`$table->double('column', 15, 8);`          |  DOUBLE equivalent with precision, 15 digits in total and 8 after the decimal point.
`$table->enum('choices', ['foo', 'bar']);`  | ENUM equivalent for the database.
`$table->float('amount', 8, 2);`            |  FLOAT equivalent for the database, 8 digits in total and 2 after the decimal point.
`$table->increments('id');`                 |  Incrementing ID (primary key) using a "UNSIGNED INTEGER" equivalent.
`$table->integer('votes');`                 |  INTEGER equivalent for the database.
`$table->ipAddress('visitor');`             |  IP address equivalent for the database.
`$table->json('options');`                  |  JSON equivalent for the database.
`$table->jsonb('options');`                 |  JSONB equivalent for the database.
`$table->longText('description');`          |  LONGTEXT equivalent for the database.
`$table->macAddress('device');`             |  MAC address equivalent for the database.
`$table->mediumIncrements('id');`           |  Incrementing ID (primary key) using a "UNSIGNED MEDIUM INTEGER" equivalent.
`$table->mediumInteger('numbers');`         |  MEDIUMINT equivalent for the database.
`$table->mediumText('description');`        |  MEDIUMTEXT equivalent for the database.
`$table->morphs('taggable');`               |  Adds unsigned INTEGER `taggable_id` and STRING `taggable_type`.
`$table->nullableTimestamps();`             |  Same as `timestamps()`.
`$table->rememberToken();`                  |  Adds `remember_token` as VARCHAR(100) NULL.
`$table->smallIncrements('id');`            |  Incrementing ID (primary key) using a "UNSIGNED SMALL INTEGER" equivalent.
`$table->smallInteger('votes');`            |  SMALLINT equivalent for the database.
`$table->softDeletes();`                    |  Adds nullable `deleted_at` column for soft deletes.
`$table->string('email');`                  |  VARCHAR equivalent column.
`$table->string('name', 100);`              |  VARCHAR equivalent with a length.
`$table->text('description');`              |  TEXT equivalent for the database.
`$table->time('sunrise');`                  |  TIME equivalent for the database.
`$table->timeTz('sunrise');`                |  TIME (with timezone) equivalent for the database.
`$table->tinyInteger('numbers');`           |  TINYINT equivalent for the database.
`$table->timestamp('added_on');`            |  TIMESTAMP equivalent for the database.
`$table->timestampTz('added_on');`          |  TIMESTAMP (with timezone) equivalent for the database.
`$table->timestamps();`                     |  Adds nullable `created_at` and `updated_at` columns.
`$table->timestampsTz();`                   |  Adds nullable `created_at` and `updated_at` (with timezone) columns.
`$table->unsignedBigInteger('votes');`      |  Unsigned BIGINT equivalent for the database.
`$table->unsignedInteger('votes');`         |  Unsigned INT equivalent for the database.
`$table->unsignedMediumInteger('votes');`   |  Unsigned MEDIUMINT equivalent for the database.
`$table->unsignedSmallInteger('votes');`    |  Unsigned SMALLINT equivalent for the database.
`$table->unsignedTinyInteger('votes');`     |  Unsigned TINYINT equivalent for the database.
`$table->uuid('id');`                       |  UUID equivalent for the database.

## Column Modifiers

In addition to the column types listed above, there are several column "modifiers" you may use
while adding a column to a database table. For example, to make the column "nullable", you may use
the `nullable` method:

```php
$this->schema->table('users', function (Blueprint $table) {
    $table->string('email')->unique();
});
```

Below is a list of all the column modifiers. This list does not include the index modifiers:

Modifier                    | Description
--------------------------- | ---------------------------------------------------------
`->after('column')`         |  Place the column "after" another column (MySQL Only)
`->comment('my comment')`   |  Add a comment to a column
`->default($value)`         |  Specify a "default" value for the column
`->first()`                 |  Place the column "first" in the table (MySQL Only)
`->nullable()`              |  Allow NULL values to be inserted into the column
`->storedAs($expression)`   |  Create a stored generated column (MySQL Only)
`->unsigned()`              |  Set `integer` columns to `UNSIGNED`
`->virtualAs($expression)`  |  Create a virtual generated column (MySQL Only)

## Modifying columns

### Prerequisites

Before modifying a column, be sure to add the `doctrine/dbal` dependency to your `composer.json` file.
The Doctrine DBAL library is used to determine the current state of the column and create the
SQL queries needed to make the specified adjustments to the column:

```bash
composer require doctrine/dbal
```

### Updating Column Attribute

The `change` method allows you to modify some existing column types to a new type or modify the column's attributes.
For example, you may wish to increase the size of a string column. To see the  `change` method in action,
let's increase the size of the `name` column from 25 to 50:

```php
$this->schema->table('users', function ($table) {
    $table->string('name', 50)->change();
});
```

We could also modify a column to be nullable:

```php
$this->schema->table('users', function ($table) {
    $table->string('name', 50)->nullable()->change();
});
```

> **NOTE:** The following column types can not be "changed": char, double, enum, mediumInteger, timestamp, tinyInteger, ipAddress, json, jsonb,
macAddress, mediumIncrements, morphs, nullableTimestamps, softDeletes, timeTz, timestampTz, timestamps, timestampsTz, unsignedMediumInteger, unsignedTinyInteger, uuid.

#### Renaming columns

To rename a column, you may use the `renameColumn` method on the Schema object. Before renaming a column, be sure
to add the `doctrine/dbal` dependency to your `composer.json` file:

```php
$this->schema->table('users', function ($table) {
    $table->renameColumn($from, $to);
});
```

> **NOTE:** Renaming any column in a table that also has a column of type enum is not currently supported.

## Dropping columns

To drop a column, use the `dropColumn` method on the schema object. Before dropping columns from a SQLite database,
you will need to add the `doctrine/dbal` dependency to your `composer.json` file and run the `composer update` command in your terminal to install the library:

```php
$this->schema->table('users', function ($table) {
    $table->dropColumn('votes');
});
```

You may drop multiple columns from a table by passing an array of column names to the `dropColumn` method:

```php
$this->schema->table('users', function ($table) {
    $table->dropColumn(['votes', 'avatar', 'location']);
});
```

> **NOTE:** Dropping or modifying columns within a single migration while using a SQLite database is not supported.

## Indexes

### Creating indexes

The schema object supports several types of indexs. First, let's look at an example that specifies a column's values should be unique.
To create the index, we can simply chain the `unique` method onto the column definition:

```php
$table->string('email')->unique();
```

Alternatively, you may create the index after defining the column. For example:

```php
$table->unique('email');
```

You may even pass an array of columns to an index method to create a compound index:

```php
$table->index(['account_id', 'created_at']);
```

The application will automatically generate a reasonable index name, but you may pass a second argument
to the method to specify the name yourself:

```php
$table->index('email', 'my_index_name');
```

#### Avaiable Index Types

Command                                      | Description
-------------------------------------------- | ----------------------------------------
`$table->primary('id');`                     | Add a primary key.
`$table->primary(['first', 'last']);`        | Add composite keys.
`$table->unique('email')`                    | Add a unique index.
`$table->unique(['state', 'my_index_name'])` | Add a custom index name.
`$table->unique(['first', 'last']);`         | Add a composite unique index.
`$table->index('state')`                     | Add a basic index.

## Dropping indexes

To drop an index, you must specify the index's name. By default,
The application automatically assigns a reasonable name to the indexes.
Simply concatenate the table name, the name of the indexed column, and the index type. Here are some examples:

Command                                      | Description
-------------------------------------------- | ----------------------------------------
`$table->dropPrimary('users_id_primary');`   | Drop a primary key from the "users" table.
`$table->dropUnique('users_email_unique');`  | Drop a unique index from the "users" table.
`$table->dropIndex('geo_state_index');`      | Drop a basic index from the "geo" table.

If you pass an array of columns into a method that drops indexes,
the conventional index name will be generated based on the table name, columns and key type:

```php
$this->schema->dropIndex('geo', function ($table) {
    $table->dropIndex(['state']);
});
```

# Foreign Key constraints

The application also provides support for creating foreign key constraints, which are used to force referential
integrity at the database level. For example, let's define a `user_id` column on the `posts` table that references the `id`
column on a `users` table:

```php
$this->table->table('posts', function ($table) {
    $table->integer('user_id')->unsigned();
    $table->foreign('user_id')->references('id')->on('users');
});
```

You may also specify the desired action for the "on delete" and "on update" properties of the constraint:

```php
$table->foreign('user_id')
    ->references('id')->on('users')
    ->onDelete('cascade');
```

To drop a foreign key, you may use the `dropForeign` method. Foreign key constraints use the same naming
convention as indexes. So, we will concatenate the table name and the columns in the constraint then suffix
the name with "_foreign.php":

```php
$table->dropForeign('post_user_id_foreign');
```

Or, you may pass an array value which will automatically use the conventional constraint name when dropping:

```php
$table->dropForeign(['user_id']);
```

You may enable of disable foreign key constraint within your migrations by using the following methods:

```php
$this->schema->enableForeignKeyConstraints();
$this->schema->disableForeignKeyConstraints();
```
