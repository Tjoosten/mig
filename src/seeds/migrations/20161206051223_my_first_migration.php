<?php

use MyProject\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

class MyFirstMigration extends Migration
{
    public function up()
    {
        $this->schema->create('widgets', function (Blueprint $table) {
            $table->timestamps();
        });
    }
    public function down()
    {
        $this->schema->drop('');
    }
}
