<?php

<<<<<<< HEAD
<<<<<<< HEAD
=======
declare(strict_types=1);

>>>>>>> develop
=======
declare(strict_types=1);

>>>>>>> develop
namespace Doctrine\Instantiator\Exception;

use Exception;
use ReflectionClass;
use UnexpectedValueException as BaseUnexpectedValueException;

use function sprintf;

/**
 * Exception for given parameters causing invalid/unexpected state on instantiation
 */
class UnexpectedValueException extends BaseUnexpectedValueException implements ExceptionInterface
{
    /**
     * @phpstan-param ReflectionClass<T> $reflectionClass
     *
     * @template T of object
     */
    public static function fromSerializationTriggeredException(
        ReflectionClass $reflectionClass,
<<<<<<< HEAD
<<<<<<< HEAD
        Exception $exception
=======
        Exception $exception,
>>>>>>> develop
=======
        Exception $exception,
>>>>>>> develop
    ): self {
        return new self(
            sprintf(
                'An exception was raised while trying to instantiate an instance of "%s" via un-serialization',
<<<<<<< HEAD
<<<<<<< HEAD
                $reflectionClass->getName()
            ),
            0,
            $exception
=======
=======
>>>>>>> develop
                $reflectionClass->getName(),
            ),
            0,
            $exception,
<<<<<<< HEAD
>>>>>>> develop
=======
>>>>>>> develop
        );
    }

    /**
     * @phpstan-param ReflectionClass<T> $reflectionClass
     *
     * @template T of object
     */
    public static function fromUncleanUnSerialization(
        ReflectionClass $reflectionClass,
        string $errorString,
        int $errorCode,
        string $errorFile,
<<<<<<< HEAD
<<<<<<< HEAD
        int $errorLine
=======
        int $errorLine,
>>>>>>> develop
=======
        int $errorLine,
>>>>>>> develop
    ): self {
        return new self(
            sprintf(
                'Could not produce an instance of "%s" via un-serialization, since an error was triggered '
                . 'in file "%s" at line "%d"',
                $reflectionClass->getName(),
                $errorFile,
<<<<<<< HEAD
<<<<<<< HEAD
                $errorLine
            ),
            0,
            new Exception($errorString, $errorCode)
=======
=======
>>>>>>> develop
                $errorLine,
            ),
            0,
            new Exception($errorString, $errorCode),
<<<<<<< HEAD
>>>>>>> develop
=======
>>>>>>> develop
        );
    }
}
