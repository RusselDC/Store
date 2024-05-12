<?php
namespace Http\Forms;
use Core\Validator;

class ProductForm
{
    protected $errors = [];
    protected $extensions = ['jpg', 'jpeg', 'png', 'webp'];

    public function validate($name, $description, $qty, $price)
    {
        if(Validator::string($name))
        {
            $this->errors['name'] = "PLEASE PROVIDE A NAME";
        }

        if(Validator::string($description))
        {
            $this->errors['description'] = "PLEASE PROVIDE A DESCRIPTION";
        }

        if(Validator::string($qty))
        {
            $this->errors['quantity'] = "PLEASE PROVIDE A QUANTITY";
        }

        if(Validator::string($price))
        {
            $this->errors['price'] = "PLEASE PROVIDE A PRICE";
        }

        if(Validator::number($price))
        {
            $this->errors['price'] = "PLEASE PROVIDE A VALID PRICE";
        }

        if(Validator::number($qty))
        {
            $this->errors['quantity'] = "PLEASE PROVIDE A VALID QUANTITY";
        }

        return $this->errors;
    }

    public function validatImage($ext)
    {
        
        
        if(!in_array($ext, $this->extensions))
        {
            $this->errors['image'] = "INVALID FILE TYPE";
        }

        return $this->errors;
    }
}
