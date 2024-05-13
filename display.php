<?php
$db = mysqli_connect("localhost", "root", "", "wishes");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}
$getWishes = mysqli_query($db, "SELECT wish FROM wish ORDER BY created_at DESC");
if (!$getWishes) {
    echo "Error fetching wishes: " . mysqli_error($db);
    exit();
}
$wishes = [];
while ($wish = mysqli_fetch_assoc($getWishes)) {
    $wishes[] = $wish;
}
mysqli_close($db);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Wish</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/displayStyle.css">
</head>

<body>
    <div class="container">
        <h1>Your Wish</h1>
        <div class="card-container scroll">
            <?php foreach ($wishes as $wish) : ?>
                <div class="card glass">
                    <div class="body">
                        <div class="text-container scroll">
                            <p class="text"><?= $wish["wish"]; ?></p>
                        </div>
                        <div class="template">
                            <img class="logo" src="image/Logo PCU.png" alt="logo">
                            <p class="toInf">To Informatika</p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>