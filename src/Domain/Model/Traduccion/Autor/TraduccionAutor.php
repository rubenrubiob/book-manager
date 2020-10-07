<?php

declare(strict_types=1);

namespace Domain\Model\Traduccion\Autor;

use Domain\Model\Autor\Autor;
use Domain\ValueObject\Autor\Apelativo;
use Domain\ValueObject\Id;
use Domain\ValueObject\Idioma\Locale;

class TraduccionAutor
{
    private Id $id;

    private Locale $locale;

    private Apelativo $apelativo;

    private Autor $autor;

    private function __construct(Id $id, Locale $locale, Apelativo $apelativo, Autor $autor)
    {
        $this->id        = $id;
        $this->locale    = $locale;
        $this->apelativo = $apelativo;
        $this->autor     = $autor;
    }

    public static function crear(Id $id, Locale $locale, Apelativo $apelativo, Autor $autor): self
    {
        return new self(
            $id,
            $locale,
            $apelativo,
            $autor
        );
    }

    public function id(): Id
    {
        return $this->id;
    }

    public function locale(): Locale
    {
        return $this->locale;
    }

    public function apelativo(): Apelativo
    {
        return $this->apelativo;
    }
}
