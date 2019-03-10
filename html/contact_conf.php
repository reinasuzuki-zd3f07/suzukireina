<?php
session_start();
require_once 'util.inc.php';
require_once 'libs/qd/qdsmtp.php';
require_once 'libs/qd/qdmail.php';

//セッション変数が存在する場合は読み出す
if(isset($_SESSION["contact"])) {
    $contact = $_SESSION["contact"];

    $name = $contact["name"];
    $kana = $contact["kana"];
    $email = $contact["email"];
    $phone = $contact["phone"];
    $inquiry = $contact["inquiry"];
    $token = $contact["token"];

    if($token !== getToken()){
        header("Location:contact.php");
        exit;
    }
}
else{
    header("Location:contact.php");
    exit;
}

if (isset($_POST["send"])){
//ヒアドキュメントを使用する（php中級のロジックとビュー最後のページを参照）
$body = <<<EOT
■氏名
{$name}

■フリガナ
{$kana}

■メールアドレス
{$email}

■電話番号
{$phone}

■問い合わせ内容
{$inquiry}

EOT;

    $mail = new Qdmail();
    // エラーを非表示
    $mail->errorDisplay(false);
    $mail->smtpObject()->error_display = false;
    // 送信内容
    $mail->from("zd3F07@sim.zdrv.com", "鈴木麗那ポートフォリオサイト");
    $mail->to("zd3F07@sim.zdrv.com","鈴木麗那ポートフォリオサイト");
    $mail->subject("ポートフォリオサイト 問い合わせ");
    $mail->text($body);
    // SMTP用設定(xamppのためメールサーバ設定が必要)
    $param = array(
        "host" => "w1.sim.zdrv.com",
        "port" => 25,
        "from" => "zd3F07@sim.zdrv.com",
        "protocol" => "SMTP"
    );
    $mail->smtp(TRUE);
    $mail->smtpServer($param);
    // 送信
    $flag = $mail->send();

    //もし送信に成功したならば
    if($flag == TRUE){
        unset($_SESSION["contact"]);//セッション変数を破棄(送信した後はいらないので消す)
        header("Location:contact_done.php");
        exit;
    }
    else{//送信失敗した場合は、セッション変数はそのまま残っているはず
        header("Location:contact_error.php");
        exit;
    }
}

if (isset($_POST["back"])){
    header("Location: contact.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Contact | REINA SUZUKI</title>
    <meta name="keywords" content="web,design,coder,html,css,webdesign,">
    <meta name="description" content="鈴木麗那のポートフォリオです。あなたのWebサイトづくりをお手伝いします。">
    <!-- スマホの表示倍率を100%にリセット -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- iPhoneXでのボックス表示対応(Bootstrapのハンバーガーアイコンが無効になる) -->
    <!-- <meta name="viewport" content="viewport-fit=cover"> -->
    <!-- OGP (Facebookでのフィード表示) -->
    <meta property="fb:app_id" content="App-ID(15文字の半角数字)" />
    <meta property="og:title" content="(PageTitle | )SiteTitle" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="http://sample.com/aboutus" />
    <meta property="og:image" content="http://test.com/img/ogp.jpg" />
    <meta property="og:site_name" content="SiteTitle" />
    <meta property="og:description" content="ページ説明文" />

    <!-- ファビコン -->
    <link rel="icon" href="images/fa.png" type="image/png">
    <!-- ホーム画面に追加 -->
    <link rel="apple-touch-icon" href="images/fa.png">
    <!-- Bootstrap3.3.7 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- OriginCSS -->
    <link rel="stylesheet" href="css/style.css">

    <!-- jQuery3 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <!-- Bootstrap3.3.7 Javascript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- OriginalJS -->
    <!-- <script src="js/index.js"></script> -->

    <!-- IE9以下にHTML5の新要素を認識 -->
    <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv-printshiv.min.js"></script>
    <![endif]-->
</head>

<body class="top">
  <div id="wrapper">
  <section class="hero">
    <ul class="heroTop">
    <li><img src="images/rei01.png" alt="rei"></li>
    <li><img src="images/rei02.png" alt="rei"></li>
    <li><img src="images/rei03.png" alt="rei"></li>
    <li><img src="images/rei17.png" alt="rei"></li>
    <li><img src="images/rei24.png" alt="rei"></li>
    <li><img src="images/rei06.png" alt="rei"></li>
    <li><img src="images/rei07.png" alt="rei"></li>
    </ul>
    <div class="heroTitle">
    <h1 id="name">鈴木麗那</h1>
    <p>ポートフォリオサイト</p>
    </div>
    <ul class="heroBottom">
    <li><img src="images/rei08.png" alt="rei"></li>
    <li><img src="images/rei09.png" alt="rei"></li>
    <li><img src="images/rei10.png" alt="rei"></li>
    <li><img src="images/rei21.png" alt="rei"></li>
    <li><img src="images/rei12.png" alt="rei"></li>
    <li><img src="images/rei13.png" alt="rei"></li>
    <li><img src="images/rei14.png" alt="rei"></li>
    </ul>
  </section>
  <header class="gl-header">
    <nav class="navbar navbar-expand-md">
      <!-- 1000px以下 -->
      <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <!-- <a class="navbar-brand" href="#"> -->
              <p class="gl-header_title"></p>
            <!-- </a> -->
          </div>
          <div id="navbar" class="navbar-collapse collapse nav-menu">
            <ul class="nav navbar-nav" id="flex">
              <li class="active"><a href="index.html">Home</a></li>
              <li><a href="#">Skills</a></li>
              <li><a href="#">Sites</a></li>
              <li><a href="#">Banner</a></li>
              <li><a href="#">Contact</a></li>
            </ul>
          </div>
      </div>
    </nav>
  </header>
  <main>
    <div class="container">
      <section class="block">
          <div class="block_body">
            <h2 class="block_body_title">お問い合わせ内容確認</h2>
            <div class="col-md-8">
            <p>内容を修正される場合は「修正する」ボタンを、送信される場合は「送信する」ボタンを押してください。</p>
            <table class="table table-hover table-bordered">
              <tr>
                <th>お名前</th>
                <td><?php echo h($name); ?></td>
              </tr>
              <tr>
                <th>フリガナ</th>
                <td><?php echo h($kana); ?></td>
              </tr>
              <tr>
                <th>メールアドレス</th>
                <td><?php echo h($email); ?></td>
              </tr>
              <tr>
                <th>電話番号</th>
                <td><?php echo h($phone); ?></td>
              </tr>
              <tr>
                <th>お問い合わせ内容</th>
                <td><?php echo nl2br(h($inquiry)); ?></td>
              </tr>
            </table>
            <form class="form-horizontal" action="" method="POST">
                <div class="form-group">
                <div class="col-sm-10">
                  <button type="submit" name="send" class="btn btn-success btn-lg">送信する</button>
                  <button type="submit" name="back" class="btn btn-success btn-lg">修正する</button>
                </div>
              </div>
            </form>
          </div>
  </main>

  <p class="page-top"><a href="#"><i class="fa fa-arrow-up fa-lg"></i></a></p>

  <footer class="gl-footer">
    <div class="container gl-footer_container">
      <small>&copy;2019 REINA SUZUKI. All Rights Reserved.</small>
    </div>
  </footer>
</div>

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-96344339-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('require', 'linkid');
    gtag('config', 'UA-96344339-1');
  </script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<!-- <script src="js/index.js"></script> -->
</body>
</html
