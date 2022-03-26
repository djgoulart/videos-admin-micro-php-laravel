<?php

namespace Core\Domain\Entity;

use Core\Domain\Entity\Traits\MagicMethodsTrait;
use Core\Domain\Validation\DomainValidation;
use Core\Domain\ValueObject\Uuid;

class Category
{
    use MagicMethodsTrait;

    public function __construct(
        protected Uuid|string $id = '',
        protected string $name = '',
        protected string $description = '',
        protected bool $isActive = true,
        protected string $createdAt = '',
        protected string $updatedAt = '',
    ) {
        $this->id = $this->id ? new Uuid($this->id) : Uuid::random();
        $this->validate();
    }

    public function activate()
    {
        $this->isActive = true;
    }

    public function disable()
    {
        $this->isActive = false;
    }

    public function update(string $name, string $description = '')
    {
        $this->name = $name;

        if (isset($description) && trim($description) !== '')
            $this->description = $description;

        $this->validate();
    }

    private function validate()
    {
        DomainValidation::notNull($this->name);
        DomainValidation::strMinLength($this->name);
        DomainValidation::strMaxLength($this->name);

        DomainValidation::strNullOrMinLength($this->description);
        DomainValidation::strNullOrMaxLength($this->description);
    }
}
