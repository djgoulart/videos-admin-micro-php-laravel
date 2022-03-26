<?php

namespace Core\UseCase\DTO\Category;


class UpdateCategoryInputDto
{
    public function __construct(
        public string $id,
        public string $name,
        public string|null $description = null,
    ) {
    }
}
