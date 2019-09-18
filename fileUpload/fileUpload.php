<?php 
session_start();
if(!isset($_SESSION["admin"])){ header("Location: ../");exit();}
?>

<!DOCTYPE html>
<html>

<head>
    <title>File Upload | Amadeus</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script type="text/javascript">
        (function(e, t, n) {
            var r = e.querySelectorAll("html")[0];
            r.className = r.className.replace(/(^|\s)no-js(\s|$)/, "$1js$2")
        })(document, window, 0);

    </script>

    <link rel="stylesheet" t*ype="text/css" href="fileUpload.css">
    <script src="../xlsx.full.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="fileUpload.js"></script>
    <link rel="icon" href="../img/favicon.ico" type="image/icon type">

</head>

<body>
    <div class="loader loaderOpaco"></div>
    <div class="loader loaderTrans"></div>
    <div class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container d-flex justify-content-between">
            <a href="#" class="navbar-brand d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="250" viewBox="0 0 188 25" id="amadeus_logo">
                    <path fill="white" d="M99.38 0a33.755 33.755 0 0 0-9.896 1.458V24.27a53.832 53.832 0 0 0 8.994.73c9.583 0 13.3-3.75 13.3-12.673C111.777 4.617 107.053 0 99.38 0zm-4.514 4.653a23.775 23.775 0 0 1 4.27-.417c3.89 0 6.946 2.188 6.946 8.09 0 5.73-1.494 8.438-7.43 8.438a29.523 29.523 0 0 1-3.786-.278zm75.182 19.48a34.938 34.938 0 0 0 7.986.867c4.41 0 9.966-1.493 9.966-7.465 0-3.89-2.882-5.556-7.57-7.257-2.535-.938-4.688-1.77-4.688-3.507 0-.832.626-2.464 3.855-2.464a17.295 17.295 0 0 1 6.11 1.388l1.356-3.992A18.557 18.557 0 0 0 179.11 0c-4.444 0-8.784 2.36-8.784 7.118 0 4.896 4.444 6.39 7.916 7.535 2.362.8 4.34 1.632 4.34 3.194 0 1.527-.832 2.848-4.825 2.848a38.042 38.042 0 0 1-6.737-.73zm-11.74-5.59a16.87 16.87 0 0 1-6.598 1.665c-3.682 0-4.307-1.666-4.307-5.486V.208h-.798a38.685 38.685 0 0 0-4.584.348v14.86c0 6.494 1.6 9.584 8.196 9.584a17.803 17.803 0 0 0 8.194-1.944 11.37 11.37 0 0 0 5.28 1.076V.556a41.953 41.953 0 0 0-4.307-.348h-1.076zM73.127 0a24.654 24.654 0 0 0-10 1.91l1.147 4.028a24.948 24.948 0 0 1 7.292-1.32c3.09 0 4.687.868 4.687 3.923v1.738h-4.688c-7.95 0-10.313 3.646-10.313 7.674 0 5.346 4.167 7.048 7.953 7.048a16.11 16.11 0 0 0 7.29-1.84c.245 0 1.147.972 5.175.972V7.118C81.67 2.014 78.51 0 73.13 0zm3.196 19.41a19.48 19.48 0 0 1-5.972 1.354c-2.223 0-3.89-.764-3.89-3.194 0-2.118 1.146-3.333 4.202-3.438l5.66-.208zM11.876 0a24.657 24.657 0 0 0-10 1.91L3.02 5.938a24.948 24.948 0 0 1 7.293-1.32c3.09 0 4.688.868 4.688 3.923v1.738h-4.687C2.363 10.278 0 13.924 0 17.952 0 23.298 4.167 25 7.952 25a16.11 16.11 0 0 0 7.292-1.84c.244 0 1.146.972 5.174.972V7.118c0-5.104-3.16-7.118-8.542-7.118zm3.195 19.41A19.482 19.482 0 0 1 9.1 20.764c-2.222 0-3.89-.764-3.89-3.194 0-2.118 1.146-3.333 4.203-3.438l5.66-.208zm26.946-5.035c-.14.348-.312 1.007-.416 1.39-.104-.382-.278-1.042-.416-1.39L36.46 2.257C35.662.244 34.412 0 32.12 0c-.798 0-2.43.104-2.43.104l-2.43 24.55h5.382l1.18-16.46 5.104 12.466c.382.972 1.146 1.354 2.674 1.354s2.292-.382 2.673-1.354l5.105-12.465 1.18 16.458h5.382L53.51.103S51.878 0 51.08 0c-2.292 0-3.542.244-4.34 2.257zm76.185 9.48A39.05 39.05 0 0 0 127.61 25a39.575 39.575 0 0 0 8.23-.625v-4.167a38.39 38.39 0 0 1-6.736.556 29.35 29.35 0 0 1-5.556-.452V14.41h10.66v-4.167h-10.66V4.618a31.862 31.862 0 0 1 5.21-.382 43.425 43.425 0 0 1 6.666.556V.59A38.657 38.657 0 0 0 128.13 0a41.198 41.198 0 0 0-9.93 1.077z"></path>
                </svg>
            </a>
            <form class="form-inline my-2 my-lg-0">
                <a style="color:white"><?php echo $_SESSION["name"]; ?> &nbsp;&nbsp;</a>
                <button class="btn btn-outline-danger my-2 my-sm-0 sessionDestroy" type="button">Log Out</button>
            </form>
        </div>

    </div>
    <div>

    </div>
    <section class=" jumbotron text-center base">
        <div class="container">
            <h1 class="jumbotron-heading">Upload files</h1>
            <p class="lead text-muted">Select your files and upload them.</p>
            <div class="album py-4">
                <div class="container py-4 bg-light rounded box">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card mb shadow-sm">
                                <text class="title">Accounts</text>
                                <form method="post" action="#" id="#">
                                    <div class="form-group files color">
                                        <input id="accounts" type="file" title="Accounts" class="form-control" />
                                    </div>
                                </form>
                            </div>
                            <button id="btnClearAccounts" class="btn btn-outline-danger my-3" onclick="clearFile('accounts')"> Clear Accounts</button>
                        </div>
                        <div class="col-lg-4">
                            <div class="card mb shadow-sm">
                                <text class="title">Office</text>
                                <form method="post" action="#" id="#">
                                    <div class="form-group files color">
                                        <input id="office" type="file" title="Office" class="form-control" />
                                    </div>
                                </form>
                            </div>
                            <button id="btnClearBookings" class="btn btn-outline-danger my-3" onclick="clearFile('office')"> Clear Office</button>
                        </div>
                        <div class="col-lg-4">
                            <div class="card mb-3 shadow-sm">
                                <text class="title">Bookings</text>
                                <form method="post" action="#" id="#">
                                    <div class="form-group files color">
                                        <input id="bookings" type="file" title="Bookings" class="form-control" />
                                    </div>
                                </form>
                            </div>
                            <button id="btnClearBookings" class="btn btn-outline-danger my-1" onclick="clearFile('bookings')"> Clear Bookings</button>
                        </div>
                    </div>
                    <p>
                        <button href="#" id="uploadBtn" class="btn btn-outline-primary my-2">Upload files</button>
                        <button href="#" class="btn btn-outline-danger my-2" onclick="clearFile('')">Clear all files</button></p>
                </div>
            </div>
            <div class="album py-4">
                <div class="container py-4 ">
                    <div class="row">
                        <div class="col-md-4">
                            <table class="table table-light rounded box accounts">
                                <thead>
                                    <tr>
                                        <th colspan="2">Accounts</th>
                                    </tr>
                                    <tr>
                                        <th>Operation</th>
                                        <th>Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Inserted</td>
                                        <td class="inserted">0</td>
                                    </tr>
                                    <tr>
                                        <td>Updated</td>
                                        <td class="updated">0</td>
                                    </tr>
                                    <tr>
                                        <td>Not Inserted</td>
                                        <td class="notInserted">0</td>
                                    </tr>
                                    <tr>
                                        <td>Not updated</td>
                                        <td class="notUpdated">0</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-4">
                            <table class="table table-light rounded box offices">
                                <thead>
                                    <tr>
                                        <th colspan="2">Office</th>
                                    </tr>
                                    <tr>
                                        <th>Operation</th>
                                        <th>Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Inserted</td>
                                        <td class="inserted">0</td>
                                    </tr>
                                    <tr>
                                        <td>Updated</td>
                                        <td class="updated">0</td>
                                    </tr>
                                    <tr>
                                        <td>Not Inserted</td>
                                        <td class="notInserted">0</td>
                                    </tr>
                                    <tr>
                                        <td>Not updated</td>
                                        <td class="notUpdated">0</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-4">
                            <table class="table table-light rounded box bookings">
                                <thead>
                                    <tr>
                                        <th colspan="2">Bookings</th>
                                    </tr>
                                    <tr>
                                        <th>Operation</th>
                                        <th>Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Inserted</td>
                                        <td class="inserted">0</td>
                                    </tr>
                                    <tr>
                                        <td>Updated</td>
                                        <td class="updated">0</td>
                                    </tr>
                                    <tr>
                                        <td>Not Inserted</td>
                                        <td class="notInserted">0</td>
                                    </tr>
                                    <tr>
                                        <td>Not updated</td>
                                        <td class="notUpdated">0</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
