<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class TblAdmins extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up(): void
    {
        $table = $this->table('tbl_admins', [
            'id' => true,
            'primary_key' => 'id'
        ]);

        $table
            ->addColumn('username', 'string', ['limit' => 100])
            ->addColumn('password', 'string', ['limit' => 255])
            ->addColumn('name', 'string', ['limit' => 100])
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->addIndex(['username'], ['unique' => true])
            ->create();
    }

    public function down(): void
    {
        $this->table('tbl_admins')->drop()->save();
    }
}
