<?php
$mode = isset($_COOKIE['mode']) ? $_COOKIE['mode'] : 'light';

if (isset($_GET["toggle"])) {
    if ($mode == "light") {
        setcookie('mode', 'dark', strtotime('+1 year'));
    } else {
        setcookie('mode', 'light', strtotime('+1 year'));
    }
    header('Location: /');
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
$profilepic = "profilephoto.jpg";
$profilepicDarkmode = "profilephoto-darkmode.jpg";
$background = "background.jpg";
$backgroundDarkmode = "background-darkmode.jpg";
if (in_array(date("n"), [1, 2, 3, 12])) {
    $profilepic = "profilephoto-winter.jpg";
    $profilepicDarkmode = "profilephoto-winter-darkmode.jpg";
    $background = "background-winter.jpg";
    $backgroundDarkmode = "background-winter-darkmode.jpg";
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
          content="Nils, Mathys, Software Engineer, Engineering, Software-Entwicklung, Informatikstudent, It-Student, programmieren, Programmierer">
    <meta name="description" content="Nils Mathys, Software Engineer in study - Kontaktiere mich hier">
    <meta name="robots" content="index,follow">
    <meta name="copyright" content="Nils Mathys, nilsmathys.ch">
    <meta name="language" content="de">

    <link rel="canonical" href="https://nilsmathys.ch">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/all.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <?php if ($mode == "dark") { ?>
        <link href="css/darkmode.css" rel="stylesheet" id="darkmode">
        <style>
            html {
                background: url("img/<?php echo $backgroundDarkmode; ?>") fixed;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            }
        </style>
    <?php } else { ?>
        <style>
            html {
                background: url("img/<?php echo $background; ?>") fixed;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            }
        </style>
    <?php } ?>
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/index.js"></script>
</head>
<body>
<div class="container mt-30" id="navigation-bar">
    <div class="row">
        <div class="col-md-8 col-lg-12 m-auto">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom rounded-top">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <div class="navbar-nav">
                            <a class="nav-link" href="#home">Home</a>
                            <a class="nav-link" href="#cv">CV</a>
                            <a class="nav-link" href="#über_mich">über mich</a>
                            <a class="nav-link" href="#kontaktiere-mich">Kontaktiere mich</a>
                            <a href="https://www.linkedin.com/in/nils-mathys-3389b8155/" target="_blank"
                               class="nav-link">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="https://github.com/nilsmathys" target="_blank"
                               class="nav-link">
                                <i class="fab fa-github"></i>
                            </a>
                            <a href="?toggle"
                               class="nav-link">
                                <i class="fa fa-adjust"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<div class="container mb-4" id="con">
    <div class="row">
        <div class="col-md-8 col-lg-12 m-auto">
            <div class="bg-light rounded-bottom">
                <div class="text-center p-4">
                    <div class="row" id="home">
                        <div class="m-auto col-6 col-md-5 col-lg-4 col-xl-3">
                            <a href="/">
                                <img src="img/<?php echo $profilepic; ?>"
                                     class="w-100 my-4 rounded-circle darkmode-none"
                                     id="profilephoto">
                                <img src="img/<?php echo $profilepicDarkmode; ?>"
                                     class="w-100 my-4 rounded-circle d-none darkmode-show" id="profilephoto">
                            </a>
                        </div>
                    </div>
                    <div class="py-4 border-bottom">
                        <h1>Nils Mathys</h1>
                        <h4>Software Engineer in study</h4>
                    </div>


                    <div class="mt-4 text-left border-bottom" id="cv">
                        <h2 style="text-align: center"><strong>CV</strong></h2>
                        <h3><strong>Skills</strong></h3>
                        <h4>Programmiersprachen</h4>
                        <div class="skillbar" data-percent="75%">
                            <div class="skillbar-title">Java</div>
                            <div class="skill-bar-percent">75%</div>
                            <div class="skillbar-bar" style="width: 75%;"></div>
                        </div>
                        <div class="skillbar" data-percent=80%">
                            <div class="skillbar-title">SwiftUI</div>
                            <div class="skill-bar-percent">80%</div>
                            <div class="skillbar-bar" style="width: 80%;"></div>
                        </div>
                        <div class="skillbar" data-percent="70%">
                            <div class="skillbar-title">Kotlin</div>
                            <div class="skill-bar-percent">70%</div>
                            <div class="skillbar-bar" style="width: 70%;"></div>
                        </div>
                        <div class="skillbar" data-percent="55%">
                            <div class="skillbar-title">C</div>
                            <div class="skill-bar-percent">55%</div>
                            <div class="skillbar-bar" style="width: 55%;"></div>
                        </div>
                        <div class="skillbar" data-percent="55%">
                            <div class="skillbar-title">Assembler</div>
                            <div class="skill-bar-percent">55%</div>
                            <div class="skillbar-bar" style="width: 55%;"></div>
                        </div>
                        <h4>Web-Skills</h4>
                        <div class="skillbar" data-percent="40%">
                            <div class="skillbar-title">React Native</div>
                            <div class="skill-bar-percent">40%</div>
                            <div class="skillbar-bar" style="width: 40%;"></div>
                        </div>
                        <div class="skillbar" data-percent="40%">
                            <div class="skillbar-title">Java Script</div>
                            <div class="skill-bar-percent">40%</div>
                            <div class="skillbar-bar" style="width: 40%;"></div>
                        </div>
                        <div class="skillbar" data-percent="40%">
                            <div class="skillbar-title">Type Script</div>
                            <div class="skill-bar-percent">40%</div>
                            <div class="skillbar-bar" style="width: 40%;"></div>
                        </div>
                        <div class="skillbar" data-percent="70%">
                            <div class="skillbar-title">HTML / CSS</div>
                            <div class="skill-bar-percent">70%</div>
                            <div class="skillbar-bar" style="width: 70%;"></div>
                        </div>
                        <h4>Datenbanken</h4>
                        <div class="skillbar" data-percent="60%">
                            <div class="skillbar-title">MySQL</div>
                            <div class="skill-bar-percent">60%</div>
                            <div class="skillbar-bar" style="width: 60%;"></div>
                        </div>
                        <h4>Sprachen</h4>
                        <div class="skillbar" data-percent="100%">
                            <div class="skillbar-title">Deutsch</div>
                            <div class="skill-bar-percent">100%</div>
                            <div class="skillbar-bar" style="width: 100%;"></div>
                        </div>
                        <div class="skillbar" data-percent="70%">
                            <div class="skillbar-title">Englisch</div>
                            <div class="skill-bar-percent">70%</div>
                            <div class="skillbar-bar" style="width: 70%;"></div>
                        </div>
                        <div class="mt-4 text-left border-bottom" id="über_mich">
                            <h3><strong>Über mich</strong></h3>
                            <h4>Wer ich bin</h4>
                            <p>25 Jahre alt, aufgestellt, ruhig und hilfsbereit</p>
                            <h4>Hobbies</h4>
                            <p>american Football, Boogie Woogie, Motorrad fahren</p>
                        </div>
                    </div>
                    <div class="mt-4 text-left" id="kontaktiere-mich">
                        <h2 style="text-align: center"><strong>Kontaktiere mich</strong></h2>
                        <?php if ($sent) { ?>
                            <div class="alert alert-success" role="alert">
                                Nachricht wurde versendet!
                            </div>
                        <?php } elseif (sizeof($error) > 0) { ?>
                            <div class="alert alert-danger" role="alert">
                                Bitte prüfe Deine Eingaben!
                            </div>
                        <?php } ?>
                        <form method="post">
                            <div class="form-group">
                                <input type="text" name="name" class="form-control <?php if (in_array('name', $error)) {
                                    echo "is-invalid";
                                } ?>" id="input_name" value="<?= $name; ?>"
                                       placeholder="Name">
                            </div>
                            <div class="form-group">
                                <input type="email" name="email"
                                       class="form-control <?php if (in_array('email', $error)) {
                                           echo "is-invalid";
                                       } ?>" id="input_email" value="<?= $email; ?>"
                                       placeholder="E-Mail">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control <?php if (in_array('message', $error)) {
                                    echo "is-invalid";
                                } ?>" name="message" id="input_message"
                                          placeholder="Nachricht"><?= $message; ?></textarea>
                            </div>
                            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                            <div class="g-recaptcha mb-2 " <?php if ($mode == "dark") {
                                echo 'data-theme="dark"';
                            } ?>
                                 data-sitekey="<?php echo $cfg['recaptcha_site']; ?>"></div>
                            <?php if ($mode == "dark") { ?>
                                <button type="submit" name="send" class="btn btn-secondary btn-lg btn-block" value="">Senden
                                </button>
                            <?php } else { ?>
                                <button type="submit" name="send" class="btn btn-primary btn-lg btn-block" value="">Senden
                                </button>
                            <?php } ?>
                        </form>
                    </div>
                    <div class="border-top mt-4 py-4 row">
                        <div class="col-6 col-md-3">
                            <a href="https://www.linkedin.com/in/nils-mathys-3389b8155/" target="_blank"
                               class="btn btn-light fa-2x rounded-circle px-3">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a href="https://beerjump.app" target="_blank"
                               class="btn btn-light fa-2x rounded-circle px-3">
                                <i class="fa fa-beer"></i>
                            </a>
                        </div>
                        <div class="col-6 col-md-3 mt-3 mt-md-0">
                            <a href="https://github.com/nilsmathys" target="_blank"
                               class="btn btn-light fa-2x rounded-circle px-3">
                                <i class="fab fa-github"></i>
                            </a>
                        </div>
                        <div class="col-6 col-md-3 mt-3 mt-md-0">
                            <a href="?toggle"
                               class="btn btn-light fa-2x rounded-circle px-3">
                                <i class="fa fa-adjust"></i>
                            </a>
                        </div>
                    </div>
                    <div class="border-top pt-4 footer">
                        <p>Copyright &copy; 2020 by Nils Mathys</p>
                        <div class="border-top mt-2 py-2">
                            <!-- Button trigger modal -->
                            <?php if ($mode == "dark") { ?>
                                <button type="button" class="btn btn-secondary btn-sm btn-block" data-toggle="modal"
                                        data-target="#privacy-policy">
                                    Datenschutzerklärung
                                </button>
                            <?php } else { ?>
                                <button type="button" class="btn btn-info btn-sm btn-block" data-toggle="modal"
                                        data-target="#privacy-policy">
                                    Datenschutzerklärung
                                </button>
                            <?php } ?>
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
                            <?php if ($mode == "dark") { ?>
                                <button type="button" class="btn btn-secondary btn-sm btn-block" data-toggle="modal"
                                        data-target="#impressum">
                                    Impressum
                                </button>
                            <?php } else { ?>
                                <button type="button" class="btn btn-info btn-sm btn-block" data-toggle="modal"
                                        data-target="#impressum">
                                    Impressum
                                </button>
                            <?php } ?>
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
<a id="jump-to-top" href="#home" class="rounded-circle bg-light text-dark">
    <i class="fa fa-arrow-up"></i>
</a>
</body>
</html>
