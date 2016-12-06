<?php

namespace MyProject\Eloquent;

use Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager as Capsule;
use Phinx\Migration\AbstractMigration;

class Connect extends AbstractMigration
{
    /**
     * @var \Illuminate\Database\Capsule\Manager $capsule
     */
    public $capsule;

    /**
     * @var \Illuminate\Database\Schema\Builder $capsule
     */
    public $schema;

    /**
     * Init the capsule.
     *
     * @return void
     */
    public function init()
    {
        $dotenv = new Dotenv(__DIR__.'/../../');
        $dotenv->load();

        $this->capsule = new Capsule;
        $this->capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => getenv('DB_HOST'),
            'port'      => getenv('DB_PORT'),
            'database'  => getenv('DB_NAME'),
            'username'  => getenv('DB_USER'),
            'password'  => getenv('DB_PASSWORD'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ]);

        $this->capsule->bootEloquent();
        $this->capsule->setAsGlobal();
        $this->schema = $this->capsule->schema();
    }
}