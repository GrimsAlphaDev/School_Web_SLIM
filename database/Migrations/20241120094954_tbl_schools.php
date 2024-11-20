<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class TblSchools extends AbstractMigration
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
        $table = $this->table('tbl_schools', [
            'id' => true,
            'primary_key' => 'id'
        ]);

        $table
            ->addColumn('school_name', 'string', ['limit' => 100])
            ->addColumn('address', 'string', ['limit' => 255])
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->create();
    }

    public function down(): void
    {
        $this->table('tbl_schools')->drop()->save();
    }
}
