    <?php if (!isset($_SESSION['auth'])) { ?>

        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm p-2">

        <?php } else { ?>

            <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm p-2">


            <?php } ?>


            <div class="container">
                <a class="navbar-brand" href="../login">

                    <?php if (!isset($_SESSION['auth'])) { ?>
                        <img src="../assets/images/logo3.png" alt="" width="50" height="50" class="mr-3">
                    <?php } ?>
                    <?php echo APP_NAME; ?>

                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>


                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">

                    </ul>
                    <ul class="navbar-nav ml-auto">
                        <?php if (!isset($_SESSION['auth'])) { ?>
                        <?php } else { ?>

                            <div class="dropdown">
                                <button class="btn btn-dark dropdown-toggle" type="button" id="imgdropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img class="navbar-img" src="../assets/uploads/users/<?php echo $_SESSION['profile_image'] ?>">
                                    <span class="caret"></span>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="imgdropdown">
                                    <a class="dropdown-item text-muted" href="../profile"><i class="fa fa-user pr-2"></i> Profile</a>
                                    <a class="dropdown-item text-muted" href="../profile-edit"><i class="fa fa-pencil-alt pr-2"></i> Edit Profile</a>
                                    <a class="dropdown-item text-muted" href="../logout"><i class="fa fa-running pr-2"></i> Logout</a>
                                </div>
                            </div>

                        <?php } ?>





                    </ul>
                </div>
            </div>
            </nav>