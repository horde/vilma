<?php

declare(strict_types=1);
/**
 * Vilma configuration class factory
 *
 * Creates instances of the VilmaConfig class.
 *
 * Old pattern: globals $conf; $somethingDetail = $conf['something']['detail']; *
 * New pattern: $config = $injector->get(VilmaConfig::class); $somethingDetail = $config->get('something.detail');
 *
 * Prefer DI over instantiating $config in your code.
 */

namespace Horde\Vilma;

use Horde\Core\Config\ConfigLoader;
use Horde\Injector\Injector;

class VilmaConfigFactory
{
    public function __construct(private Injector $injector) {}

    public function create(): VilmaConfig
    {
        $state = $this->injector->get(ConfigLoader::class)->load('vilma');
        return new VilmaConfig($state->toArray());
    }
}
