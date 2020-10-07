<?php

declare(strict_types=1);

namespace Domain\Model\Autor;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Domain\Collection\Model\Autor\TraduccionAutorCollection;
use Domain\Exception\Model\Autor\TraduccionAutorAlreadyExists;
use Domain\Model\Traduccion\Autor\TraduccionAutor;
use Domain\ValueObject\Autor\Apelativo;
use Domain\ValueObject\Autor\Biografia;
use Domain\ValueObject\Id;
use Domain\ValueObject\Idioma\Locale;

class Autor
{
    private Id $id;

    private Biografia $biografia;

    /** @psalm-var Collection<int, TraduccionAutor> */
    private Collection $traducciones;

    private function __construct(Id $id, Biografia $biografia)
    {
        $this->id        = $id;
        $this->biografia = $biografia;

        $this->traducciones = new ArrayCollection();
    }

    public static function crear(
        Id $id,
        Biografia $biografia,
        Id $traduccionId,
        Locale $locale,
        Apelativo $apelativo
    ): self {
        $autor = new self($id, $biografia);

        $autor->anadirTraduccion($traduccionId, $locale, $apelativo);

        return $autor;
    }

    /**
     * @throws TraduccionAutorAlreadyExists
     */
    public function anadirTraduccion(Id $traduccionId, Locale $locale, Apelativo $apelativo): void
    {
        $this->traduccionExistsAndFail($locale);

        $this->traducciones->add(
            TraduccionAutor::crear(
                $traduccionId,
                $locale,
                $apelativo,
                $this
            )
        );
    }

    public function id(): Id
    {
        return $this->id;
    }

    public function biografia(): Biografia
    {
        return $this->biografia;
    }

    public function traducciones(): TraduccionAutorCollection
    {
        return TraduccionAutorCollection::fromElements(
            $this->traducciones->toArray()
        );
    }

    /**
     * @throws TraduccionAutorAlreadyExists
     */
    private function traduccionExistsAndFail(Locale $locale): void
    {
        $exists = $this->traducciones->exists(
            static function (int $key, TraduccionAutor $traduccionAutor) use ($locale) {
                return $traduccionAutor->locale()->equalsTo($locale);
            }
        );

        if ($exists) {
            throw TraduccionAutorAlreadyExists::withLocale($this->id, $locale);
        }
    }
}
