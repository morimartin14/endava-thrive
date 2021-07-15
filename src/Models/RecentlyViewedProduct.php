<?php

namespace Models;

use Helpers\DatabaseConfig;
use mysqli;

class RecentlyViewedProduct {
    private $id, $product_id, $user_id, $last_viewed_date;

    /**
     * RecentlyViewedProduct constructor.
     * @param $product_id
     * @param $user_id
     * @param $last_viewed_date
     */
    public function __construct($product_id, $user_id, $last_viewed_date = null)
    {
        $this->product_id = $product_id;
        $this->user_id = $user_id;
        $this->last_viewed_date = $last_viewed_date ?? date('Y-m-d H:i:s');
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * @param mixed $product_id
     */
    public function setProductId($product_id)
    {
        $this->product_id = $product_id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getLastViewedDate()
    {
        return $this->last_viewed_date;
    }

    /**
     * @param mixed $last_viewed_date
     */
    public function setLastViewedDate($last_viewed_date)
    {
        $this->last_viewed_date = $last_viewed_date;
    }

    public function save() {
        //here i'm going to check if there is more tan 100 products on the list
        // if this is true, i will remove the last item, in order to add the new one and have always a max of 100
        // and here we can check if the time limit has pass for the last viewed product to delete related table records
        $con = DatabaseConfig::connect();
        $queryCount = $con->prepare("SELECT count(id), last_view_date FROM recently_viewed_product WHERE user_id = ? GROUP BY id ORDER BY `last_view_date` DESC");
        $queryCount->bind_param("i", $this->user_id);
        $queryCount->execute();
        $count = 0;
        $queryCount->bind_result($count, $last_view_date);
        $queryCount->fetch();
        //here we can compare $last_view_date with the x day limit for those records
        DatabaseConfig::disconnect($con);

        $con = DatabaseConfig::connect();
        if ($count >= 100) {
            $removeLast = $count - 101;
            $idsToByRemoved = 0;
            $query = $con->prepare("SELECT recently_viewed_product.id FROM recently_viewed_product JOIN product on product_id = product.id WHERE recently_viewed_product.user_id = ? ORDER BY `last_view_date` ASC LIMIT ?");
            $query->bind_param("ii", $this->user_id, $removeLast);
            $query->execute();
            $query->bind_result($idsToByRemoved);
            while ($query->fetch()) {
                //I'm doing this loop here because i was seeing the "This version of MySQL doesn't yet support 'LIMIT & IN/ALL/ANY/SOME subquery" error when I try to delete in the same query
                //I have never work with plane php before, I believe that any ORM could manage this situation and make more performant approach
                $temporaryCon = DatabaseConfig::connect();
                $temporaryCon->query('DELETE FROM recently_viewed_product WHERE id = '. $idsToByRemoved);
                DatabaseConfig::disconnect($temporaryCon);
            }
        }
        DatabaseConfig::disconnect($con);

        $con = DatabaseConfig::connect();
        $queryProductCount = $con->prepare("SELECT count(*) FROM recently_viewed_product WHERE product_id = ? AND user_id = ?");
        $queryProductCount->bind_param("ii", $this->product_id, $this->user_id);
        $queryProductCount->execute();
        $productCount = 0;
        $queryProductCount->bind_result($productCount);
        $queryProductCount->fetch();
        DatabaseConfig::disconnect($con);

        $con = DatabaseConfig::connect();
        if ($productCount) {
            $query = $con->prepare("UPDATE recently_viewed_product set last_view_date = ? WHERE product_id = ? and user_id = ?");
        } else {
            $query = $con->prepare("INSERT INTO recently_viewed_product (last_view_date, product_id, user_id) VALUES (?,?,?)");
        }

        $query->bind_param("sii", $this->last_viewed_date, $this->product_id, $this->user_id);
        $query->execute();

        DatabaseConfig::disconnect($con);
        return $this;
    }

    static public function getByUser($uid) {
        $con = DatabaseConfig::connect();
        $query = $con->prepare("SELECT product.id, product.name, product.description, product.price FROM product JOIN recently_viewed_product as rw on rw.product_id = product.id WHERE rw.user_id = ? ORDER BY rw.last_view_date desc LIMIT 100");
        $query->bind_param("i", $uid);
        $query->execute();
        $query->bind_result($id, $name, $description, $price);
        $productsArray = [];
        while ($query->fetch()) {
            $product = new Products($name, $description, $price);
            $product->setId($id);
            $productsArray[] = $product;
        }
        DatabaseConfig::disconnect($con);
        return $productsArray;
    }

    static public function getByUserAndProductId($uid, $pid) {
        $con = DatabaseConfig::connect();
        $query = $con->prepare("SELECT recently_viewed_product.id, recently_viewed_product.product_id, recently_viewed_product.user_id, recently_viewed_product.last_view_date FROM recently_viewed_product WHERE user_id = ? and product_id = ? ORDER BY last_view_date desc LIMIT 100");
        $query->bind_param("ii", $uid, $pid);
        $query->execute();
        $query->bind_result($id, $product_id, $user_id, $last_view_date);
        $productsArray = [];
        while ($query->fetch()) {
            $product = new RecentlyViewedProduct($product_id, $user_id, $last_view_date);
            $product->setId($id);
            $productsArray[] = $product;
        }
        DatabaseConfig::disconnect($con);
        return $productsArray;
    }


    public function remove() {
        $temporaryCon = DatabaseConfig::connect();
        $result = $temporaryCon->query('DELETE FROM recently_viewed_product WHERE user_id = '. $this->user_id . " AND " . "product_id = " . $this->product_id);
        DatabaseConfig::disconnect($temporaryCon);
        return $result;
    }

}