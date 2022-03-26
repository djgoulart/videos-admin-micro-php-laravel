<?php

namespace Core\UseCase\DTO\Category;


class DeleteCategoryOutputDto
{
    public function __construct(
        public bool $success,
    ) {
    }
}
