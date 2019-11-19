<h1>Maintenance_XH</h1>

<div class="maintenance_formwrap">
    <p class="maintenance_hint"><?=$this->hint?></p>
    <form id="maintenance_form" action="<?=$this->url()?>" method="post">
        <input type="hidden" name="admin" value="plugin_main">
        <?=$this->csrfToken()?>
        <p>
            <button id="mainenance_button" name="action" value="<?=$this->action?>"><?=$this->label?></button>
        </p>
    </form>
</div>