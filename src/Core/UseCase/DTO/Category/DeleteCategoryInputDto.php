<?php

namespace Core\UseCase\DTO\Category;


class DeleteCategoryInputDto
{
    public function __construct(
        public string $id,
    ) {
    }
}
