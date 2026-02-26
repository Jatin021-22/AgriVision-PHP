<?php
include('config.php');
include('staff\includes\header.php');
include('staff\includes\sidebar.php');
// Handle Add/Update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $news_date = $_POST['news_date'];

    // Handle file upload
    $pdf_path = "";
    if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] == 0) {
        $target_dir = "uploads/";
        $pdf_path = $target_dir . basename($_FILES["pdf_file"]["name"]);
        move_uploaded_file($_FILES["pdf_file"]["tmp_name"], $pdf_path);
    }

    // Check if we're updating or inserting a new record
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = $_POST['id'];
        // Update existing record
        $sql = "UPDATE admin_news SET title='$title', description='$description', pdf_path='$pdf_path', news_date='$news_date' WHERE id=$id";
    } else {
        // Insert new record
        $sql = "INSERT INTO admin_news (title, description, pdf_path, news_date) VALUES ('$title', '$description', '$pdf_path', '$news_date')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Record saved successfully!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle Delete request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM admin_news WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Record deleted successfully!');</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Fetch all records for display
$sql = "SELECT * FROM admin_news ORDER BY news_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin News Management</title>
   
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-4">Manage News and Documents</h1>

    <!-- Form to Add/Update News -->
    <form action="addnews.php" method="POST" enctype="multipart/form-data" class="mb-4">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" id="title" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" id="description" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="news_date">News Date</label>
            <input type="date" name="news_date" class="form-control" id="news_date" required>
        </div>
        <div class="form-group">
            <label for="pdf_file">PDF Document</label>
            <input type="file" name="pdf_file" class="form-control-file" id="pdf_file">
        </div>
        <input type="hidden" name="id" id="news-id">
        <button type="submit" class="btn btn-primary">Save</button>
    </form>

    <!-- Display Existing News Entries -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>PDF</th>
                <th>News Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['title'] . "</td>";
                    echo "<td>" . $row['description'] . "</td>";
                    echo "<td><a href='" . $row['pdf_path'] . "' target='_blank'>View PDF</a></td>";
                    echo "<td>" . $row['news_date'] . "</td>";
                    echo "<td>
                            <a href='addnews.php?edit=" . $row['id'] . "' class='btn btn-info btn-sm'>Edit</a>
                            <a href='addnews.php?delete=" . $row['id'] . "' class='btn btn-danger btn-sm'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No news available</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap and jQuery for interactivity -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Script to handle edit button click and fill the form with existing data
    function editRecord(id, title, description, news_date, pdf_path) {
        document.getElementById('news-id').value = id;
        document.getElementById('title').value = title;
        document.getElementById('description').value = description;
        document.getElementById('news_date').value = news_date;
    }
</script>
</body>
</html>
<?php $conn->close(); ?>
