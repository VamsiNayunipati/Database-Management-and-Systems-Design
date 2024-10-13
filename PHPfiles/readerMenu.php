<?php
session_start();

// Ensure the reader is logged in
// if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
//     echo "<p>You must be logged in to view this page.</p>";
//     exit;
// }

// Show the reader menu
function showReaderMenu() {
    echo '<h1>Reader Functions Menu</h1>
          <form action="readerMenu.php" method="post">
            <select name="action" id="actionSelect">
                <option value="">Select an action...</option>
                <option value="reserve_document">Reserve a Document</option>
                <option value="compute_fine">Compute Fine for a Document</option>
                <option value="print_reserved">List of Reserved Documents</option>
                <option value="print_by_publisher">Documents Published by a Publisher</option>
            </select>
            <button type="button" onclick="submitForm()">Submit</button>
          </form>
          <script>
              function submitForm() {
                  var action = document.getElementById(\'actionSelect\').value;
                  if(action != "") {
                      document.querySelector(\'form\').submit();
                  }
              }
          </script>';
}

showReaderMenu();

// Handling form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'reserve_document':
            showReserveForm();
            processReserveDocument();
            break;
        case 'compute_fine':
            showComputeFineForm();
            processComputeFine();
            break;
        case 'print_reserved':
            showReservedDocumentsForm();
            processPrintReserved();
            break;
        case 'print_by_publisher':
            showPrintByPublisherForm();
            processPrintByPublisher();
            break;
    }
}

// Form and processing functions for each action
function showReserveForm() {
    echo '<h2>Reserve a Document</h2>
          <form action="readerMenu.php" method="post">
              Document ID: <input type="text" name="docid" required>
              <input type="submit" value="Reserve">
          </form>';
}

function processReserveDocument() {
    if (!empty($_POST['docid'])) {
        echo "Reserving document ID: " . htmlspecialchars($_POST['docid']);
    }
}

function showComputeFineForm() {
    echo '<h2>Compute Fine for a Document</h2>
          <form action="readerMenu.php" method="post">
              Document ID: <input type="text" name="docid" required>
              <input type="submit" value="Compute Fine">
          </form>';
}

function processComputeFine() {
    if (!empty($_POST['docid'])) {
        echo "Computing fine for document ID: " . htmlspecialchars($_POST['docid']);
    }
}

function showReservedDocumentsForm() {
    echo '<h2>List of Reserved Documents</h2>
          <form action="readerMenu.php" method="post">
              <input type="submit" value="Show Reserved Documents">
          </form>';
}

function processPrintReserved() {
    echo "Displaying reserved documents...";
}

function showPrintByPublisherForm() {
    echo '<h2>Documents Published by a Publisher</h2>
          <form action="readerMenu.php" method="post">
              Publisher Name: <input type="text" name="publisher" required>
              <input type="submit" value="Show Documents">
          </form>';
}

function processPrintByPublisher() {
    if (!empty($_POST['publisher'])) {
        echo "Listing documents for publisher: " . htmlspecialchars($_POST['publisher']);
    }
}
?>
