<?php

/**
 * Copyright (c) Holger Irmler
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

function Maintenance_view($pageData)
{
    global $sn, $su, $plugin_tx;

    $action = XH_hsc("$sn?$su");
    $checkedAttr = $pageData['maintenance_redirect'] ? ' checked="checked"' : '';
    return <<<HTML
<form id="pd_multionepage" action="$action" method="post">
    <p>
        <b>{$plugin_tx['maintenance']['tab_title']}</b>
    </p>
    <p>
        <label>
            <span>{$plugin_tx['maintenance']['tab_redirect']}</span>
            <input type="hidden" name="maintenance_redirect" value="0">
            <input type="checkbox" name="maintenance_redirect" value="1" {$checkedAttr}>
        </label>
    </p>
    <p>
        <button name="save_page_data">{$plugin_tx['maintenance']['tab_save']}</button>
    </p>
</form>
HTML;
}
