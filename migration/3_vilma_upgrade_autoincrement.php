<?php
/**
 * Adds autoincrement flags
 *
 * Copyright 2010-2017 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (BSD). If you did not
 * did not receive this file, see http://www.horde.org/licenses/bsd.
 *
 * @author   Jan Schneider <jan@horde.org>
 * @category Horde
 * @license  http://www.horde.org/licenses/gpl GPL
 * @package  Vilma
 */
class VilmaUpgradeAutoIncrement extends Horde_Db_Migration_Base
{
    /**
     * Upgrade.
     */
    public function up()
    {
        $this->changeColumn('vilma_domains', 'domain_id', 'autoincrementKey');
        $this->changeColumn('vilma_users', 'user_id', 'autoincrementKey');
        $this->changeColumn('vilma_virtuals', 'virtual_id', 'autoincrementKey');
        if (in_array('vilma_domains_seq', $this->tables())) {
            $this->dropTable('vilma_domains_seq');
        }
        if (in_array('vilma_users_seq', $this->tables())) {
            $this->dropTable('vilma_users_seq');
        }
        if (in_array('vilma_virtuals_seq', $this->tables())) {
            $this->dropTable('vilma_virtuals_seq');
        }
    }

    /**
     * Downgrade
     */
    public function down()
    {
        $this->changeColumn('vilma_domains', 'domain_id', 'integer', array('null' => false));
        $this->changeColumn('vilma_users', 'user_id', 'integer', array('null' => false));
        $this->changeColumn('vilma_virtuals', 'virtual_id', 'integer', array('null' => false));
    }

}