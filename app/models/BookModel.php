<?
class BookModel { 
    private $db;

    public function __construct(Db $db)
    {
        $this->db = $db; 
    }

    // CRUD Operations

    public function addBook(string $title, int $year, string $summary, int $price, int $duration, string $lang, array $authors, array $genres): bool {
        $sql = "INSERT INTO book (title, year, summary, price, duration, lang) VALUES (?, ?, ?, ?, ?, ?)";
     
        $stmt = $this->db->prepare($sql);
        $this->db->bindParams($stmt, "sisiis", $title, $year, $summary, $price, $duration, $lang);

        $this->db->execute($stmt);
        $bookId = $this->db->insertId();

        $stmt->close();

        if ($bookId) {
            foreach ($authors as $authorId) {
                $this->addAuthorToBook($bookId, $authorId);
            }

            foreach ($genres as $genreName) {
                $this->addGenreToBook($bookId, $genreName);
            }

            return true;
        }

        return false;
    }

    public function updateBook(int $bookId, string $title, int $year, string $summary, int $price, int $duration, string $lang, array $authors, array $genres): bool {
        $sql = "UPDATE book SET title = ?, year = ?, summary = ?, price = ?, duration = ?, lang = ? WHERE book_id = ?";
        $stmt = $this->db->prepare($sql);
        $this->db->bindParams($stmt, "sisiisi", $title, $year, $summary, $price, $duration, $lang, $bookId);

        $result = $this->db->execute($stmt);
        $bookId = $this->db->insertId();

        $stmt->close();

        if ($result) {
            $this->removeAuthorsFromBook($bookId);
            $this->removeGenresFromBook($bookId);

            foreach ($authors as $authorId) {
                $this->addAuthorToBook($bookId, $authorId);
            }

            foreach ($genres as $genreName) {
                $this->addGenreToBook($bookId, $genreName);
            }

            return true;
        }

        return false;
    }

    public function deleteBook(int $bookId): bool {
        $this->removeAuthorsFromBook($bookId);
        $this->removeGenresFromBook($bookId);

        $sql = "DELETE FROM book WHERE book_id = ?";
        
        $stmt = $this->db->prepare($sql);
        $this->db->bindParams($stmt, "i", $bookId);

        $result = $this->db->execute($stmt);

        $stmt->close();
        return $result;
    }

    public function getBookById(int $bookId) {
        $sql = "SELECT b.*, GROUP_CONCAT(a.full_name) AS authors, GROUP_CONCAT(g.name) AS genres
                FROM book b
                JOIN authored_by ab ON b.book_id = ab.book_id
                JOIN author a ON ab.author_id = a.author_id
                JOIN book_genre bg ON b.book_id = bg.book_id
                JOIN genre g ON bg.genre_name = g.name
                WHERE b.book_id = ?
                GROUP BY b.book_id";
        
        $stmt = $this->db->prepare($sql);
        $this->db->bindParams($stmt, "i", $bookId);

        $this->db->execute($stmt);
        $book = $this->db->getSingleRecord($stmt);

        $stmt->close();
        return $book;
    }

    public function getBooks(int $page) {
        $perPage = BOOK_PER_PAGES;
        $offset = ($page - 1) * $perPage;

        $sql = "SELECT SQL_CALC_FOUND_ROWS b.*, GROUP_CONCAT(a.full_name) AS authors, GROUP_CONCAT(g.name) AS genres
                FROM book b
                JOIN authored_by ab ON b.book_id = ab.book_id
                JOIN author a ON ab.author_id = a.author_id
                JOIN book_genre bg ON b.book_id = bg.book_id
                JOIN genre g ON bg.genre_name = g.name
                GROUP BY b.book_id
                LIMIT ?, ?";
        
        $stmt = $this->db->prepare($sql);
        $this->db->bindParams($stmt, "ii", $offset, $perPage);

        $this->db->execute($stmt);
        $books = $this->db->getAllRecords($stmt);

        $stmt->close();

        return $books;
    }

    private function addAuthorToBook(int $bookId, int $authorId): bool {
        $sql = "INSERT INTO authored_by (book_id, author_id) VALUES (?, ?)";
        
        $stmt = $this->db->prepare($sql);
        $this->db->bindParams($stmt, "ii", $bookId, $authorId);

        $result = $this->db->execute($stmt);

        $stmt->close();
        return $result;
    }

    private function addGenreToBook(int $bookId, string $genreName): bool {
        $sql = "INSERT INTO book_genre (book_id, genre_name) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        $this->db->bindParams($stmt, "is", $bookId, $genreName);

        $result = $this->db->execute($stmt);

        $stmt->close();
        return $result;
    }

    private function removeAuthorsFromBook(int $bookId): bool {
        $sql = "DELETE FROM authored_by WHERE book_id = ?";
        $stmt = $this->db->prepare($sql);
        $this->db->bindParams($stmt, "i", $bookId);

        $result = $this->db->execute($stmt);

        $stmt->close();
        return $result;
    }

    private function removeGenresFromBook(int $bookId): bool {
        $sql = "DELETE FROM book_genre WHERE book_id = ?";
        $stmt = $this->db->prepare($sql);
        $this->db->bindParams($stmt, "i", $bookId);

        $result = $this->db->execute($stmt);

        $stmt->close();
        return $result;
    }
}
?>