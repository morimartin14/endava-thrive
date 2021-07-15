<?php declare(strict_types=1);

require __DIR__ . "/../src/Models/RecentlyViewedProduct.php";
use PHPUnit\Framework\TestCase;

final class RecentlyViewedProductTest extends TestCase
{
    public function testSaveRecentlyViewedProduct(): void
    {
        $product = new \Models\RecentlyViewedProduct(180, 14);//this represent product and user id
        $this->assertInstanceOf(
            \Models\RecentlyViewedProduct::class,
            $product->save()
        );
    }

    public function testGetRecentlyViewedProductForUser(): void
    {
        $productsArray = \Models\RecentlyViewedProduct::getByUser(14);
        $this->assertIsArray($productsArray);
    }

    public function testUpdateRecentlyViewedProduct(): void
    {
        $products = \Models\Products::getAll(1);
        $product = new \Models\RecentlyViewedProduct($products['products'][0]->getId(), 14);//this an user id
        $updatedRecentlyViewedProduct = $product->save();
        $updatedProduct = \Models\Products::getById($updatedRecentlyViewedProduct->getProductId());
        $recentlyViewedProduct = \Models\RecentlyViewedProduct::getByUser(14);

        $this->assertEquals(
            $updatedProduct,
            $recentlyViewedProduct[0]
        );
    }

    public function testRemoveRecentlyViewedProduct(): void
    {
        $products = \Models\RecentlyViewedProduct::getByUser(14);
        $recentlyViewedProduct = \Models\RecentlyViewedProduct::getByUserAndProductId(14, $products[0]->getId());
        $idToByRemoved = $products[0]->getId();

        $response = $recentlyViewedProduct[0]->remove();

        if ($response) {
            $updatedProducts = \Models\RecentlyViewedProduct::getByUser(14);

            $this->assertNotEquals(
                $updatedProducts[0]->getId(),
                $idToByRemoved
            );
        } else {
            $this->assertFalse($response);
        }
    }

    public function testGetAllRecentlyViewedProduct(): void
    {
        $products = \Models\RecentlyViewedProduct::getByUser(14);

        $this->assertIsArray(
            $products
            );
    }
}