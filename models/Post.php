<?php

class Post
{
    //DB
    private $conn;
    private $table = "posts";

    //Properties OVDE IDU KOLONE IZ JEDNE TABELE
    //  public $id; 

    //Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //GET POSTS
    public function read()
    {
        //Create query
        $query = "SELECT c.name as category_name,p.id...";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute the query
        $stmt->execute();
        return $stmt;
    }

    //GET SINGLE POST
    public function read_single($id)
    {
        //Create query
        $query = "SELECT c.name as category_name,p.id where p .id ?..."; //? je tamo gde ide param

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //PARAMS
        $stmt->bindParam(1, $id); //prvi parametar
        // :title u QUERY a onda u bindParam 1. param je ':title'
        //PROTIV HTMLINJECTION 
        htmlspecialchars(strip_tags("bla bla"));
        //stmt->error ISPISUJE ERROR

        return $stmt;
    }
}
