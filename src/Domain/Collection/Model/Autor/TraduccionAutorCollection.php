<?php

declare(strict_types=1);

namespace Domain\Collection\Model\Autor;

use Countable;
use Domain\Exception\Collection\Model\Autor\TraduccionAutorCollectionIsNotValid;
use Domain\Exception\Model\Autor\TraduccionAutorNotFound;
use Domain\Model\Traduccion\Autor\TraduccionAutor;
use Domain\ValueObject\Idioma\Locale;
use Generator;
use InvalidArgumentException;
use IteratorAggregate;
use Webmozart\Assert\Assert;

use function count;

/**
 * @implements IteratorAggregate<TraduccionAutor>
 */
final class TraduccionAutorCollection implements Countable, IteratorAggregate
{
    /** @var TraduccionAutor[] */
    private array $elements = [];

    private int $count = 0;

    private function __construct()
    {
    }

    /**
     * @param TraduccionAutor[] $elements
     *
     * @return TraduccionAutorCollection
     *
     * @throws TraduccionAutorCollectionIsNotValid
     */
    public static function fromElements(array $elements): self
    {
        try {
            Assert::allIsInstanceOf($elements, TraduccionAutor::class);
        } catch (InvalidArgumentException $e) {
            throw TraduccionAutorCollectionIsNotValid::withInvalidElementType();
        }

        $collection           = new self();
        $collection->elements = $elements;
        $collection->count    = count($elements);

        return $collection;
    }

    /**
     * @throws TraduccionAutorNotFound
     */
    public function ofLocale(Locale $locale): TraduccionAutor
    {
        foreach ($this->elements as $element) {
            if ($element->locale()->equalsTo($locale)) {
                return $element;
            }
        }

        throw TraduccionAutorNotFound::withLocale($locale);
    }

    /**
     * @psalm-return Generator<array-key, TraduccionAutor>
     */
    public function getIterator(): Generator
    {
        yield from $this->elements;
    }

    public function count(): int
    {
        return $this->count;
    }
}
