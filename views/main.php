<h1>Maintenance_XH</h1>

<div class="maintenance_formwrap">
    <p class="maintenance_hint"><?= $this->hint ?></p>
    <form id="maintenance_form" action="<?= $this->url ?>" method="post">
        <input type="hidden" name="admin" value="plugin_main">
        <?= $this->csrfToken() ?>
        <p>
            <button id="mainenance_button" name="action" value="<?= $this->action ?>"><?= $this->label ?></button>
        </p>
    </form>
</div>

<div class="maintenance_pagelinks">
    <hr>
    <p><?= $this->escape($this->hintlinklist) ?></p>
    <?php if (count($this->pagelinks) > 0): ?><ul><?php endif; ?>
        <?php foreach ($this->pagelinks as $link): ?>
            <li><a href="<?= $link['url'] ?>"><?= $link['heading'] ?></a></li>
        <?php endforeach ?>
    <?php if (count($this->pagelinks) > 0):  ?></ul><?php endif; ?>
    <p><?= count($this->pagelinks) ?> <?= $this->escape($this->nbrpages) ?></p>
    <hr>
</div>
