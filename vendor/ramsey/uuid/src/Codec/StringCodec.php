<?php

/**
 * This file is part of the ramsey/uuid library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) Ben Ramsey <ben@benramsey.com>
 * @license http://opensource.org/licenses/MIT MIT
 */

declare(strict_types=1);

namespace Ramsey\Uuid\Codec;

use Ramsey\Uuid\Builder\UuidBuilderInterface;
use Ramsey\Uuid\Exception\InvalidArgumentException;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
<<<<<<< HEAD
use Ramsey\Uuid\Rfc4122\FieldsInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

use function hex2bin;
use function implode;
=======
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

use function bin2hex;
use function hex2bin;
use function implode;
use function sprintf;
>>>>>>> develop
use function str_replace;
use function strlen;
use function substr;

/**
 * StringCodec encodes and decodes RFC 4122 UUIDs
 *
 * @link http://tools.ietf.org/html/rfc4122
 *
 * @psalm-immutable
 */
class StringCodec implements CodecInterface
{
    /**
<<<<<<< HEAD
     * @var UuidBuilderInterface
     */
    private $builder;

    /**
=======
>>>>>>> develop
     * Constructs a StringCodec
     *
     * @param UuidBuilderInterface $builder The builder to use when encoding UUIDs
     */
<<<<<<< HEAD
    public function __construct(UuidBuilderInterface $builder)
    {
        $this->builder = $builder;
=======
    public function __construct(private UuidBuilderInterface $builder)
    {
>>>>>>> develop
    }

    public function encode(UuidInterface $uuid): string
    {
<<<<<<< HEAD
        /** @var FieldsInterface $fields */
        $fields = $uuid->getFields();

        return $fields->getTimeLow()->toString()
            . '-'
            . $fields->getTimeMid()->toString()
            . '-'
            . $fields->getTimeHiAndVersion()->toString()
            . '-'
            . $fields->getClockSeqHiAndReserved()->toString()
            . $fields->getClockSeqLow()->toString()
            . '-'
            . $fields->getNode()->toString();
=======
        $hex = bin2hex($uuid->getFields()->getBytes());

        /** @var non-empty-string */
        return sprintf(
            '%08s-%04s-%04s-%04s-%012s',
            substr($hex, 0, 8),
            substr($hex, 8, 4),
            substr($hex, 12, 4),
            substr($hex, 16, 4),
            substr($hex, 20),
        );
>>>>>>> develop
    }

    /**
     * @psalm-return non-empty-string
     * @psalm-suppress MoreSpecificReturnType we know that the retrieved `string` is never empty
     * @psalm-suppress LessSpecificReturnStatement we know that the retrieved `string` is never empty
     */
    public function encodeBinary(UuidInterface $uuid): string
    {
        /** @phpstan-ignore-next-line PHPStan complains that this is not a non-empty-string. */
        return $uuid->getFields()->getBytes();
    }

    /**
     * @throws InvalidUuidStringException
     *
     * @inheritDoc
     */
    public function decode(string $encodedUuid): UuidInterface
    {
        return $this->builder->build($this, $this->getBytes($encodedUuid));
    }

    public function decodeBytes(string $bytes): UuidInterface
    {
        if (strlen($bytes) !== 16) {
            throw new InvalidArgumentException(
                '$bytes string should contain 16 characters.'
            );
        }

        return $this->builder->build($this, $bytes);
    }

    /**
     * Returns the UUID builder
     */
    protected function getBuilder(): UuidBuilderInterface
    {
        return $this->builder;
    }

    /**
     * Returns a byte string of the UUID
     */
    protected function getBytes(string $encodedUuid): string
    {
        $parsedUuid = str_replace(
            ['urn:', 'uuid:', 'URN:', 'UUID:', '{', '}', '-'],
            '',
            $encodedUuid
        );

        $components = [
            substr($parsedUuid, 0, 8),
            substr($parsedUuid, 8, 4),
            substr($parsedUuid, 12, 4),
            substr($parsedUuid, 16, 4),
            substr($parsedUuid, 20),
        ];

        if (!Uuid::isValid(implode('-', $components))) {
            throw new InvalidUuidStringException(
                'Invalid UUID string: ' . $encodedUuid
            );
        }

        return (string) hex2bin($parsedUuid);
    }
}
