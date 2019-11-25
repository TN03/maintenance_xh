<?php

/**
 * 
 * @version $Id:  $
 *
 * Copyright 2019 Holger Irmler
 *
 * This file is part of Maintenance_XH.
 *
 * Maintenance_XH is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Maintenance_XH is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Maintenance_XH.  If not, see <http://www.gnu.org/licenses/>.
 */
function hi_Maintenance() {
    global $o, $plugin_cf, $pth, $plugin_tx, $pd_router, $s;

    $redir = FALSE;

    //Fix problem with $s on first page
    $pd['maintenance_redirect'] = '';
    if ($s > -1) {
        $pd = $pd_router->find_page(max($s, 0));
    }

    if (file_exists($pth['folder']['downloads'] . '.maintenance')) {
        $redir = $plugin_cf['maintenance']['url_global-redirects'] != '' 
                ? $plugin_cf['maintenance']['url_global-redirects']
                : $pth['folder']['plugins'] . 'maintenance/html/maintenance.html';
        $msg = $plugin_tx['maintenance']['global-on'];
        //TODO: prevent endless loop
        /*if (true) { 
            $redir = FALSE;
            $msg = $plugin_tx['maintenance']['wrong_url'];
            $o .= XH_message('fail', $msg);
        }*/
    } else {
        if ($pd['maintenance_redirect']) {
            $redir = $plugin_cf['maintenance']['url_single-redirects'] != '' 
                    ? $plugin_cf['maintenance']['url_single-redirects']
                    : $pth['folder']['plugins'] . 'maintenance/html/maintenance_single.html';
            $msg = $plugin_tx['maintenance']['single-on'];
        }
    }

    if ($redir && !isset($_GET['login']) && !XH_ADM) {
        $retryAfter = $plugin_cf['maintenance']['retry-after'] != ''
                ? $plugin_cf['maintenance']['retry-after']
                : 3600; //one hour
            
        header($_SERVER["SERVER_PROTOCOL"] . " 503 Service Temporarily Unavailable",
                true, 503);
        header('Retry-After: ' . $retryAfter);
        echo file_get_contents($redir);
        exit;
    }

    if (XH_ADM) {
        $temp = new Maintenance\Plugin;
        $temp->init();
        if ($redir) {
            $o = XH_message('warning', $msg) . $o;
        }
    }
}

hi_Maintenance();
