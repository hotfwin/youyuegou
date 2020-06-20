
        <!--  结束中间主体内容 -->
        </div>
        <!-- end: content -->


        <!-- start: right menu -->


        <!-- end: right menu -->

    </div>

    <!-- start: Mobile -->
    <div id="mimin-mobile" class="reverse">
        <div class="mimin-mobile-menu-list">
            <div class="col-md-12 sub-mimin-mobile-menu-list animated fadeInLeft">
                <ul class="nav nav-list">

                    <?php if ($menus) : ?>
                        <?php foreach ($menus as $key => $value) : ?>
                            <!-- <li class="active ripple"> -->
                            <li class="ripple">
                                <a <?= $value->child ? 'class="tree-toggle nav-header"' : 'href="' . site_url($value->class . '/' . $value->method) . '"' ?>>
                                    <span class="fa <?= $value->icon ?>"></span> <?= $value->name ?>
                                    <?= $value->child ? '<span class="fa-angle-right fa right-arrow text-right"></span>' : '' ?>
                                </a>
                                <?php if ($value->child) : ?>
                                    <ul class="nav nav-list tree">
                                        <?php foreach ($value->child as $k => $val) : ?>
                                            <li><a href="<?= site_url($val->class . '/' . $val->method) ?>"><?= $val->name ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </div>

    <button id="mimin-mobile-menu-opener" class="animated rubberBand btn btn-circle btn-danger">
        <span class="fa fa-bars"></span>
    </button>

    <!-- end: Mobile -->

    <!-- start: Javascript -->

    <!-- plugins -->
    <script src="asset/js/plugins/moment.min.js"></script>
    <script src="asset/js/plugins/jquery.nicescroll.js"></script>

    <script src="asset/js/main.js"></script>

    <!-- end: Javascript -->

</body>

</html>