<!DOCTYPE html>
<html lang="zh">

<head>

    <meta charset="utf-8">
    <meta name="author" content="临来笑笑生">
    <meta name="description" content="Fortune(财运) OA">
    <meta name="keyword" content="开源OA系统 财运OA Fortune OA">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>登录--Fortune(财运) 后台</title>
    <base href="<?= base_url('static/miminium'); ?>/" />
    <!-- start: Css -->
    <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">

    <!-- plugins -->
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/simple-line-icons.css" />
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/animate.min.css" />
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/icheck/skins/flat/aero.css" />
    <link href="asset/css/style.css" rel="stylesheet">
    <!-- end: Css -->

    <link rel="shortcut icon" href="asset/img/logomi.png">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="asset/js/html5shiv.min.js"></script>
      <script src="asset/js/respond.min.js"></script>
      <![endif]-->
</head>

<body id="mimin" class="dashboard form-signin-wrapper">

    <div class="container">

        <form action="<?= site_url('login/check'); ?>" method="post" class="form-signin">

            <div class="panel periodic-login">
                <span class="atomic-number">后台</span>
                <div class="panel-body text-center">
                    <h1 class="atomic-symbol">优</h1>

                    <p class="element-name">悦购</p>
                    <p class="atomic-mass">一</p>

                    <i class="icons icon-arrow-down"></i>

                    <?= $error ? '<div style="color: yellow;">' . $error . '</div>' : '' ?>

                    <div class="form-group form-animate-text" style="margin-top:40px !important;">
                        <input type="text" name="login" value="<?= old('login') ?>" class="form-text" required>
                        <span class="bar"></span>
                        <label>登录名</label>
                    </div>

                    <div class="form-group form-animate-text" style="margin-top:40px !important;">
                        <input type="password" name="passwd" class="form-text" required>
                        <span class="bar"></span>
                        <label>密码</label>
                    </div>

                    <?php if (isset($throttle) && $throttle > 0) : ?>
                        <div class="input-group">
                            <input type="text" name="captcha" class="form-control" placeholder="输入认证码" aria-describedby="basic-addon2">
                            <span class="input-group-addon" id="basic-addon2" style="padding: 0;border:0"><img src="<?= $captchaImg ?>" height="34" id="captcha"></span>
                        </div>
                    <?php endif; ?>
                    <br>
                    <label class="pull-left">
                        <input type="checkbox" class="icheck pull-left" name="" /> 记住
                    </label>
                    <input type="submit" class="btn col-md-12" value="登录" />
                </div>
                <div class="text-center" style="padding:5px;">
                    <a href="<?= site_url('forget/index') ?>" title="我要找回密码">忘记密码 </a>
                    <a href="reg.html">| 注册</a>
                </div>
            </div>
        </form>

    </div>

    <!-- end: Content -->
    <!-- start: Javascript -->
    <script src="asset/js/jquery.min.js"></script>
    <script src="asset/js/jquery.ui.min.js"></script>
    <script src="asset/js/bootstrap.min.js"></script>

    <script src="asset/js/plugins/moment.min.js"></script>
    <script src="asset/js/plugins/icheck.min.js"></script>

    <!-- custom -->
    <script src="asset/js/main.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('input').iCheck({
                checkboxClass: 'icheckbox_flat-aero',
                radioClass: 'iradio_flat-aero'
            });
            $('#captcha').click(function() {
                // alert('更换认证码');

                var that = $(this);
                var url = "<?= site_url('login/getCaptcha') ?>";

                $(this).attr('src', '');

                $.get(url, function(result) {
                    if (result.status) {
                        $(that).attr('src', result.src);
                    }
                });

            });
        });
    </script>
    <!-- end: Javascript -->
</body>

</html>