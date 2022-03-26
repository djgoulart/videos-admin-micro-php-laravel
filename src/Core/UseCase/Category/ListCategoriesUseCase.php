<?php

namespace Core\UseCase\Category;

use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\DTO\Category\{
    ListCategoriesInputDto,
    ListCategoriesOutputDto
};

class ListCategoriesUseCase
{
    protected $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(ListCategoriesInputDto $input): ListCategoriesOutputDto
    {
        $categories = $this->repository->paginate(
            filter: $input->filter,
            orderColumn: $input->orderColumn,
            order: $input->order,
            page: $input->page,
            pageLimit: $input->pageLimit
        );

        return new ListCategoriesOutputDto(
            items: $categories->items(),
            total: $categories->total(),
            first_page: $categories->firstPage(),
            current_page: $categories->currentPage(),
            last_page: $categories->lastPage(),
            per_page: $categories->perPage(),
            to: $categories->to(),
            from: $categories->from(),
        );

        // return new ListCategoriesOutputDto(
        //     items: array_map(function ($data) {
        //         return [
        //             'id' => $data->id,
        //             'name' => $data->name,
        //             'description' => $data->description,
        //             'is_active' => (bool) $data->is_active,
        //             'created_at' => (string) $data->created_at,
        //             'updated_at' => (string) $data->updated_at,
        //         ];
        //     }, $categories->items()),
        //     total: $categories->total(),
        //     last_page: $categories->lastPage(),
        //     first_page: $categories->firstPage(),
        //     per_page: $categories->perPage(),
        //     to: $categories->to(),
        //     from: $categories->to(),
        // );
    }
}
