<?php

namespace Http\Forms;
use Core\App;
use Core\Database;
use Core\Validator;

class RestockForm
{
    protected $error = [];

    public function getConnection()
    {
        return App::resolve(Database::class);
    }


    public function validate($quantity, $date)
    {

        if(Validator::string($quantity)){
            $this->error['quantity'] = 'Quantity is required';
        }

        if(Validator::number($quantity)){
            $this->error['quantity'] = 'Quantity must be a number';
        }

        if(Validator::min_quantity($quantity, 1)){
            $this->error['quantity'] = 'Quantity must be greater than 0';
        }

        if(Validator::max_quantity($quantity, 999)){
            $this->error['quantity'] = 'Quantity must be less than 1000';
        }

        if(Validator::string($date)){
            $this->error['date'] = 'Date is required';
        }

        if(Validator::date($date))
        {
            $this->error['date'] = 'Invalid date format';
        }

        return $this->error;


    }

    public function checkProduct($id)
    {
        $conn = $this->getConnection();

        $id = $conn->find('products', $id);

        if(!$id){
            $this->error['id'] = 'Product not found';
        }
        return $this->error;
    }
}