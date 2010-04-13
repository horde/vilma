<?php
/**
 * Copyright 2003-2010 The Horde Project (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (BSD). If you did not
 * did not receive this file, see http://cvs.horde.org/co.php/vilma/LICENSE.
 *
 * @author Marko Djukic <marko@oblo.com>
 */

@define('VILMA_BASE', dirname(__FILE__) . '/..');
require_once VILMA_BASE . '/lib/base.php';

/* Only admin should be using this. */
if (!Horde_Auth::isAdmin() && !Vilma::isDomainAdmin()) {
    Horde_Auth::authenticateFailure('vilma', $e);
}

$user = Horde_Util::getFormData('user');
if (!empty($user)) {
    $virtuals = $vilma_driver->getVirtuals($user);
    $domain = Vilma::stripDomain($user);
} else {
    $domain = Vilma::getDomain();
    $virtuals = $vilma_driver->getVirtuals($domain);
}

if (is_a($virtuals, 'PEAR_Error')) {
    $notification->push($virtuals);
    header('Location: ' . Horde::applicationUrl('index.php'));
}

foreach ($virtuals as $id => $virtual) {
    $url = Horde::applicationUrl('virtuals/edit.php');
    $virtuals[$id]['edit_url'] = Horde_Util::addParameter($url, 'virtual_id', $virtual['virtual_id']);
    $url = Horde::applicationUrl('virtuals/delete.php');
    $virtuals[$id]['del_url'] = Horde_Util::addParameter($url, 'virtual_id', $virtual['virtual_id']);
}

$template->set('virtuals', $virtuals, true);

/* Set up the template action links. */
$actions = array();
$url = Horde::applicationUrl('virtuals/edit.php');
$actions['new_url'] = (Vilma::isDomainAdmin() ? $url : Horde_Util::addParameter($url, 'domain', $domain));
$actions['new_text'] = _("New Virtual Email");
$url = Horde::applicationUrl('users/index.php');
$actions['users_url'] = (Vilma::isDomainAdmin() ? $url : Horde_Util::addParameter($url, 'domain', $domain));
$actions['users_text'] = _("Users");
$template->set('actions', $actions);

/* Set up the field list. */
$images = array('delete' => Horde::img('delete.png', _("Delete User")),
                'edit' => Horde::img('edit.png', _("Edit User")));
$template->set('images', $images);

$template->set('menu', Vilma::getMenu('string'));

Horde::startBuffer();
$notification->notify(array('listeners' => 'status'));
$template->set('notify', Horde::endBuffer());

/* Render the page. */
require VILMA_TEMPLATES . '/common-header.inc';
echo $template->fetch(VILMA_TEMPLATES . '/virtuals/index.html');
require $registry->get('templates', 'horde') . '/common-footer.inc';
