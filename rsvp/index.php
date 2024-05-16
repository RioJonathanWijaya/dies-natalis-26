<?php require "connect.php"
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

    <!-- JQuery CONFIRM -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css" integrity="sha512-0V10q+b1Iumz67sVDL8LPFZEEavo6H/nBSyghr7mm9JEQkOAm91HNoZQRvQdjennBb/oEuW+8oZHVpIKq+d25g==" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js" integrity="sha512-zP5W8791v1A6FToy+viyoyUUyjCzx+4K8XZCKzW28AnCoepPNIXecxh9mvGuy3Rt78OzEsU+VCvcObwAMvBAww==" crossorigin="anonymous"></script>

    <!-- AJAX -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <title>RSVP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;900&display=swap" rel="stylesheet">
</head>

<body>
    <div id="form">
        <h1 class="header text-center mt-3">Dies Natalis Informatika 26</h1>
        <form id="form_rsvp" method="POST">
            <div id="box1">
                <h2 class="header2">Hello, I'm a ...</h2>
                <div id="radio">
                    <div>
                        <input type="radio" name="role" id="mahasiswa" value="mahasiswa"> Student
                    </div>
                    <div>
                        <input type="radio" name="role" id="alumni" value="alumni"> Alumni
                    </div>
                </div>

            </div>
            <br>
            <div id="box2" style="display: none;">
                <div class="inputGroup nrp" style="display: none;">
                    <input type="text" id="nrp" name="nrp" >
                    <label for="nrp">NRP</label>
                </div>
                <div class="inputGroup email" style="display: none;">
                    <input type="email" id="email" name="email">
                    <label for="email">Email</label>
                </div>
                <div class="inputGroup nama" style="display: none;">
                    <input type="text" id="nama" name="nama">
                    <label for="nama">Nama</label>
                </div>
                <button id="submit" class="btn-12" type="submit" style="display: none;"><span>Submit</span></button>
            </div>
        </form>
    </div>


    <script>
        $(document).ready(function() {
            $('input[name="role"]').on('change', function() {
                var role = $(this).val();
                if (role === 'mahasiswa') {
                    $(".nrp").show();
                    $(".nama").show();
                    $(".email").hide();
                    $("#submit").show();
                    $("#email").val('');
                    $("#nama").val('');
                    $("#box2").show();


                } else if (role === 'alumni') {
                    $(".email").show();
                    $(".nama").show();
                    $(".nrp").hide();
                    $("#submit").show();
                    $("#nrp").val('');
                    $("#nama").val('');
                    $("#box2").show();

                }
            });

            $("#form_rsvp").on("submit", function(e) {
                e.preventDefault();
                var role = $('input[name="role"]:checked').val();
                var nrp = $("#nrp").val();
                var nama = $("#nama").val();
                var email = $("#email").val();
                if (role === 'mahasiswa') {
                    if (nrp === '' || nama === '') {
                        Swal.fire({
                            title: 'Error!',
                            text: 'NRP dan Nama tidak boleh kosong.',
                            icon: 'error',
                        });
                        return;
                    }
                }else {
                    if (email === '' || nama === '') {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Email dan Nama tidak boleh kosong.',
                            icon: 'error',
                        });
                        return;
                    }
                }
                $.ajax({
                    method: "POST",
                    url: "rsvp.php",
                    data: {
                        nama: nama,
                        nrp: nrp,
                        email: email,
                        role: role
                    },
                    success: (e) => {
                        if (!e.success && e.message != null) {
                            Swal.fire({
                                title: 'Error!',
                                text: e.message,
                                icon: 'error',
                            })
                        } else if (e.success && e.message != null) {
                            Swal.fire({
                                title: 'Success!',
                                text: e.message,
                                icon: 'success',
                            })
                            document.getElementById("form_rsvp").reset();
                            $(".nrp").hide();
                            $(".nama").hide();
                            $(".email").hide();
                            $("#submit").hide();
                            $("#box2").hide();

                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Silakan coba lagi',
                                icon: 'error',
                            })
                        }
                    },
                    error: function(error) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Silakan coba lagi',
                            icon: 'error',
                        })
                    }
                })
            })
        })
    </script>
</body>

</html>