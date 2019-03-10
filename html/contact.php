<?php
session_start();
require_once 'util.inc.php';

//3)変数の初期化（5つの変数を空にする）
$name    = "";
$kana    = "";
$email   = "";
$phone   = "";
$inquiry = "";
$mapNone = TRUE;//地図の非表示フラグ

//2)もしセッション変数内に値が存在（登録）していれば
// セッション変数から配列を引き出して
if(isset($_SESSION["contact"])) {
    $contact = $_SESSION["contact"];
    $name = $contact["name"];
    $kana = $contact["kana"];
    $email = $contact["email"];
    $phone = $contact["phone"];
    $inquiry = $contact["inquiry"];

    $mapNone = $contact["mapNone"];
    // ↑$tokenに関しては確認画面から戻ってもハッシュ値を隠しフォームに表示できないので
    // 配列から値を引き出す必要はない。
}

// 1)もし確認ボタンを押したらなら
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $isValidated = TRUE;
    $mapNone = FALSE;
    //ここはPOSTで受け取るので↑の$_SESSIONとは違う
    $name    = $_POST["name"];
    $kana    = $_POST["kana"];
    $email   = $_POST["email"];
    $phone   = $_POST["phone"];
    $inquiry = $_POST["inquiry"];
    $token   = $_POST["token"];

    //バリデーション
    //名前
    if ($name === "") {
        $isValidated = FALSE;
        $errorName = "※お名前を入力してください";
    }

    //フリガナ
    if ($kana === "") {
        $isValidated = FALSE;
        $errorKana = "※フリガナを入力してください";
    }
    elseif (!preg_match("/^[ァ-ヶー]+$/u", $kana)) {
        $isValidated = FALSE;
        $errorKana = "※全角カタカナで入力してください";
    }

    //メアド
    if ($email === "") {
        $isValidated = FALSE;
        $errorEmail = "※メールアドレスを入力してください";
    }
    elseif (!preg_match("/^[^@]+@[^@]+\.[^@]+$/", $email)) {
        $isValidated = FALSE;
        $errorEmail = "※メールアドレスの形式が正しくありません";
    }

    //問い合わせ内容
    if ($inquiry === "") {
        $isValidated = FALSE;
        $errorInquiry = "※お問い合わせ内容を入力してください";
    }

    if ($isValidated == TRUE){
        //↓これはいらない？
//         $_SESSION["name"] = $name;
//         $_SESSION["kana"] = $kana;
//         $_SESSION["email"] = $email;
//         $_SESSION["phone"] = $phone;
//         $_SESSION["inquiry"] = inquiry;

        $contact = array(
            "name"    => $name,
            "kana"    => $kana,
            "email"   => $email,
            "phone"   => $phone,
            "inquiry" => $inquiry,
            "token"   => $token,
            "mapNone" => FALSE
        );

        $_SESSION["contact"] = $contact;

        header("Location: contact_conf.php");
        exit;
    }
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
              <li><a href="skill.html">Skills</a></li>
              <li><a href="site.html">Sites</a></li>
              <li><a href="banner.html">Banner</a></li>
              <li><a href="contact.php">Contact</a></li>
            </ul>
          </div>
      </div>
    </nav>
  </header>
  <main>
    <div class="container">
      <section class="block">
          <div class="block_body">
            <h2 class="block_body_title">お問い合わせ</h2>
            <div class="col-md-12">
           <!--  <h3 class="page-header">Send Message</h3> -->
            <form class="form-horizontal" action="" method="post" novalidate>
            <!-- 隠しフォームで次のページに値を送る -->
          <input type="hidden" name="token" value="<?php echo getToken(); ?>">
              <div class="form-group">
                <label for="inputname" class="col-sm-3 control-label">お名前<br><span>(必須)</span></label>
                <div class="col-sm-9">
                <div class="text-warning">
                    <?php if(isset($errorName)): ?>
                    <?php echo h($errorName); ?>
                    <?php endif; ?>
                </div>
                  <input type="text" class="form-control" name="name" id="inputname" value="<?php echo h($name); ?>" required>
                  <p class="help-block">(例)山田　太郎</p>
                </div>
              </div>
              <div class="form-group">
                <label for="inputkana" class="col-sm-3 control-label">フリガナ<br><span>(必須)</span></label>
                <div class="col-sm-9">
                <div class="text-warning">
                    <?php if(isset($errorKana)): ?>
                    <?php echo h($errorKana); ?>
                    <?php endif; ?>
                </div>
                  <input type="text" class="form-control" name="kana" id="inputkana" value="<?php echo h($kana); ?>" required>
                  <p class="help-block">(例)ヤマダ　タロウ ※全角カタカナ</p>
                </div>
              </div>
              <div class="form-group">
                <label for="inputemail" class="col-sm-3 control-label">メールアドレス<br><span>(必須)</span></label>
                <div class="col-sm-9">
                  <div class="text-warning">
                      <?php if(isset($errorEmail)): ?>
                        <?php echo h($errorEmail); ?>
                        <?php endif; ?>
                    </div>
                  <input type="email" class="form-control" name="email" id="inputemail" required value="<?php echo h($email); ?>">
                  <p class="help-block">(例)abc@zz.com ※半角英数字</p>
                </div>
              </div>
              <div class="form-group">
                <label for="inputtel" class="col-sm-3 control-label">電話番号</label>
                <div class="col-sm-9">
                  <input type="tel" class="form-control" name="phone" id="inputtel" value="<?php echo h($phone); ?>">
                  <p class="help-block">(例)03-1234-3214　※ハイフンあり　半角数字</p>
                </div>
              </div>
              <div class="form-group">
                <label for="inputmessage" class="col-sm-3 control-label">お問い合わせ内容<br><span>(必須)</span></label>
                <div class="col-sm-9">
                <div class="text-warning">
                  <?php if(isset($errorInquiry)): ?>
                    <?php echo h($errorInquiry); ?>
                    <?php endif; ?>
                </div>
                  <textarea rows="10" cols="100" class="form-control" name="inquiry" id="message" required maxlength="999" style="resize:none"><?php echo h($inquiry); ?></textarea>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-10">
                  <button type="submit" class="btn btn-success
                  " name="check">内容を確認して送信</button>
                </div>
              </div>
            </form>
          </div>
          </div>
      </section>
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
