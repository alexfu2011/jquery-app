<?php
class BookController {

    function index_action($id = null) {
        header('Content-Type: application/json');
        if ($id) {
            $book = Book::getBookById($id);
            echo json_encode(array('data' => $book));
        } else {
            $books = Book::getBooksList();
            echo json_encode(array('data' => $books));
        }
    }

    function create_action() {
        if (isset($_POST['title'])) {
            header('Content-Type: application/json');
            $book = array();
            $book['title'] = $_POST['title'];
            $book['description'] = $_POST['description'];
            $book['price'] = $_POST['price'];
            $book['author'] = $_POST['author'];

            $id = Book::createBook($book);

            if ($id !== false) {
                $data = array();
                $data['id'] = $id;
                echo json_encode(array('data' => $data));
            } else {
                echo json_encode(array('error' => 'ERROR'));
            }
        }
    }

    function update_action($id)
    {
        if (isset($_POST['title'])) {
            $book = array();
            $book['title'] = $_POST['title'];
            $book['description'] = $_POST['description'];
            $book['price'] = $_POST['price'];
            $book['author'] = $_POST['author'];

            if(Book::updateBookById($id, $book))  {
                echo json_encode(array('data' => $book));
            } else {
                echo json_encode(array('error' => 'ERROR'));
            }
        }
    }

    public function delete_action($id)
    {
        header('Content-Type: application/json');
        if(Book::deleteBookById($id))  {
            echo json_encode(array('success' => 'success'));
        } else {
            echo json_encode(array('error' => 'ERROR'));
        }
    }

}
