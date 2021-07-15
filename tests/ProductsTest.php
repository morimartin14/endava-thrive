<?php declare(strict_types=1);
require __DIR__ . "/../src/Models/Products.php";
require __DIR__ . "/../src/Helpers/DatabaseConfig.php";
use PHPUnit\Framework\TestCase;

final class ProductsTest extends TestCase
{
    public function testGetProductById(): void
    {
        $product = \Models\Products::getById(371);
        $this->assertInstanceOf(
            \Models\Products::class,
            $product
        );
    }
}