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

class Plugin {

    const VERSION = '2.0-beta.2';

    /**
     * @var string
     */
    private $admin;

    /**
     * @var string
     */
    private $action;

    /**
     * @var string
     */
    private $plugin;

    /**
     * @var bool
     */
    private $maintenance;

    public function __construct() {
        global $plugin_tx, $action, $plugin, $maintenance;

        $this->lang = $plugin_tx['maintenance'];
        $this->admin = isset($_GET['admin']) ? $_GET['admin'] : (isset($_POST['admin'])
                    ? $_POST['admin'] : null);
        $this->action = $action;
        $this->plugin = $plugin;
        $this->maintenance = isset($maintenance) ? true : false;
    }

    public function init() {
        global $pth, $pd_router, $plugin_tx;
        $pd_router->add_interest('maintenance_redirect');
        if (XH_ADM) {
            if (function_exists('XH_registerStandardPluginMenuItems')) {
                XH_registerStandardPluginMenuItems(true);
            }
            if ($this->isAdministrationRequested()) {
                $this->handleAdministration();
            }
            $pd_router->add_tab(
                $plugin_tx['maintenance']['tab_title'],
                "{$pth['folder']['plugins']}maintenance/maintenance_view.php"
            );
        }
    }

    /*
    public function isMaintenance() {
        global $pth;
        return file_exists($pth['folder']['downloads'] . '.maintenance') ? 
                true : false;
    }
    */

    /**
     * @return bool
     */
    private function isAdministrationRequested() {
        return function_exists('XH_wantsPluginAdministration') 
            && XH_wantsPluginAdministration('maintenance')
            || $this->maintenance;
    }

    private function handleAdministration() {
        global $o;

        $o .= print_plugin_admin('on');
        switch ($this->admin) {
            case '':
                $o .= (string) $this->prepareInfoView();
                break;
            case 'plugin_main':
                $this->handleMainAdministration();
                break;
            default:
                $o .= plugin_admin_common($this->admin, $this->action,
                        $this->plugin);
        }
    }

    /**
     * @return View
     */
    private function prepareInfoView() {
        global $title, $pth;

        $title = "Maintenance_XH";
        $view = new View('info');
        $view->version = self::VERSION;
        //$view->logo = "{$pth['folder']['plugins']}maintenance/maintenance.png";
        $systemCheckService = new SystemCheckService;
        $view->checks = $systemCheckService->getChecks();
        return $view;
    }

    private function handleMainAdministration() {
        global $o;

        $controller = new MainAdminController();
        $action = "{$this->action}Action";
        if (!method_exists($controller, $action)) {
            $action = 'defaultAction';
        }
        ob_start();
        $controller->$action();
        $o .= ob_get_clean();
    }

}
