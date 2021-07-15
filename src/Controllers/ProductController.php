<?php
namespace Controllers;
use Models\Products;
use Models\RecentlyViewedProduct;

include "../Models/Products.php";
include "../Models/RecentlyViewedProduct.php";

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'getProducts':
        $currentPage = $_GET['currentPage'] ?? 1;
        $pagination = Products::getAll($currentPage);
        return require_once '../Views/ProductsView.php';
        break;
    case 'getById':
        $pid = $_GET['pid'] ?? '0';
        echo json_encode(Products::getById($pid));
        break;
    case 'viewMore':
        $pid = $_GET['pid'] ?? '0';
        $uid = 14; //logued user id;
        $product = Products::getById($pid);
        $recentlyViewedProduct = new RecentlyViewedProduct($pid, $uid);
        $recentlyViewedProduct->save();
        return require_once '../Views/SingleProductView.php';
        break;
    case 'getRecentlyViewed':
        $uid = 14; //logued user id;;
        $products = RecentlyViewedProduct::getByUser($uid);
        return require_once '../Views/RecentlyViewedProductView.php';
        break;
    case 'save':
        $name = $_GET['name'] ?? generateRandomString(10);
        $desc = $_GET['desc'] ?? generateRandomString(10) . ' ' . generateRandomString(15) . ' ' . generateRandomString(8);
        $price = $_GET['price'] ?? rand(0, 10);
        $newProduct = new Products($name, $desc, $price);
        $newProduct->save();
        header("Location: ../../index.php");
        break;
    case 'removeRecentlyViewedForUser':
        $pid = $_GET['pid'] ?? '0';
        $uid = 14; //logued user id;
        $newProduct = new RecentlyViewedProduct($pid, $uid);
        $result = $newProduct->remove();
        //TODO in general, improve error handling
        header("Location: ProductController.php?action=getRecentlyViewed&uid=14");
        break;
    case 'add100Products':
        for($i = 0; $i <= 99; $i ++) {
            $name = generateRandomString(10);
            $desc = generateRandomString(10) . ' ' . generateRandomString(15) . ' ' . generateRandomString(8);
            $price = rand(0, 100);
            $newProduct = new Products($name, $desc, $price);
            $newProduct->save();
        }
        header("Location: ../../index.php");
        break;
   case 'add100RecentlyViewedProducts':
       //I'm setting this limit because i want to add products to the Recently Viewed Product table with at least 1 sec of difference
       //So, this process can take a while
       set_time_limit(300);
       for($i = 0; $i <= 99; $i ++) {
           $name = generateRandomString(10);
           $desc = generateRandomString(10) . ' ' . generateRandomString(15) . ' ' . generateRandomString(8);
           $price = rand(0, 100);
           $newProduct = new Products($name, $desc, $price);
           $newProduct = $newProduct->save();
           $now = date('Y-m-d H:i:s');
           while ($now == date('Y-m-d H:i:s')) {
               //waiting 1 sec
           }
           $recentlyViewedProduct = new RecentlyViewedProduct($newProduct->getId(), 14, $now);
           $recentlyViewedProduct->save();
       }
       header("Location: ../../index.php");
       break;
}


function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}