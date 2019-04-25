<?php

if (isset($_SESSION["id_su"])) {
    $rol = 1;
} else {
    $rol = $userinfo->id_rol;
}

if (array_key_exists($vista->page, $vista->_PAGE_CONFIG)) {
    $show = true;
    if (array_key_exists($rol, $vista->_PAGE_PERMISSIONS)) {
        $pages_perm = $vista->_PAGE_PERMISSIONS[$rol];
        $show = !array_key_exists($vista->page, $pages_perm);
    }
    if ($show) {
        $res = $vista->_PAGE_CONFIG[$vista->page];
        if ($res["link"] != "") {
            if (is_file($res["link"])) {
                include $res["link"];
            } else {
                include $vista->_PAGE_CONFIG["500"]["link"];
            }
        } else {
            include $vista->_PAGE_CONFIG["500"]["link"];
        }
    } else {
        include $vista->_PAGE_CONFIG["404"]["link"];
    }
} else {

    include $vista->_PAGE_CONFIG["500"]["link"];
}
?>