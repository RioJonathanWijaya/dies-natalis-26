<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    if (!preg_match("/^[a-zA-Z0-9 .]*$/", $_POST['wish'])) {
        $invalidInput = true;
    } elseif (empty($_POST['wish'])) {
        $isempty = true;
    } else {
        $wish = htmlspecialchars($_POST['wish']);
        $db = mysqli_connect("localhost", "root", "",  "wishes");
        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }
        $sql = "INSERT INTO wish (id, wish, created_at, updated_at) VALUES (UUID(), ?, NOW(), NOW())";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("s", $wish);
        if ($stmt->execute() === TRUE) {
            $invalidInput = false;
        } else {
            echo "Error: " . $sql . "<br>" . $db->error;
        }
        $stmt->close();
        $db->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/inputStyle.css">
    <script defer src="script.js"></script>
</head>

<body>

    <img src="image/cityBetter.png" alt="">
    <div class="spinner-container">
        <div class="spinner">
            <div class="sun">
                <div class="center"></div>
                <div class="ray r-1"></div>
                <div class="ray r-2"></div>
                <div class="ray r-3"></div>
                <div class="ray r-4"></div>
                <div class="ray r-5"></div>
                <div class="ray r-6"></div>
                <div class="ray r-7"></div>
                <div class="ray r-8"></div>
            </div>
            <div class="moon">
                <div class="centerM">
                    <div class="details"></div>
                    <div class="details one"></div>
                    <div class="details two"></div>
                    <div class="details three"></div>
                    <div class="details four small"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="input">
            <form method="POST">
                <div class="wish">
                    <label for="wish">YOUR WISH</label>
                    <textarea rows="5" placeholder="Type your wish here" name="wish" required></textarea>
                </div>
                <input class="submit" type="submit" name="submit" value="Send my wish">
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
    <?php if (isset($invalidInput) && $invalidInput) : ?>
        <script type="text/javascript">
            Swal.fire({
                title: "Error",
                text: "Invalid input. Only letters, numbers, spaces, and '.' are allowed.",
                icon: "error",
                confirmButtonText: "OK"
            });
        </script>
    <?php elseif (isset($invalidInput) && !$invalidInput) : ?>
        <script type="text/javascript">
            Swal.fire({
                title: "Success",
                text: "Your wish has been recorded",
                icon: "success",
                confirmButtonText: "OK"
            });
        </script>
    <?php endif; ?>
</body>

</html>