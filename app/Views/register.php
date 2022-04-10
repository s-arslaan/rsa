<?php $page_session = \Config\Services::session(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
    <title><?= $title; ?></title>
</head>

<body>

    <?php if ($page_session->getTempdata('success')) : ?>
        <?= '<h1>' . $page_session->getTempdata('success') . '</h1>'; ?>;
    <?php endif; ?>

    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-sm-6 col-lg-4 mt-5">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="class=" form-label">Email address</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="class=" form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mobile</label>
                        <input type="number" class="form-control" name="mobile" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>

        <!-- notification toast ,not in use -->
        <!-- <button type="button" class="btn btn-primary" id="liveToastBtn">Show live toast</button> -->
        <!--
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="me-auto">Registration</strong>
                    <small>11 mins ago</small>
                </div>
                <div class="d-flex">
                    <div class="toast-body text-white"></div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
        -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <script>
        <?php if ($page_session->getTempdata('success')) : ?>
            toastr.success(<?= "'" . $page_session->getTempdata('success') . "'"; ?>);
            <?php $page_session->removeTempdata('success'); ?>
        <?php endif; ?>

        <?php if ($page_session->getTempdata('error')) : ?>
            toastr.error(<?= "'" . $page_session->getTempdata('error') . "'"; ?>);
            <?php $page_session->removeTempdata('error'); ?>
        <?php endif; ?>

        toastr.options.timeOut = 2000;
        toastr.options.extendedTimeOut = 1000;

        /*
        $(document).ready(function() {
            <?php if ($page_session->getTempdata('success')) : ?>
                let type = 'bg-success';
                let msg = <?= "'" . $page_session->getTempdata('success') . "';"; ?>
            <?php endif; ?>

            <?php if ($page_session->getTempdata('error')) : ?>
                let type = 'bg-danger';
                let msg = <?= "'" . $page_session->getTempdata('error') . "';"; ?>
            <?php endif; ?>

            const toastDiv = document.getElementById('liveToast');

            if (typeof msg !== 'undefined' && typeof type !== 'undefined') {
                var toast = new bootstrap.Toast(toastDiv);
                toastDiv.classList.add(type);
                $(".toast-body").html(msg);
                toast.show();

                setTimeout(function() {
                    toast.hide();
                }, 2500);
            }

        });


            // show toast on an event
            var toastTrigger = document.getElementById('liveToastBtn');
            var toastDiv = document.getElementById('liveToast');
            if (toastTrigger) {
                toastTrigger.addEventListener('click', function() {
                    var toast = new bootstrap.Toast(toastDiv);

                    toast.show();
                    setTimeout(function() {
                        toast.hide();
                    }, 1500);
                });
            }
        */
    </script>

</body>

</html>