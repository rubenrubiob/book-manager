<?php

declare(strict_types=1);

namespace Domain\ValueObject\Autor;

use Domain\Exception\ValueObject\Autor\ApelativoIsNotValid;
use Domain\Exception\ValueObject\NombreIsNotValid;
use Domain\Exception\ValueObject\NombreIsVacio;
use Domain\ValueObject\Nombre;

/**
 * @psalm-immutable
 */
final class Apelativo
{
    private Nombre $alias;
    private ?Nombre $nombre;
    private ?Nombre $apellidos;

    private function __construct(Nombre $alias, ?Nombre $nombre, ?Nombre $apellidos)
    {
        $this->alias     = $alias;
        $this->nombre    = $nombre;
        $this->apellidos = $apellidos;
    }

    /**
     * @throws ApelativoIsNotValid
     * @throws NombreIsNotValid
     */
    public static function fromParts(?string $alias, ?string $nombre, ?string $apellidos): self
    {
        return self::fromComponents(
            self::parseAndValidateAlias($alias),
            self::parseAndValidateComponent($nombre),
            self::parseAndValidateComponent($apellidos)
        );
    }

    public static function fromComponents(Nombre $alias, ?Nombre $nombre, ?Nombre $apellidos): self
    {
        return new self(
            $alias,
            $nombre,
            $apellidos
        );
    }

    public function alias(): Nombre
    {
        return $this->alias;
    }

    public function nombre(): ?Nombre
    {
        return $this->nombre;
    }

    public function apellidos(): ?Nombre
    {
        return $this->apellidos;
    }

    /**
     * @throws ApelativoIsNotValid
     * @throws NombreIsNotValid
     */
    private static function parseAndValidateAlias(?string $alias): Nombre
    {
        if ($alias === null) {
            throw ApelativoIsNotValid::withAliasVacio();
        }

        try {
            return Nombre::fromString($alias);
        } catch (NombreIsVacio $e) {
            throw ApelativoIsNotValid::withAliasVacio();
        }
    }

    /**
     * @throws NombreIsNotValid
     */
    private static function parseAndValidateComponent(?string $component): ?Nombre
    {
        if ($component === null) {
            return null;
        }

        try {
            return Nombre::fromString($component);
        } catch (NombreIsVacio $e) {
        }

        return null;
    }
}
