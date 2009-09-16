<?php
/**
 * Copyright 2006-2007 Alkaloid Networks <http://www.alkaloid.net>
 *
 * See the enclosed file LICENSE for license information (BSD). If you did
 * did not receive this file, see http://cvs.horde.org/co.php/vilma/LICENSE.
 *
 * $Horde: vilma/lib/Forms/DeleteDomainForm.php,v 1.1 2008/03/12 02:52:34 bklang Exp $
 *
 * @author  Ben Klang <ben@alkaloid.net>
 * @package Vilma
 */
class DeleteDomainForm extends Horde_Form {

    function DeleteDomainForm(&$vars)
    {
        parent::Horde_Form($vars, _("Delete Domain"));

        $domain_record = $GLOBALS['vilma_driver']->getDomain($vars->get('domain_id'));
        if (is_a($domain_record, 'PEAR_Error')) {
            return $domain_record;
        }

        $domain = $domain_record['domain_name'];
        
        /* Set up the form. */
        $this->setButtons(array(_("Delete"), _("Do not delete")));
        $this->addHidden('', 'domain_id', 'text', false);
        $this->addVariable(sprintf(_("Delete domain \"%s\" and all associated email addresses?"), $domain), 'description', 'description', false);
    }
}
