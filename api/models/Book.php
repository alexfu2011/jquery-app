<?php

class Book
{

    function createBook($data)
    {
        $db = DB::getDbConnection();

        $sql = 'INSERT INTO books '
            . '(title, description, price, author)'
            . 'VALUES '
            . '(:title, :description, :price, :author)';

        $result = $db->prepare($sql);
        $result->bindParam(':title', $data['title'], PDO::PARAM_STR);
        $result->bindParam(':description', $data['description'], PDO::PARAM_STR);
        $result->bindParam(':price', $data['price'], PDO::PARAM_INT);
        $result->bindParam(':author', $data['author'], PDO::PARAM_STR);

        if ($result->execute()) {
            return $db->lastInsertId();
        }

        return false;
    }

    function deleteBookById($id)
    {
        $db = DB::getDbConnection();

        $result = $db->prepare("DELETE FROM books WHERE id =:id");
        $result->bindParam(":id", $id, PDO::PARAM_INT);

        return $result->execute();
    }

    function updateBookById($id, $data)
    {
        $db = DB::getDbConnection();

        $sql = "UPDATE books
            SET 
                title = :title, 
                description = :description, 
                price = :price, 
                author = :author
            WHERE id = :id";

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':title', $data['title'], PDO::PARAM_STR);
        $result->bindParam(':description', $data['description'], PDO::PARAM_STR);
        $result->bindParam(':price', $data['price'], PDO::PARAM_INT);
        $result->bindParam(':author', $data['author'], PDO::PARAM_STR);
        return $result->execute();
    }

    function getBooksList()
    {
        $db = DB::getDbConnection();

        $result = $db->query("SELECT * FROM books ORDER BY id ASC");
        $booksList = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $booksList[$i]['id'] = $row['id'];
            $booksList[$i]['title'] = $row['title'];
            $booksList[$i]['description'] = $row['description'];
            $booksList[$i]['price'] = $row['price'];
            $booksList[$i]['author'] = $row['author'];
            $i++;
        }
        return $booksList;
    }

    function getBookById($id)
    {
        $db = DB::getDbConnection();

        $product = array();

        $result = $db->query("SELECT * FROM books WHERE id = " . $id);
        $result->setFetchMode(PDO::FETCH_OBJ);
        $product = $result->fetch();

        return $product;
    }
}
