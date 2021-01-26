<?php

class Book
{

    const AMOUNT_PRODUCTS_BY_DEFAULT = 6;

    public static function getBooksList()
    {
        $db = Db::getDbConnection();

        $result = $db->query("SELECT * FROM books ORDER BY id ASC");
        $booksList = array();
        $i = 0;
        while($row = $result->fetch())  {
            $booksList[$i]['id'] = $row['id'];
            $booksList[$i]['title'] = $row['title'];
            $booksList[$i]['description'] = $row['description'];
            $booksList[$i]['price'] = $row['price'];
            $booksList[$i]['author'] = $row['author'];
            $i++;
        }
        return $booksList;
    }

    public static function getBookById($id)
    {
        $db = Db::getDbConnection();

        $product = array();

        $result = $db->query("SELECT * FROM books WHERE id = ".$id);
        $result->setFetchMode(PDO::FETCH_OBJ);
        $product = $result->fetch();

        return $product;
    }

    public static function createBook($options)
    {
        $db = Db::getDbConnection();

        $sql = 'INSERT INTO books '
                . '(title, description, price, author)'
                . 'VALUES '
                . '(:title, :description, :price, :author)';

        $result = $db->prepare($sql);
        $result->bindParam(':title', $options['title'], PDO::PARAM_STR);
        $result->bindParam(':description', $options['description'], PDO::PARAM_STR);
        $result->bindParam(':price', $options['price'], PDO::PARAM_INT);
        $result->bindParam(':author', $options['author'], PDO::PARAM_STR);

        if ($result->execute()) {
            return $db->lastInsertId();
        }

        return false;
    }

    public static function deleteBookById($id)
    {
        $db = Db::getDbConnection();

        $result = $db->prepare("DELETE FROM books WHERE id =:id");
        $result->bindParam(":id", $id, PDO::PARAM_INT);

        return $result->execute();

    }

    public static function getTotalBooks()
    {
        $db = Db::getDbConnection();

        $result = $db->query("SELECT count(id) AS count FROM books WHERE status = '1'");
        $result->setFetchMode(PDO::FETCH_OBJ);
        $count = $result->fetch();

        return $count['count'];
    }

    public static function updateBookById($id, $options)
    {
        $db = Db::getDbConnection();

        $sql = "UPDATE books
            SET 
                title = :title, 
                description = :description, 
                price = :price, 
                author = :author
            WHERE id = :id";

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':title', $options['title'], PDO::PARAM_STR);
        $result->bindParam(':description', $options['description'], PDO::PARAM_STR);
        $result->bindParam(':price', $options['price'], PDO::PARAM_INT);
        $result->bindParam(':author', $options['author'], PDO::PARAM_STR);
        return $result->execute();
    }

}

?>