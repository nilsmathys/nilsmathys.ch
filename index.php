<?php
$mode = isset($_COOKIE['mode']) ? $_COOKIE['mode'] : 'light';

if (isset($_GET["toggle"])) {
    if ($mode == "light") {
        setcookie('mode', 'dark', strtotime('+1 year'));
    } else {
        setcookie('mode', 'light', strtotime('+1 year'));
    }
    header('Location: https://nilsmathys.ch');
}

$cfg = [
    'recaptcha_site' => '',
    'recaptcha_secret' => ''
];
if (file_exists('local.php')) {
    $cfg = include 'local.php';
}
$error = [];
$name = $_POST["name"] ?: '';
$email = $_POST["email"] ?: '';
$message = $_POST["message"] ?: '';
$sent = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($name)) {
        $error[] = "name";
    }
    if (empty($email)) {
        $error[] = "email";
    }
    if (empty($message)) {
        $error[] = "message";
    }

    if (sizeof($error) == 0) {
        $recaptcha = $_POST["g-recaptcha-response"];
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $options = [
            'http' => [
                'method' => 'POST',
                'content' => http_build_query([
                    'secret' => $cfg['recaptcha_secret'],
                    'response' => $recaptcha
                ])
            ]
        ];
        $context = stream_context_create($options);
        $verify = file_get_contents($url, false, $context);
        $checkCaptcha = json_decode($verify);
        if ($checkCaptcha->success) {
            if (mail("info@nilsmathys.ch", "Kontaktformular", "name: " . $name . "\nemail: " . $email . "\nmessage: " . $message)) {
                $name = '';
                $email = '';
                $message = '';
                $sent = true;
            } else {
                $error[] = "mail";
            }
        } else {
            $error[] = "recaptcha";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Nils Mathys</title>

    <meta itemprop="name" content="Nils Mathys">
    <meta itemprop="description" content="">
    <meta itemprop="image" content="https://nilsmathys.ch/img/profilephoto.jpg">
    <!--  anzeigebild bei whatsapp oder so-->

    <meta property="og:url" content="https://nilsmathys.ch">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Nils Mathys">
    <meta property="og:description" content="">
    <meta property="og:image" content="https://nilsmathys.ch/img/profilephoto.jpg">
    <!--  anzeigebild bei whatsapp oder so-->

    <meta name="author" content="Nils Mathys">
    <meta name="publisher" content="">
    <meta name="keywords"
          content="Nils, Mathys, Software Engineer, Engineering, Software-Entwicklung, Informatikstudent">
    <meta name="description" content="Nils Mathys, Software Engineer in study - Kontaktiere mich hier">
    <meta name="robots" content="index,follow">
    <meta name="copyright" content="Nils Mathys, nilsmathys.ch">
    <meta name="language" content="de">

    <link rel="canonical" href="https://nilsmathys.ch">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/all.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <?php if($mode == "dark") { ?>
    <link href="css/darkmode.css" rel="stylesheet" id="darkmode">
    <?php } ?>

    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
<div class="container my-4">
    <div class="row">
        <div class="col-md-6 m-auto">
            <div class="card">
                <div class="card-body text-center p-4">
                    <div class="row">
                        <div class="m-auto col-6 col-md-5 col-lg-4 col-xl-3">
                            <a href="https://nilsmathys.ch">
                                <img src="img/profilephoto.jpg" class="w-100 my-4 rounded-circle darkmode-none"
                                     id="profilephoto">
                                <img src="img/profilephoto-darkmode.jpg"
                                     class="w-100 my-4 rounded-circle d-none darkmode-show" id="profilephoto">
                            </a>
                        </div>
                    </div>
                    <div class="py-4 border-bottom">
                        <h2>Nils Mathys</h2>
                        <p>Software Engineer in study</p>
                    </div>
                    <div class="mt-4 text-left" id="content">
                        <p style="text-align: center;"><span style="font-size: 14pt;"><strong>Kontaktiere mich</strong></span>
                        </p>
                        <?php if ($sent) { ?>
                            <div class="alert alert-success" role="alert">
                                Nachricht wurde versendet!
                            </div>
                        <?php } elseif (sizeof($error) > 0) { ?>
                            <div class="alert alert-danger" role="alert">
                                Bitte prüfe deine Eingaben!
                            </div>
                        <?php } ?>
                        <form method="post">
                            <div class="form-group">
                                <input type="text" name="name" class="form-control <?php if (in_array('name', $error)) { echo "is-invalid"; } ?>" id="input_name" value="<?= $name; ?>"
                                       placeholder="Name">
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control <?php if (in_array('email', $error)) { echo "is-invalid"; } ?>" id="input_email" value="<?= $email; ?>"
                                       placeholder="E-Mail">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control <?php if (in_array('message', $error)) { echo "is-invalid"; } ?>" name="message" id="input_message"
                                          placeholder="Nachricht"><?= $message; ?></textarea>
                            </div>
                            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                            <div class="g-recaptcha mb-2 " <?php if ($mode == "dark") { echo 'data-theme="dark"'; } ?>
                                 data-sitekey="<?php echo $cfg['recaptcha_site']; ?>"></div>
                            <button type="submit" name="send" class="btn btn-primary btn-lg btn-block" value="">Senden
                            </button>
                        </form>
                    </div>
                    <div class="border-top mt-4 py-4">
                        <a href="https://www.linkedin.com/in/nils-mathys-3389b8155/" target="_blank"
                           class="btn btn-light fa-2x rounded-circle px-3 mr-3">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="https://www.crazydog.ch/" target="_blank"
                           class="btn btn-light fa-2x rounded-circle px-3 mx-3">
                            <i class="fas fa-dice-five"></i>
                        </a>
                        <a href="https://github.com/nilsmathys" target="_blank"
                           class="btn btn-light fa-2x rounded-circle px-3 mx-3">
                            <i class="fab fa-github"></i>
                        </a>
                        <a href="?toggle"
                           class="btn btn-light fa-2x rounded-circle px-3 ml-3">
                            <i class="fa fa-adjust"></i>
                        </a>
                    </div>
                    <div class="border-top pt-4 footer">
                        <p>Copyright &copy; 2020 by Nils Mathys</p>
                        <div class="border-top mt-2 py-2">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-info btn-sm btn-block" data-toggle="modal"
                                    data-target="#privacy-policy">
                                Datenschutzerklärung
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="privacy-policy" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Datenschutzerklärung</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <?php echo file_get_contents('text/datenschutz.html'); ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                Schliessen
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-info btn-sm btn-block" data-toggle="modal"
                                    data-target="#impressum">
                                Impressum
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="impressum" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Impressum</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <?php echo file_get_contents('text/impressum.html'); ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                Schliessen
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>