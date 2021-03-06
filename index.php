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
    global $o, $plugin_cf, $pth, $plugin_tx, $pd_router, $pd_s, $u;

    $redir = FALSE;
    $pd['maintenance_redirect'] = '';
    $pd = $pd_router->find_page($pd_s); //use $pd_s instead $s
    
    if (file_exists($pth['folder']['downloads'] . '.maintenance')) {    
        $redir = $plugin_cf['maintenance']['url_global-redirects'] != '' 
                ? $plugin_cf['maintenance']['url_global-redirects']
                : $pth['folder']['plugins'] . 'maintenance/html/maintenance.html';
        $msg = $plugin_tx['maintenance']['global-on'];
        //prevent endless loop
        foreach ($u as $url) {
            if (stripos($plugin_cf['maintenance']['url_global-redirects']
                , $url) !== FALSE) {
                $redir = FALSE;
                $msg = $plugin_tx['maintenance']['wrong_url'];
                $o .= XH_message('fail', $msg);
                break;
            }
        }
    } else {
        if (isset($pd['maintenance_redirect'])
                && $pd['maintenance_redirect'] == '1') {
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
