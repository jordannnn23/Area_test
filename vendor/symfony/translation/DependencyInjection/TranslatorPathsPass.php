<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\AbstractRecursivePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ServiceLocator;

/**
 * @author Yonel Ceruto <yonelceruto@gmail.com>
 */
class TranslatorPathsPass extends AbstractRecursivePass
{
<<<<<<< HEAD
    private $translatorServiceId;
    private $debugCommandServiceId;
    private $updateCommandServiceId;
    private $resolverServiceId;
    private $level = 0;
=======
    private int $level = 0;
>>>>>>> develop

    /**
     * @var array<string, bool>
     */
<<<<<<< HEAD
    private $paths = [];
=======
    private array $paths = [];
>>>>>>> develop

    /**
     * @var array<int, Definition>
     */
<<<<<<< HEAD
    private $definitions = [];
=======
    private array $definitions = [];
>>>>>>> develop

    /**
     * @var array<string, array<string, bool>>
     */
<<<<<<< HEAD
    private $controllers = [];

    public function __construct(string $translatorServiceId = 'translator', string $debugCommandServiceId = 'console.command.translation_debug', string $updateCommandServiceId = 'console.command.translation_extract', string $resolverServiceId = 'argument_resolver.service')
    {
        if (0 < \func_num_args()) {
            trigger_deprecation('symfony/translation', '5.3', 'Configuring "%s" is deprecated.', __CLASS__);
        }

        $this->translatorServiceId = $translatorServiceId;
        $this->debugCommandServiceId = $debugCommandServiceId;
        $this->updateCommandServiceId = $updateCommandServiceId;
        $this->resolverServiceId = $resolverServiceId;
    }

    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition($this->translatorServiceId)) {
=======
    private array $controllers = [];

    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('translator')) {
>>>>>>> develop
            return;
        }

        foreach ($this->findControllerArguments($container) as $controller => $argument) {
            $id = substr($controller, 0, strpos($controller, ':') ?: \strlen($controller));
            if ($container->hasDefinition($id)) {
                [$locatorRef] = $argument->getValues();
                $this->controllers[(string) $locatorRef][$container->getDefinition($id)->getClass()] = true;
            }
        }

        try {
            parent::process($container);

            $paths = [];
            foreach ($this->paths as $class => $_) {
                if (($r = $container->getReflectionClass($class)) && !$r->isInterface()) {
                    $paths[] = $r->getFileName();
                    foreach ($r->getTraits() as $trait) {
                        $paths[] = $trait->getFileName();
                    }
                }
            }
            if ($paths) {
<<<<<<< HEAD
                if ($container->hasDefinition($this->debugCommandServiceId)) {
                    $definition = $container->getDefinition($this->debugCommandServiceId);
                    $definition->replaceArgument(6, array_merge($definition->getArgument(6), $paths));
                }
                if ($container->hasDefinition($this->updateCommandServiceId)) {
                    $definition = $container->getDefinition($this->updateCommandServiceId);
=======
                if ($container->hasDefinition('console.command.translation_debug')) {
                    $definition = $container->getDefinition('console.command.translation_debug');
                    $definition->replaceArgument(6, array_merge($definition->getArgument(6), $paths));
                }
                if ($container->hasDefinition('console.command.translation_extract')) {
                    $definition = $container->getDefinition('console.command.translation_extract');
>>>>>>> develop
                    $definition->replaceArgument(7, array_merge($definition->getArgument(7), $paths));
                }
            }
        } finally {
            $this->level = 0;
            $this->paths = [];
            $this->definitions = [];
        }
    }

<<<<<<< HEAD
    protected function processValue($value, bool $isRoot = false)
    {
        if ($value instanceof Reference) {
            if ((string) $value === $this->translatorServiceId) {
=======
    protected function processValue(mixed $value, bool $isRoot = false): mixed
    {
        if ($value instanceof Reference) {
            if ('translator' === (string) $value) {
>>>>>>> develop
                for ($i = $this->level - 1; $i >= 0; --$i) {
                    $class = $this->definitions[$i]->getClass();

                    if (ServiceLocator::class === $class) {
                        if (!isset($this->controllers[$this->currentId])) {
                            continue;
                        }
                        foreach ($this->controllers[$this->currentId] as $class => $_) {
                            $this->paths[$class] = true;
                        }
                    } else {
                        $this->paths[$class] = true;
                    }

                    break;
                }
            }

            return $value;
        }

        if ($value instanceof Definition) {
            $this->definitions[$this->level++] = $value;
            $value = parent::processValue($value, $isRoot);
            unset($this->definitions[--$this->level]);

            return $value;
        }

        return parent::processValue($value, $isRoot);
    }

    private function findControllerArguments(ContainerBuilder $container): array
    {
<<<<<<< HEAD
        if ($container->hasDefinition($this->resolverServiceId)) {
            $argument = $container->getDefinition($this->resolverServiceId)->getArgument(0);
=======
        if ($container->hasDefinition('argument_resolver.service')) {
            $argument = $container->getDefinition('argument_resolver.service')->getArgument(0);
>>>>>>> develop
            if ($argument instanceof Reference) {
                $argument = $container->getDefinition($argument);
            }

            return $argument->getArgument(0);
        }

<<<<<<< HEAD
        if ($container->hasDefinition('debug.'.$this->resolverServiceId)) {
            $argument = $container->getDefinition('debug.'.$this->resolverServiceId)->getArgument(0);
=======
        if ($container->hasDefinition('debug.'.'argument_resolver.service')) {
            $argument = $container->getDefinition('debug.'.'argument_resolver.service')->getArgument(0);
>>>>>>> develop
            if ($argument instanceof Reference) {
                $argument = $container->getDefinition($argument);
            }
            $argument = $argument->getArgument(0);
            if ($argument instanceof Reference) {
                $argument = $container->getDefinition($argument);
            }

            return $argument->getArgument(0);
        }

        return [];
    }
}
