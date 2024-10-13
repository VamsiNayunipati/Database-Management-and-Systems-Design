<?php
session_start();
include 'db.php';
// Simple authentication for demonstration purposes
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        if ($username === 'admin' && $password === 'admin') {
            $_SESSION['loggedin'] = true;
            header('Location: adminMenu.php');  // Redirect to avoid form resubmission issues
            exit;
        } else {
            echo "<p>Invalid username or password</p>";
            showLoginForm();
            exit;
        }
    } else {
        showLoginForm();
        exit;
    }
}

function showLoginForm() {
    echo '<form action="adminMenu.php" method="post">
            Username: <input type="text" name="username"><br>
            Password: <input type="password" name="password"><br>
            <input type="submit" value="Login">
          </form>';
}

// Log out mechanism
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php"); // redirect to the login page
}

function showAdminMenu() {
    echo '<h1>Administrative Functions Menu</h1>
          <form action="adminMenu.php" method="post">
            <select name="action" id="actionSelect">
                <option value="">Select an action...</option>
                <option value="add_document">Add a Document Copy</option>
                <option value="search_document">Search Document Copy</option>
                <option value="add_reader">Add New Reader</option>
                <option value="print_branch">Print Branch Information</option>
                <option value="reader_borrow_branch">Frequent Borrowers in Branch</option>
                <option value="reader_borrow_library">Frequent Borrowers in the Library</option>
                <option value="book_borrow_branch">Borrowed Books in Branch</option>
                <option value="book_borrow_library">Borrowed Books in the Library</option>
                <option value="popular_year">10 Most Popular Books</option>
            </select>
            <button type="button" onclick="submitForm()">Submit</button>
          </form>
          <script>
              function submitForm() {
                  var action = document.getElementById(\'actionSelect\').value;
                  if (action) {
                      document.querySelector(\'form\').submit();
                  } else {
                      alert(\'Please select an action.\');
                  }
              }
          </script>
          <form action="adminMenu.php" method="post">
            <input type="hidden" name="logout" value="1">
            <input type="submit" value="Logout">
          </form>';
}


// Display the menu after login
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    showAdminMenu();
}

// Handle form actions
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    handleAdminAction($_POST['action']);
}

function handleAdminAction($action) {
    switch ($action) {
        case 'add_document':
            if (!empty($_POST['docid'])) {  // Validate that docid is not empty
                processAddDocument();
            } else {
                showAddDocumentForm();
            }
            break;
        case 'search_document':
            if (!empty($_POST['docid'])) {
                processSearchDocument();
            } else {
                showSearchDocumentForm();
            }
            break;
        case 'add_reader':
            if (!empty($_POST['rtype'])) {
                processAddReader();
            } else {
                showAddReaderForm();
            }
            break;
        case 'reader_borrow_branch':
            if (!empty($_POST['branch'])) {
                processBorrowerBranch();
            } else {
                showPrintTopNBorrowersForm();
            }
            break;
        case 'reader_borrow_library':
            if (!empty($_POST['num'])) {
                processBorrowerLibrary();
            } else {
                showPrintTopNBorrowersLibraryForm();
            }
            break;
        case 'book_borrow_branch':
            if (!empty($_POST['branch'])) {
                processBookBranch();
            } else {
                showPrintTopNBorrowedBooksBranchForm();
            }
            break;
        case 'book_borrow_library':
            if (!empty($_POST['num'])) {
                processBookLibrary();
            } else {
                showPrintTopNBorrowedBooksLibraryForm();
            }
            break;
        case 'popular_year':
            if (!empty($_POST['year'])) {
                processPopluar();
            } else {
                showPrintTopBooksOfYearForm();
            }
            break;
        case 'print_branch':
            processPrintBranch();
            break;
    }
}

function processAddDocument() {
    // Add logic to process adding a document copy
    echo "Processing add document...";
    $documentData = [
        'title'        => $_POST['title'],
        'pdate'        => $_POST['pdate'],
        'publisherId'  => $_POST['publisherId']
    ];
    
    header('Location: adminMenu.php');
    exit;
}
function processBorrowerBranch() {
    // Add logic to process adding a document copy
    echo "Processing add document...";
    $borrowerBranchData = [
        'num'        => $_POST['num'],
        'branch'        => $_POST['branch'],
    ];
    header('Location: adminMenu.php');
    exit;
}
function processBorrowerLibrary() {
    // Add logic to process adding a document copy
    echo "Processing add document...";
    $borrowerLibraryData = [
        'num'        => $_POST['num']
    ];
    header('Location: adminMenu.php');
    exit;
}
function processBookBranch() {
    // Add logic to process adding a document copy
    echo "Processing add document...";
    $bookBranchData = [
        'num'        => $_POST['num'],
        'branch'        => $_POST['branch'],
    ];
    header('Location: adminMenu.php');
    exit;
}
function processBookLibrary() {
    // Add logic to process adding a document copy
    echo "Processing add document...";
    $bookLibraryData = [
        'num'        => $_POST['num']
    ];
    header('Location: adminMenu.php');
    exit;
}
function processPopluar() {
    // Add logic to process adding a document copy
    echo "Processing add document...";
    $year = [
        'year'        => $_POST['year']
    ];
    header('Location: adminMenu.php');
    exit;
}
function processSearchDocument() {
    // Add logic to process searching a document copy
    echo "Processing search document...";
    $docidData = [
        'docid'        => $_POST['docid']
    ];
    header('Location: adminMenu.php');
    exit;
}

function processAddReader() {
    // Add logic to process adding a new reader
    echo "Processing add reader...";

    // Extract form data
    $readerData = [
        'rtype'     => $_POST['rtype'],
        'rname'     => $_POST['rname'],
        'raddress'  => $_POST['raddress'],
        'phone_no'  => $_POST['phone_no']
    ];

    // Call insertReader function to insert the data into the database
    if (insertReader($readerData)) {
        echo "<p>Reader added successfully.</p>";
       // header('Location: adminMenu.php');
        exit;
    } else {
        echo "<p>Failed to add reader.</p>";
    }
}


function processPrintBranch() {
    // Add logic to print branch information
    echo "Processing print branch information...";
    $branchIdData = [
        'branchId'        => $_POST['branchId']
    ];
    header('Location: adminMenu.php');
    exit;
}

function showAddDocumentForm() {
    echo '<h2>Add a Document Copy</h2>
          <form action="adminMenu.php" method="post">
              <input type="hidden" name="action" value="add_document">
              Document ID: <input type="text" name="docid" required><br>
              Copy Number: <input type="text" name="copyno" required><br>
              Branch ID: <input type="text" name="bid" required><br>
              Position: <input type="text" name="position" required><br>
              <input type="submit" value="Add Copy">
          </form>';
}

function showSearchDocumentForm() {
    echo '<h2>Search Document Copy and Check Its Status</h2>
          <form action="adminMenu.php" method="post">
              <input type="hidden" name="action" value="search_document">
              Document ID: <input type="text" name="docid" required><br>
              <input type="submit" value="Search">
          </form>';
}

function showAddReaderForm() {
    echo '<h2>Add New Reader</h2>
          <form action="adminMenu.php" method="post">
              <input type="hidden" name="action" value="add_reader">
              Reader Type: <input type="text" name="rtype" required><br>
              Name: <input type="text" name="rname" required><br>
              Address: <input type="text" name="raddress" required><br>
              Phone No: <input type="text" name="phone_no" required><br>
              <input type="submit" value="Add Reader">
          </form>';
}

function showPrintBranchForm() {
    echo '<h2>Print Branch Information</h2>
          <form action="adminMenu.php" method="post">
              <input type="hidden" name="action" value="print_branch">
              Branch ID: <input type="text" name="branchId" required><br>
              <input type="submit" value="Print Branch Info">
          </form>';
}
function showPrintTopNBorrowersForm() {
    echo '<h2>Print Top N Borrowers</h2>
          <form action="adminMenu.php.php" method="post">
              <label for="num">Number of Borrowers (N):</label>
              <input type="number" id="num" name="num" required>
              <label for="branch">Branch Number (I):</label>
              <input type="number" id="branch" name="branch" required>
              <input type="submit" value="Print Top Borrowers">
          </form>';
}

function showPrintTopNBorrowersLibraryForm() {
    echo '<h2>Print Top N Borrowers in the Library</h2>
          <form action="adminMenu.php" method="post">
              <label for="num">Number of Borrowers (N):</label>
              <input type="number" id="num" name="num" required>
              <input type="submit" value="Print Top Borrowers">
          </form>';
}

function showPrintTopNBorrowedBooksBranchForm() {
    echo '<h2>Print Top N Borrowed Books in Branch</h2>
          <form action="adminMenu.php" method="post">
              <label for="num">Number of Books (N):</label>
              <input type="number" id="num" name="num" required>
              <label for="branch">Branch Number (I):</label>
              <input type="number" id="branch" name="branch" required>
              <input type="submit" value="Print Top Borrowed Books">
          </form>';
}

function showPrintTopNBorrowedBooksLibraryForm() {
    echo '<h2>Print Top N Borrowed Books in the Library</h2>
          <form action="adminMenu.php" method="post">
              <label for="num">Number of Books (N):</label>
              <input type="number" id="num" name="num" required>
              <input type="submit" value="Print Top Borrowed Books">
          </form>';
}

function showPrintTopBooksOfYearForm() {
    echo '<h2>Print Top 10 Books of a Year</h2>
          <form action="adminMenu.php" method="post">
              <label for="year">Year:</label>
              <input type="number" id="year" name="year" required>
              <input type="submit" value="Print Top Books">
          </form>';
}
?>
