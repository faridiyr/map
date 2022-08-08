<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Simple Tables</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('asset/') ?>plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('asset/') ?>dist/css/adminlte.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url('asset/') ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url('asset/') ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url('asset/') ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <!-- google maps api -->
    <script src="http://maps.googleapis.com/maps/api/js"></script>
    <script>
        function initialize() {
            var propertiPeta = {
                center: new google.maps.LatLng(-6.210797860947629, 106.81867746527465),
                zoom: 15,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            var peta = new google.maps.Map(document.getElementById("googleMap"), propertiPeta);

            // membuat Marker

            <?php
            $no = 0;
            foreach ($location as $item) {
                $no++;
            ?>
                var marker<?= $no ?> = new google.maps.Marker({
                    position: new google.maps.LatLng(<?= $item['latitude'] ?>, <?= $item['longitude'] ?>),
                    map: peta
                });
            <?php
            }
            ?>
        }

        // event jendela di-load  
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
</head>