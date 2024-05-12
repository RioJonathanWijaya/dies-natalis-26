<?php
require_once "../rsvp/connect.php";


$stmt = $conn->prepare("SELECT * from rsvp");
$stmt->execute();
$result = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN DIES NATALIS INFORMATIKA 26</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

    <!-- AJAX -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- DataTable BOOTSTRAP 5 -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css">
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>

    <!-- BUTTON DATATABLE -->
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>

    <!-- JQuery CONFIRM -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css" integrity="sha512-0V10q+b1Iumz67sVDL8LPFZEEavo6H/nBSyghr7mm9JEQkOAm91HNoZQRvQdjennBb/oEuW+8oZHVpIKq+d25g==" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js" integrity="sha512-zP5W8791v1A6FToy+viyoyUUyjCzx+4K8XZCKzW28AnCoepPNIXecxh9mvGuy3Rt78OzEsU+VCvcObwAMvBAww==" crossorigin="anonymous"></script>

    <style>
        body {
            background-color: rgb(236 232 232);
            background-repeat: no-repeat;
            min-height: 100vh;
            font-family: Poppins-Medium;
        }

        .mid {
            text-align: center;
        }

        .dt-buttons {
            margin-bottom: 30px;
        }

        .dataTables_length {
            margin-bottom: 1rem;
        }

        .col-sm-6,
        .col-sm-5,
        .col-sm-7 {
            margin: 10px auto !important;
        }
    </style>
</head>

<body>
    <?php include "navbar.php" ?>
    <div class="container my-5">
        <h1 class="row justify-content-center judul" style="font-weight: 800">
            RSVP
        </h1>
        <div class="row justify-content-center mt-4">
            <div class="col-md-3 col-11 selectFilter mt-2">
                <select class="form-select form-select-sm" id="selectRole" aria-label="Default select example">
                    <option selected disabled>Filter By Role...</option>
                    <option value="">All</option>
                    <option value="Mahasiswa">Mahasiswa</option>
                    <option value="Alumni">Alumni</option>
                </select>
            </div>
        </div>

    </div>

    <div class="card my-5 mx-3" style="border-radius: 1.3rem;">
        <div class="card-body table-responsive">
            <table class="table table-striped" id="tableMain" style="width: 100%!important;">
                <thead>
                    <tr class="mid">
                        <th>#</th>
                        <th>NRP</th>
                        <th>Nama</th>
                        <th>E-mail</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody id="tbodyMain">
                    <?php
                    $i = 1;
                    foreach ($result as $row) {
                        echo "
                            <tr class='mid'>
                            <td>" . $i . "</td>
                            <td>" . $row['nrp'] . "</td>
                            <td>" . $row['nama'] . "</td>
                            <td>" . $row['email'] . "</td>";
                        if ($row['role'] == 0) {
                            echo "<td>Mahasiswa</td>";
                        } else {
                            echo "<td>Alumni</td>";
                        }
                        echo "</tr>";
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var table = $('#tableMain').DataTable({
                "lengthMenu": [
                    [5, 10, 25, 50, 100, -1],
                    [5, 10, 25, 50, 100, "All"]
                ],
                "scrollX": true,
                dom: "<'d-flex text-center justify-content-center'B><'row'<'col-sm-6'l><'col-sm-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                buttons: {
                    dom: {
                        button: {
                            tag: "button",
                            className: "btn btn-dark my-2"
                        },
                        buttonLiner: {
                            tag: null
                        }
                    }
                }
            });
            Search(table);
        });
    </script>

    <script>
        function Search(table) {
            $(document).on('change', '#selectRole', function() {
                table.columns(4).search(this.value).draw();
            });
        }
    </script>

</body>

</html>