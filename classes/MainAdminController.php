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

namespace Maintenance;

class MainAdminController
{
    /**
     * @var string
     */
    private $scriptName;

    /**
     * @var array
     */
    private $lang;

    /**
     * @var object
     */
    private $csrfProtector;

    public function __construct()
    {
        global $sn, $plugin_tx, $title, $_XH_csrfProtection;

        $this->scriptName = $sn;
        $this->lang = $plugin_tx['maintenance'];
        $this->csrfProtector = $_XH_csrfProtection;
        //$title = XH_hsc($this->lang['menu_main']);
    }

    public function defaultAction()
    {
        global $pth;
        
        if (!file_exists($pth['folder']['downloads'] . '.maintenance')) {
            $hint = $this->lang['off'];
            $label = $this->lang['toggle_on'];
            $action = 'enable';
        }
        else {
            $hint = $this->lang['on'];
            $label = $this->lang['toggle_off'];
            $action = 'disable';
        }
        $view = new View('main');
        $view->url = "{$this->scriptName}?&maintenance&normal";
        $view->admin = 'plugin_main';
        $view->csrfToken = new HtmlString($this->csrfProtector->tokenInput());
        $view->hint = $hint;
        $view->label = $label;
        $view->action = $action;
        //$cache = new CacheService;
        //$view->info = new HtmlString($cache->cacheInfo());
        $view->render();
    }
    
    public function enableAction() {
        global $pth;
        
        $file = $pth['folder']['downloads'] . ".maintenance";
        fclose(fopen($file, 'a'));
        header('Location: ' . CMSIMPLE_URL . '?&maintenance&admin=plugin_main&action=plugin_text&normal', true, 303);
        exit;
    }
    
    public function disableAction() {
        global $pth;
        
        $file = $pth['folder']['downloads'] . ".maintenance";
        unlink($file);
        header('Location: ' . CMSIMPLE_URL . '?&maintenance&admin=plugin_main&action=plugin_text&normal', true, 303);
        exit;
    }
    
}