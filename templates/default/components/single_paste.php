<?php
$this->headTitle($this->post['poster']);
require_once('Pste/View/helpers/HeadStyle.php');
?>
<div class="paste" id="paste">
    <form name="language_switch" method="GET" action="">
    <div>Display Language: 
        <select name="udf">
                <?php
// Show popular GeSHi formats
                foreach ($this->geshiformats as $code => $name) {
                    if (in_array($code, $this->popular_syntax)) {
                        $sel = ($code == $this->format) ? "selected=\"selected\"" : "";
                        echo "<option $sel value=\"$code\">$name</option>";
                    }
                }

                echo "<option value=\"text\">----------------------------</option>";

// Show all GeSHi formats.
                foreach ($this->geshiformats as $code => $name) {
                    $sel = ($code == $this->format) ? "selected=\"selected\"" : "";
                    if (in_array($code, $this->popular_syntax))
                        $sel = "";
                    echo "<option $sel value=\"$code\">$name</option>";
                }
                ?>
        </select>
        <input type="submit" value="switch" />
    </form>
    </div>
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