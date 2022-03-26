<?php

namespace Core\UseCase\DTO\Category;

class UpdateCategoryOutputDto
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description,
        public bool $is_active,
        public string $created_at = '',
        public string $updated_at = '',
    ) {
    }
}
