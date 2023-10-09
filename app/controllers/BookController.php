<?
class BookController extends Controller implements ControllerInterface{
    private BookModel $model;

    public function __construct() {
        $this->model  = $this->model('BookModel');
    }

     public function index() 
     {
        try{
            switch($_SERVER['REQUEST_METHOD']){
                case 'GET':
                    $bookData = $this->model->getBooks(1);
                    $bookListView =$this->view('book','BookView', $bookData);
                    $bookListView->render();
                    break;
            }
        }catch (Exception $e) {
            http_response_code($e->getCode());
            exit;
       }   
     }

    public function details(string $id) {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    // show the add book page
                    echo "Book Details with id: $id";
                    break;
                default:
                    throw new RequestException('Method Not Allowed', 405);
            }
        } catch (Exception $e) {
             http_response_code($e->getCode());
             exit;
        }          
    }

     // public function search(string $params) {

     // }

    public function add() 
    {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    // show the add book page
                    $addBookView = $this->view('admin', 'AddBookView');
                    $addBookView->render(); 
                    break;
                case 'POST':
                    $fileHandler = new FileHandler();
                    
                    $imageFile = $_FILES['cover']['tmp_name'];
                    
                    $audioFile = $_FILES['audio']['tmp_name'];
                    $duration = (int) $fileHandler->getAudioDuration($audioFile);

                    $uploadedAudio = $fileHandler->saveAudioTo($audioFile, $_POST['title'], AUDIOBOOK_PATH);
                    $uploadedImage = $fileHandler->saveImageTo($imageFile, $_POST['title'], BOOK_COVER_PATH);

                    $title = $_POST['title'];
                    $year = (int)$_POST['year'];
                    $summary = $_POST['summary'];
                    $price = (int)$_POST['price'];

                    $lang = 'English';
                    if (isset($_POST['lang'])) {
                        $lang = $_POST['lang'];
                    }
                    
                    $authors = $_POST['authors'];
                    $genres = $_POST['genres'];

                    
                    $bookId = $this->model->addBook(
                        $title, $year, $summary, $price, $duration, $lang,
                        $uploadedAudio, $uploadedImage, $authors, $genres
                    );
                
                    // header("Location: /public/song/detail/$bookId", true, 301);
                    exit;

                    default:
                        throw new RequestException('Method Not Allowed', 405);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            http_response_code($e->getCode());
            exit;
        }          
    }
}
?>