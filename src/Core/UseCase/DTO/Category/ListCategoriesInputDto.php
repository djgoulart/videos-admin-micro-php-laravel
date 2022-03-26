<?php

namespace Core\UseCase\DTO\Category;

class ListCategoriesInputDto
{
    public function __construct(
        public string $filter = '',
        public string $orderColumn = 'id',
        public string $order = 'DESC',
        public int $page = 1,
        public int $pageLimit = 15
    ) {
    }
}
