<?php

declare(strict_types=1);
/**
 * Vilma configuration class
 *
 * Provides access to the Vilma configuration settings.
 *
 * Old pattern: globals $conf; $somethingDetail = $conf['something']['detail']; *
 * New pattern: $config = $injector->get(VilmaConfig::class); $somethingDetail = $config->get('something.detail');
 *
 * Prefer DI over instantiating $config in your code.
 */

namespace Horde\Vilma;

use Horde\Core\Config\State;
use Horde\Injector\Attribute\Factory;

#[Factory(factory: VilmaConfigFactory::class, method: 'create')]
class VilmaConfig extends State {}
