<?php
namespace Controller;
use Model\BookModel;
use Model\GenderModel;


class ValidateBookController{
    public array $error = [];
    protected array $input;
    protected $model;
    
    public function __construct(array $data)
    {
        $this->input = $data;
        $this->model = new BookModel();
        $this->genderModel = new GenderModel();
    }
    public function validate()
    {
        $this->Name();
        $this->Gender();
        $this->PageNr();
        $this->Price();
    }

    public function __get($property) {
        return property_exists($this, $property) ? $this->{$property} : '';
    }

    public function Name()
    {
        $input = $this->input['name'];
        if(empty($input)){
            $this->Error('name','Book Name is Required');
        }elseif (!preg_match('/^[a-zA-Z0-9,.\s]{2,100}+$/', $input)) {
            $this->Error('name', 'Book Name must be 2-30 Chars long and Alphanumeric!');
         
        } else {
            $checkBook = $this->model->getByName(trim(strtolower($input)));
            if($checkBook) {
                $this->Error('name','This Book already exists!');
            }
        }
    }
    public function Gender()
    {
        if(!is_numeric($this->input['gender']) || !$this->input['gender']){
              $this->Error('gender','Gender Required');
        }else{
            $gender = $this->genderModel->getById($this->input['gender']);
            if(!$gender){
                $this->Error('gender','Gender not exists');
            }
        }
    }
    public function PageNr()
    {
        $input =  $this->input['page_number'];
        if(empty($input)){
            $this->Error('page_number','Page number Required');
        }
        elseif ((!preg_match('/^[0-9]{2,5}$/', $input))) {

            $this->Error('page_number','Only numbers are accepted!');
        }
    }
    public function Price()
    {
        
        if ($this->input['payment'] === 'default' && !isset($this->input['price'])) {
            $this->Error('payment','Select between for free and insert amount!!');
        }else {
            if($this->input['payment'] === 'default' && isset($this->input['price'])){
                $this->Error('payment',"This is the default option! Select between for free and insert amount!");
                if (!$this->input['price']) {
                    $this->Error('payment',"You have to select a option!");
                }
            }
            
            if($this->input['payment'] === 'free'){
                $this->input['price'] = '0.00 RON';
            }else {
                $this->input['price'] = str_replace("RON","", $this->input['price']);
            }
            if ($this->input['payment'] === 'other') {
                

                if ( !$this->input['price']) {
                    $this->Error('price',"Insert  amount  or select option for free!!");
                }else {
                    if ($this->input['price'] == '0.00' ) {
                        $this->Error('price',"Insert  amount  or select option for free!!");
                    }
                    
                    $this->input['price'] = str_replace("RON","", $this->input['price']);
                    $this->input['price'] = str_replace(',', '.' ,$this->input['price']);
    
                    if (is_numeric( $this->input['price'])) {
                    $this->input['price'] = number_format($this->input['price'], 2, '.', '');
                    $this->input['price'] = $this->input['price'].' RON';
                    }else {
                        $this->Error('price',"Please don't cheat !");
                        
                    } 
                }
            }
           
            
        }
    }
    public function takeGender()
    { 
        return $this->genderModel->getAll();
    }
    public function insertBook()
    {
        if($this->model->save($this->input)) {
            $this->success = true;
            $this->errorInsert = false;
            $this->input = [];
        } else {
            $this->success = false;
            $this->errorInsert = true;
        }
    }
    
    public function Error($key, $value)
    {
        $this->error[$key] = $value;
    }

    public function oldData($input)
    {
        return isset($this->input[$input]) ? $this->input[$input] : '';
    }

    
}



?>