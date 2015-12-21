<?php

/**
 * Singleton
 */
final class Product
{

    /**
     * @var self
     */
    private static $instance;

    /**
     * @var mixed
     */
    public $a;

    /**
     * აბრუნებს თავისი თავის ეგზემპლარს
     *
     * @return self
     */
    public static function getInstance()
    {
        if (!(self::$instance instanceof self))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * დახურული კოსტრუქტორი
     */
    private function __construct()
    {
        
    }

    /**
     * კლონირება აკრძალულია
     */
    private function __clone()
    {
        
    }

    /**
     * სერიალიზაცია აკრძალულია
     */
    private function __sleep()
    {
        
    }

    /**
     * დესერიალიზაცია აკრძალულია
     */
    private function __wakeup()
    {
        
    }

}

/*
 * =====================================
 *        Singelton ის გამოყენება
 * =====================================
 */

$firstProduct = Product::getInstance();
$secondProduct = Product::getInstance();

$firstProduct->a = 1;
$secondProduct->a = 2;

print_r($firstProduct->a);
// 2
print_r($secondProduct->a);
// 2