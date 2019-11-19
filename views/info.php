<h1>Maintenance_XH</h1>
<p>
    Version: <?=$this->version()?> &copy; 2019 <a href="http://cmsimple.holgerirmler.de/">Holger Irmler</a>
</p>
<hr>
<p class="maintenance_license">
    Maintenance_XH is free software: you can redistribute it and/or modify it
    under the terms of the GNU General Public License as published by the Free
    Software Foundation, either version 3 of the License, or (at your option)
    any later version.
</p>
<p class="maintenance_license">
    Maintenance_XH is distributed in the hope that it will be useful, but
    <em>without any warranty</em>; without even the implied warranty of
    <em>merchantability</em> or <em>fitness for a particular purpose</em>. See
    the GNU General Public License for more details.
</p>
<p class="maintenance_license">
    You should have received a copy of the GNU General Public License along with
    Maintenance_XH. If not, see <a
    href="http://www.gnu.org/licenses/">http://www.gnu.org/licenses/</a>.
</p>
<div class="maintenance_syscheck">
    <h2><?=$this->text('syscheck_title')?></h2>
<?php foreach ($this->checks as $check):?>
    <p class="xh_<?=$this->escape($check->state)?>"><?=$this->text('syscheck_message', $check->label, $check->stateLabel)?></p>
<?php endforeach?>
</div>

