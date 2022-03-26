<?php

namespace Tests\Unit\App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CategoryUnitTest extends BaseModelTestCase
{
    protected function model(): Model
    {
        return new Category();
    }

    protected function traits(): array
    {
        return [
            HasFactory::class,
            SoftDeletes::class
        ];
    }

    protected function fillable(): array
    {
        return [
            'id',
            'name',
            'description',
            'is_active'
        ];
    }

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'is_active' => 'boolean',
            'deleted_at' => 'datetime'
        ];
    }


    public function test_incrementing_atribute_value_should_be_false()
    {
        $this->assertFalse($this->model()->incrementing);
    }
}
