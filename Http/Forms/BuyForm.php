<?php

namespace Http\Forms;

use Core\App;
use Core\Database;
use Core\Validator;

class BuyForm
{
    protected $errors = [];
    protected $conn;
    public function __construct()
    {
        $this->conn = $this->getConnection();
    }

    public function getConnection()
    {
        return App::resolve(Database::class);
    }

    public function validate($quantity)
    {

        if(Validator::string($quantity)){
            $this->errors['quantity'] = 'Quantity is required';
        }

        if(Validator::number($quantity)){
            $this->errors['quantity'] = 'Quantity must be a number';
        }

        if(Validator::min_quantity($quantity, 1)){
            $this->errors['quantity'] = 'Quantity must be greater than 0';
        }

        if(Validator::max_quantity($quantity, 999)){
            $this->errors['quantity'] = 'Quantity must be less than 1000';
        }

        

        return $this->errors;
    }


    public function product($id)
    {
        return $this->conn->find('products', $id);
    }

    public function store($id)
    {
        return $this->conn->find('stores', $id);
    }

    public function checkQuantity($quantity, $limit)
    {
        if($quantity > $limit){
            $this->errors['quantity'] = 'Quantity exceeds the limit';
        }
        return $this->errors;
    }

    



}