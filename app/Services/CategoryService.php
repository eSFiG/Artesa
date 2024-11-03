<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class CategoryService
{
    public static function getCategoriesForProducts(array $productIds): array
    {
        $ids = implode(',', array_fill(0, count($productIds), '?'));
        return DB::select(
            "SELECT DISTINCT c.name
            FROM categories c
            JOIN category_product cp ON c.id = cp.category_id
            WHERE cp.product_id IN ($ids)",
            $productIds
        );
    }

    public static function getProductsForCategoryAndItsChildren(int $categoryId): array
    {
        return DB::select(
            "WITH RECURSIVE category_tree AS (
            SELECT id
            FROM categories
            WHERE id = ?
            UNION ALL
            SELECT c.id
            FROM categories c
            JOIN category_tree ct ON c.parent_id = ct.id
            )
            SELECT p.id, p.name, p.price, p.quantity_in_stock
            FROM products p
            JOIN category_product cp ON p.id = cp.product_id
            JOIN category_tree ct ON cp.category_id = ct.id",
            [$categoryId]
        );
    }

    public static function getProductCountForCategories(array $categoryIds):array
    {
        $ids = implode(',', array_fill(0, count($categoryIds), '?'));
        return DB::select(
            "SELECT c.id, c.name, COUNT(cp.product_id) AS product_count
            FROM categories c
            LEFT JOIN category_product cp ON c.id = cp.category_id
            WHERE c.id IN ($ids)
            GROUP BY c.id, c.name",
            $categoryIds
        );
    }

    public static function getUniqueProductCountForCategories(array $categoryIds): int
    {
        $ids = implode(',', array_fill(0, count($categoryIds), '?'));
        $result = DB::select(
            "SELECT COUNT(DISTINCT cp.product_id) AS unique_product_count
            FROM category_product cp
            JOIN categories c ON cp.category_id = c.id
            WHERE c.id IN ($ids)",
            $categoryIds
        );
        return $result[0]->unique_product_count;
    }

    public static function getBreadcrumb(int $categoryId): string
    {
        $result = DB::select(
            "WITH RECURSIVE category_path AS (
            SELECT id, name, parent_id
            FROM categories
            WHERE id = ?
            UNION ALL
            SELECT c.id, c.name, c.parent_id
            FROM categories c
            JOIN category_path cp ON c.id = cp.parent_id
            )
            SELECT name FROM category_path ORDER BY id ASC",
            [$categoryId]
        );

        $breadcrumb = '';
        foreach ($result as $category) {
            $breadcrumb .= $category->name . '/';
        }

        return $breadcrumb;
    }
}
