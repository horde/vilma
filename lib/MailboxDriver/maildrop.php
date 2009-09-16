<?php
/**
 * Copyright 2004-2009 The Horde Project (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (BSD). If you did not
 * did not receive this file, see http://cvs.horde.org/co.php/vilma/LICENSE.
 *
 * $Horde: vilma/lib/MailboxDriver/maildrop.php,v 1.17 2009/05/27 23:57:32 bklang Exp $
 *
 * @author  Jason M. Felice <jason.m.felice@gmail.com>
 * @package Vilma
 */
class Vilma_MailboxDriver_maildrop extends Vilma_MailboxDriver {

    function _getMailboxDir($user, $domain)
    {
        if (empty($this->_params['mail_dir_base'])) {
            require_once 'PEAR.php';
            return PEAR::raiseError(_("No 'mail_dir_base' parameter specified to maildrop driver."));
        }
        $dir = $this->_params['mail_dir_base'];
        $usedomain = isset($this->_params['usedomain']) ? $this->_params['usedomain'] : false;
        if ($usedomain) {
            $dir .= '/' . $domain;
        }

        return $dir . '/' . $user;
    }

    function checkMailbox($user, $domain)
    {
        static $exists;

        $dir = $this->_getMailboxDir($user, $domain);
        if (is_a($dir, 'PEAR_Error')) {
            return $dir;
        }

        if (!isset($exists[$dir])) {
            $exists[$dir] = is_dir($dir);
        }

        if (!$exists[$dir]) {
            require_once 'PEAR.php';
            return PEAR::raiseError(sprintf(_("Maildrop directory \"%s\" does not exist."), $dir));
        }

        return true;
    }

    function createMailbox($user, $domain)
    {
        $dir = $this->_getMailboxDir($user, $domain);
        if (is_a($dir, 'PEAR_Error')) {
            return $dir;
        }
        if (empty($this->_params['system_user'])) {
            require_once 'PEAR.php';
            return PEAR::raiseError(_("No 'system_user' parameter specified to maildrop driver."));
        }

        $create_function = sprintf('sudo -u %s maildirmake %s',
                                   escapeshellarg($this->_params['system_user']),
                                   escapeshellarg($dir));
        exec($create_function);
        return true;
    }

    /**
     * @TODO: Implement
     */
    function deleteMailbox($user, $domain)
    {
        return true;
    }

}
