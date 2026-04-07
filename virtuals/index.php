<?php
/**
 * Copyright 2003-2017 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (BSD). If you did not
 * did not receive this file, see http://www.horde.org/licenses/bsd.
 *
 * @author Marko Djukic <marko@oblo.com>
 */

require_once __DIR__ . '/../lib/Application.php';
$vilma = Horde_Registry::appInit('vilma');

/* Only admin should be using this. */
if (!$registry->isAdmin() && !Vilma::isDomainAdmin()) {
    throw new Horde_Exception_AuthenticationFailure();
}

$user = Horde_Util::getFormData('user');
try {
    if (!empty($user)) {
        $virtuals = $vilma->driver->getVirtuals($user);
        $domain = Vilma::stripDomain($user);
    } else {
        $domain = Vilma::getDomain();
        $virtuals = $vilma->driver->getVirtuals($domain);
    }
} catch (Exception $e) {
    $notification->push($e);
    Horde::url('index.php', true)->redirect();
}

foreach ($virtuals as $id => $virtual) {
    $virtuals[$id]['edit_url'] = Horde::url('virtuals/edit.php')
        ->add('virtual_id', $virtual['virtual_id']);
    $virtuals[$id]['del_url'] = Horde::url('virtuals/delete.php')
        ->add('virtual_id', $virtual['virtual_id']);
}

$view = new Horde_View(['templatePath' => VILMA_TEMPLATES . '/virtuals']);
$view->virtuals = $virtuals;

/* Set up the template action links. */
$actions = array();
$url = Horde::url('virtuals/edit.php');
if (!Vilma::isDomainAdmin()) {
    $url->add('domain', $domain);
}
$actions['new_url'] = $url;
$actions['new_text'] = _("New Virtual Email");
$url = Horde::url('users/index.php');
if (!Vilma::isDomainAdmin()) {
    $url->add('domain', $domain);
}
$actions['users_url'] = $url;
$actions['users_text'] = _("Users");
$view->actions = $actions;

/* Set up the field list. */
$images = array('delete' => Horde::img('delete.png', _("Delete User")),
                'edit' => Horde::img('edit.png', _("Edit User")));
$view->images = $images;

/* Render the page. */
$page_output->header();
$notification->notify(array('listeners' => 'status'));
echo $view->render('index');
$page_output->footer();
