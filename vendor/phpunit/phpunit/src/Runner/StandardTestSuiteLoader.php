<?php declare(strict_types=1);
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Runner;

use function array_diff;
use function array_values;
use function basename;
use function class_exists;
use function get_declared_classes;
use function sprintf;
use function stripos;
use function strlen;
use function substr;
use PHPUnit\Framework\TestCase;
use PHPUnit\Util\FileLoader;
use ReflectionClass;
use ReflectionException;

/**
 * @internal This class is not covered by the backward compatibility promise for PHPUnit
 *
 * @deprecated see https://github.com/sebastianbergmann/phpunit/issues/4039
 */
final class StandardTestSuiteLoader implements TestSuiteLoader
{
    /**
     * @throws Exception
     */
    public function load(string $suiteClassFile): ReflectionClass
    {
        $suiteClassName = basename($suiteClassFile, '.php');
        $loadedClasses  = get_declared_classes();

        if (!class_exists($suiteClassName, false)) {
            /* @noinspection UnusedFunctionResultInspection */
            FileLoader::checkAndLoad($suiteClassFile);

            $loadedClasses = array_values(
                array_diff(get_declared_classes(), $loadedClasses)
            );

            if (empty($loadedClasses)) {
<<<<<<< HEAD
<<<<<<< HEAD
                throw $this->exceptionFor($suiteClassName, $suiteClassFile);
=======
=======
>>>>>>> develop
                throw new Exception(
                    sprintf(
                        'Class %s could not be found in %s',
                        $suiteClassName,
                        $suiteClassFile
                    )
                );
<<<<<<< HEAD
>>>>>>> develop
=======
>>>>>>> develop
            }
        }

        if (!class_exists($suiteClassName, false)) {
            $offset = 0 - strlen($suiteClassName);

            foreach ($loadedClasses as $loadedClass) {
                // @see https://github.com/sebastianbergmann/phpunit/issues/5020
                if (stripos(substr($loadedClass, $offset - 1), '\\' . $suiteClassName) === 0 ||
                    stripos(substr($loadedClass, $offset - 1), '_' . $suiteClassName) === 0) {
                    $suiteClassName = $loadedClass;

                    break;
                }
            }
        }

        if (!class_exists($suiteClassName, false)) {
<<<<<<< HEAD
<<<<<<< HEAD
            throw $this->exceptionFor($suiteClassName, $suiteClassFile);
=======
=======
>>>>>>> develop
            throw new Exception(
                sprintf(
                    'Class %s could not be found in %s',
                    $suiteClassName,
                    $suiteClassFile
                )
            );
<<<<<<< HEAD
>>>>>>> develop
=======
>>>>>>> develop
        }

        try {
            $class = new ReflectionClass($suiteClassName);
            // @codeCoverageIgnoreStart
        } catch (ReflectionException $e) {
            throw new Exception(
                $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
        // @codeCoverageIgnoreEnd

<<<<<<< HEAD
<<<<<<< HEAD
        if ($class->isSubclassOf(TestCase::class) && !$class->isAbstract()) {
=======
=======
>>>>>>> develop
        if ($class->isSubclassOf(TestCase::class)) {
            if ($class->isAbstract()) {
                throw new Exception(
                    sprintf(
                        'Class %s declared in %s is abstract',
                        $suiteClassName,
                        $suiteClassFile
                    )
                );
            }

<<<<<<< HEAD
>>>>>>> develop
=======
>>>>>>> develop
            return $class;
        }

        if ($class->hasMethod('suite')) {
            try {
                $method = $class->getMethod('suite');
                // @codeCoverageIgnoreStart
            } catch (ReflectionException $e) {
                throw new Exception(
<<<<<<< HEAD
<<<<<<< HEAD
                    $e->getMessage(),
                    $e->getCode(),
                    $e
                );
            }
            // @codeCoverageIgnoreEnd

            if (!$method->isAbstract() && $method->isPublic() && $method->isStatic()) {
                return $class;
            }
        }

        throw $this->exceptionFor($suiteClassName, $suiteClassFile);
=======
=======
>>>>>>> develop
                    sprintf(
                        'Method %s::suite() declared in %s is abstract',
                        $suiteClassName,
                        $suiteClassFile
                    )
                );
            }

            if (!$method->isPublic()) {
                throw new Exception(
                    sprintf(
                        'Method %s::suite() declared in %s is not public',
                        $suiteClassName,
                        $suiteClassFile
                    )
                );
            }

            if (!$method->isStatic()) {
                throw new Exception(
                    sprintf(
                        'Method %s::suite() declared in %s is not static',
                        $suiteClassName,
                        $suiteClassFile
                    )
                );
            }
        }

        return $class;
<<<<<<< HEAD
>>>>>>> develop
=======
>>>>>>> develop
    }

    public function reload(ReflectionClass $aClass): ReflectionClass
    {
        return $aClass;
    }
<<<<<<< HEAD
<<<<<<< HEAD

    private function exceptionFor(string $className, string $filename): Exception
    {
        return new Exception(
            sprintf(
                "Class '%s' could not be found in '%s'.",
                $className,
                $filename
            )
        );
    }
=======
>>>>>>> develop
=======
>>>>>>> develop
}
