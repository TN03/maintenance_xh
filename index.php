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
    global $o, $pth, $plugin_tx, $pd_router, $s;
    
    $pd['maintenance_redirect'] = '';
    if ($s > -1) {
        $pd = $pd_router->find_page(max($s, 0));
    }

    if (file_exists($pth['folder']['downloads'] . '.maintenance') || $pd['maintenance_redirect']) {
        if (!isset($_GET['login']) && !XH_ADM) {
            //header("Location: " . $pth['folder']['plugins'] . 'maintenance/html/maintenance.html', true, 302);
            header($_SERVER["SERVER_PROTOCOL"] . " 503 Service Temporarily Unavailable",
                    true, 503);
            header('Retry-After: 3600'); //one hour
            echo file_get_contents($pth['folder']['plugins'] . 'maintenance/html/maintenance.html');
            exit;
        }
    }

    if (XH_ADM) {
        $temp = new Maintenance\Plugin;
        $temp->init();
        if (file_exists($pth['folder']['downloads'] . '.maintenance') || $pd['maintenance_redirect']) {
            $o = XH_message('warning', $plugin_tx['maintenance']['on']) . $o;
        }
    }
}

hi_Maintenance();
