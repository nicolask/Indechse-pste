<?php
$this->headTitle($this->post['poster']);
require_once('Pste/View/helpers/HeadStyle.php');
?>
<div class="paste" id="paste">
    <?php $this->headStyle($this->post['codecss'], 'codecss') ?>

    <h1>
        <?= $this->post['posttitle'] ?>
        <br/>
        <a href="<?= $this->post['downloadurl'] ?>" title="Download this paste">Download</a> | 
        <a href="<?= $this->url ?>?submit" title="Make a new paste">New paste</a>
    </h1>
    <div id="syntax">
        <?= $this->post['codefmt'] ?>
    </div>
</div>