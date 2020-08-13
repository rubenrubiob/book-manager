<?php

declare(strict_types=1);

namespace Domain\ValueObject\Autor;

use Domain\Exception\ValueObject\AnyoIsNotValid;
use Domain\Exception\ValueObject\Autor\BiografiaIsNotValid;
use Domain\ValueObject\Anyo;

use function is_string;
use function trim;

/**
 * @psalm-immutable
 */
final class Biografia
{
    private Anyo $anyoNacimiento;

    private ?Anyo $anyoMuerte;

    private function __construct(Anyo $anyoNacimiento, ?Anyo $anyoMuerte)
    {
        $this->anyoNacimiento = $anyoNacimiento;
        $this->anyoMuerte     = $anyoMuerte;
    }

    /**
     * @param string|int|null $anyoNacimiento
     * @param string|int|null $anyoMuerte
     *
     * @throws BiografiaIsNotValid
     * @throws AnyoIsNotValid
     */
    public static function fromAnyoNacimientoYMuerte($anyoNacimiento, $anyoMuerte): self
    {
        return self::fromAnyos(
            Anyo::fromValue($anyoNacimiento),
            self::parseAnyoMuerte($anyoMuerte)
        );
    }

    public static function fromAnyos(Anyo $anyoNacimiento, ?Anyo $anyoMuerte): self
    {
        if ($anyoMuerte === null) {
            return new self($anyoNacimiento, $anyoMuerte);
        }

        if ($anyoMuerte->lowerThan($anyoNacimiento)) {
            throw BiografiaIsNotValid::withAnyoMuerteAnteriorAAnyoNacimiento($anyoNacimiento, $anyoMuerte);
        }

        return new self($anyoNacimiento, $anyoMuerte);
    }

    public function equalsTo(Biografia $anotherBiografia): bool
    {
        if ($this->anyoMuerte !== null && $anotherBiografia->anyoMuerte !== null) {
            return $this->anyoNacimiento->equalsTo($anotherBiografia->anyoNacimiento)
                && $this->anyoMuerte->equalsTo($anotherBiografia->anyoMuerte);
        }

        if ($this->anyoMuerte === null && $anotherBiografia->anyoMuerte !== null) {
            return false;
        }

        if ($this->anyoMuerte !== null && $anotherBiografia->anyoMuerte === null) {
            return false;
        }

        return $this->anyoNacimiento->equalsTo($anotherBiografia->anyoNacimiento);
    }

    public function anyoNacimiento(): Anyo
    {
        return $this->anyoNacimiento;
    }

    public function anyoMuerte(): ?Anyo
    {
        return $this->anyoMuerte;
    }

    /**
     * @param string|int|null $anyoMuerte
     *
     * @throws AnyoIsNotValid
     */
    private static function parseAnyoMuerte($anyoMuerte): ?Anyo
    {
        if (is_string($anyoMuerte)) {
            $anyoMuerte = trim($anyoMuerte);
        }

        if ($anyoMuerte === null || $anyoMuerte === '') {
            return null;
        }

        return Anyo::fromValue($anyoMuerte);
    }
}
