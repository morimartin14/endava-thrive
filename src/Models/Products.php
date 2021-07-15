<?php

namespace Models;
include "../Helpers/DatabaseConfig.php";
use Helpers\DatabaseConfig;
use function Controllers\generateRandomString;

class Products {
    private $id, $name, $description, $price;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getItem(): array
    {
        return get_object_vars($this);
    }

    public function __construct($name, $description, $price) {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
    }

    public function setId($id) {
        $this->id = $id;
    }
    public function getId() {
       return $this->id;
    }

    public function save() {
        $con = DatabaseConfig::connect();
        $query = $con->prepare("INSERT INTO product (name, description, price) VALUES (?,?,?)");
        $query->bind_param("ssd", $this->name, $this->description, $this->price);
        $query->execute();
        $this->setId(mysqli_insert_id($con));
        DatabaseConfig::disconnect($con);
        return $this;
    }

    static public function getById($id) {
        $con = DatabaseConfig::connect();
        $name = false;
        $description = false;
        $price = false;
        $product = false;

        $query = $con->prepare("SELECT * FROM product where id = ?");
        $query->bind_param("i", $id);
        $query->execute();

        $query->bind_result($id, $name, $description, $price);

        $query->fetch();

        if ($name) {
            $product = new Products($name, $description, $price);
            $product->setId($id);
        }
        DatabaseConfig::disconnect($con);
        return $product;
    }

    static public function getAll($currentPage) {
        $con = DatabaseConfig::connect();
        $queryTotal = $con->query("SELECT count(*) FROM product")->fetch_array();
        $itemsPerPage = 9;
        $productsArray = [];

        if ( $queryTotal[0] ) {
            $total = $queryTotal[0];
            $pages = ceil($total / $itemsPerPage);
            $offset = ($currentPage - 1)  * $itemsPerPage;

            // Some information to display to the user
            $start = $offset + 1;
            $end = min(($offset + $itemsPerPage), $total);

            $query = $con->prepare("SELECT * FROM product LIMIT ? OFFSET ?");
            $query->bind_param("ii", $itemsPerPage, $offset);
            $query->execute();
            $query->bind_result($id, $name, $description, $price);

            if ($query) {
                while ($query->fetch()) {
                    $product = new Products($name, $description, $price);
                    $product->setId($id);
                    $productsArray[] = $product;
                }
            }
        }


        DatabaseConfig::disconnect($con);
        $previousPage = $currentPage > 0 ? $currentPage - 1 : false;
        $nextPage = $pages != $currentPage ? $currentPage + 1 : false;

        return ['products' => $productsArray, 'total' => $queryTotal, 'start' => $start, 'end' => $end, 'previousPage' => $previousPage, 'nextPage' => $nextPage];
    }
}
