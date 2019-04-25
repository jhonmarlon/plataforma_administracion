
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel" >
            <div class="pull-left image" style="width: 100%;">
                <?php
  
                if ($userinfo->id_empresa == 1) {
                    ?>
                <img style="margin-left: 1px;max-width: 99%;" src="dist/img/logo_cel_comunicaciones.png"  class="img-circle" alt="User Image">

                <?php } ?>
            </div>
            <div class="pull-left info">
                <br>

            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MENU PRINCIPAL</li>

            <?php
            
                $rol = $userinfo->id_rol;
          
            foreach ($vista->_PAGE_CONFIG as $page => $params) {
                $show = true;
                if (array_key_exists($rol, $vista->_PAGE_PERMISSIONS)) {
                    $pages_perm = $vista->_PAGE_PERMISSIONS[$rol];
                    $show = !array_key_exists($page, $pages_perm);
                }
                if ($params["show"] && $show) {
                    if (!$params["isSubmenu"]) {
                        $menutxt = $params["menu"];
                        $menucss = $params["menu_css_class"];
                        if (!array_key_exists("submenu", $params)) {
                            ?>
                            <li class="<?php
                            if ($vista->page == $page) {
                                echo " active ";
                            }
                            ?>">
                                <a href="index.php?page=<?php echo $page; ?>"  > <i class="fa <?php echo $menucss; ?>"></i>
                                    <span><?php echo $menutxt; ?></span>
                                </a>
                            </li>
                            <?php
                        } else {
                            $submenu = $params["submenu"];
                            $submenucss = $params["menu_css_class"];
                            ?>
                            <li class="treeview <?php
                            if ($vista->page == $page) {
                                echo " active ";
                            }
                            ?>">
                                <a href="#"  > <i class="fa  <?php echo $submenucss; ?>"></i>
                                    <span><?php echo $menutxt; ?></span>
                                    <span class="pull-right-container">
                                        <span class="label label-primary pull-right "><i class="fa fa-sort-down"></i></span>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <?php
                                    foreach ($submenu as $sub_page) {
                                        $subshow = !array_key_exists($sub_page, $pages_perm);
                                        if ($subshow) {
                                            $sub_menutxt = $vista->_PAGE_CONFIG[$sub_page]["menu"];
                                            $sub_menucss = $vista->_PAGE_CONFIG[$sub_page]["menu_css_class"];
                                            ?>
                                            <li class="<?php
                                            if ($vista->page == $sub_page) {
                                                echo " active ";
                                            }
                                            ?>">
                                                <a href="index.php?page=<?php echo $sub_page; ?>" ><i class="fa <?php echo $sub_menucss; ?>"></i>
                                                    <?php echo $sub_menutxt; ?>
                                                </a></li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </li>
                            <?php
                        }
                    }
                }
            }
            ?>

        </ul>

    </section>
    <!-- /.sidebar -->

</aside>
