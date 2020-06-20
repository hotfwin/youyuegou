<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="临来笑笑生">
    <meta name="keyword" content="風味雲、風創未來">
    <meta name="description" content="Fortune(財運雲) OA">
    <title>風味雲（www.gust.cn）後臺</title>
    <base href="<?= base_url('static/miminium'); ?>/" />
    <!-- start: Css -->
    <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">

    <!-- plugins -->
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/simple-line-icons.css" />
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/animate.min.css" />

    <link rel="stylesheet" type="text/css" href="asset/css/plugins/fullcalendar.min.css" />
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/mediaelementplayer.css" />
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/icheck/skins/flat/red.css" />
    <link href="asset/css/style.css" rel="stylesheet">
    <!-- end: Css -->

    <!-- <link rel="shortcut icon" href="asset/img/logomi.png"> -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

    <script src="asset/js/jquery-2.1.4.js"></script>
    <script src="asset/js/jquery.ui.min.js"></script>
    <script src="asset/js/bootstrap.min.js"></script>
</head>
<!-- 后台框架源码来自于（miminium）：https://github.com/akivaron/miminium -->

<body id="mimin" class="dashboard">
    <!-- start: Header -->
    <nav class="navbar navbar-default header navbar-fixed-top">
        <div class="col-md-12 nav-wrapper">
            <div class="navbar-header" style="width:100%;">
                <div class="opener-left-menu is-open">
                    <span class="top"></span>
                    <span class="middle"></span>
                    <span class="bottom"></span>
                </div>
                <a href="<?= site_url() ?>" class="navbar-brand">
                    <b>优悦购</b>
                    <!-- <img src="asset/img/fcwl.png" width="158" style="margin-top: -10px;"> -->
                </a>

                <ul class="nav navbar-nav search-nav">
                    <li>
                        <!-- 頂部搜索 -->
                        <!-- <div class="search">
							<span class="fa fa-search icon-search" style="font-size:23px;"></span>
							<div class="form-group form-animate-text">
								<input type="text" class="form-text" required>
								<span class="bar"></span>

								<label class="label-search">Type anywhere to <b>搜索</b> </label>
							</div>
						</div> -->
                    </li>
                </ul>

                <ul class="nav navbar-nav navbar-right user-nav">
                    <li class="user-name"><span><?= session('username') ?></span></li>
                    <li class="dropdown avatar-dropdown">
                        <img src="asset/img/avatar.jpg" class="img-circle avatar" alt="user name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" />
                        <ul class="dropdown-menu user-dropdown">
                            <li><a href="javascript:void(0)"><span class="fa fa-user"></span> 我的简介</a></li>
                            <li><a href="javascript:void(0)"><span class="fa fa-calendar"></span> 我的日程</a></li>
                            <li role="separator" class="divider"></li>
                            <li class="more">
                                <ul>
                                    <li><a href="<?= site_url('admins/modifypasswd/') ?>" title="修改密码"><span class="fa fa-cogs"></span></a></li>
                                    <li><a href="javascript:void(0)"><span class="fa fa-lock"></span></a></li>
                                    <li><a href="<?= site_url('login/quit') ?>" onclick="return confirm('是否要退出登录？？');" title="退出登录"><span class="fa fa-power-off "></span></a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <!-- <li ><a href="javascript:void(0)" class="opener-right-menu"><span class="fa fa-coffee"></span></a></li> -->
                </ul>
            </div>
        </div>
    </nav>
    <!-- end: Header -->

    <div class="container-fluid mimin-wrapper">

        <!-- start:Left Menu -->
        <div id="left-menu">
            <div class="sub-left-menu scroll">
                <ul class="nav nav-list">
                    <li>
                        <div class="left-bg"></div>
                    </li>
                    <li class="time">
                        <h1 class="animated fadeInLeft">18:00</h1>
                        <p class="animated fadeInRight">Sat,October 1st 2029</p>
                    </li>

                    <?php if ($menus) : ?>
                        <?php foreach ($menus as $key => $value) : ?>
                            <!-- <li class="active ripple"> -->
                            <li class="ripple <?= (is_object($current) && $current->department == $value->id) ? 'active' : '' ?>">
                                <a <?= $value->child ? 'class="tree-toggle nav-header"' : 'href="' . site_url($value->class . '/' . $value->method) . '"' ?>>
                                    <span class="fa <?= $value->icon ?>"></span> <?= $value->name ?>
                                    <!-- <?= $value->child ? '<span class="fa-angle-right fa right-arrow text-right"></span>' : '' ?> -->
                                    <?php if ($value->child) : ?>
                                        <span class="fa right-arrow text-right <?= (is_object($current) && $current->department == $value->id) ? 'fa-angle-down' : 'fa-angle-right' ?>"></span>
                                    <?php endif; ?>
                                </a>
                                <?php if ($value->child) : ?>
                                    <ul id="<?= (is_object($current) && $current->department == $value->id) ? 'unfold' : '' ?>" class="nav nav-list tree">
                                        <?php foreach ($value->child as $k => $val) : ?>
                                            <li>
                                                <a href="<?= site_url($val->class . '/' . $val->method) ?>" style="<?= (is_object($current) && $current->class == $val->class && $current->method=='index') ? 'color: green;' : '' ?>" >
                                                    <?= $val->name ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </li>

                        <?php endforeach; ?>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
        <!-- end: Left Menu -->


        <!-- start: content -->
        <div id="content">
        <!--  开始中间主体内容 -->
        