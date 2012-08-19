<div class="paste">
    <h1>Archive (<?= $this->count ?> pastes available)</h1>
    <div class="paginator">
        <?php
            $maxPage = ((int)($this->count/$this->itemsPerPage))+1
        ?>
        <?php if ($this->page > 2) : ?>
        <a href="<?=$this->url ?>?archive&page=1">
            <img src="<?=$this->route()->templateRessourceUrl('images/gtk_goto_first_ltr.png') ?>" />
        </a> 
        <?php else: ?>
        <img src="<?=$this->route()->templateRessourceUrl('images/gtk_goto_first_ltr.png') ?>" />
        <?php endif; ?>
        <?php if ($this->page > 1) : ?>
        <a href="<?=$this->url ?>?archive&page=<?= $this->page-1 ?>">
            <img src="<?=$this->route()->templateRessourceUrl('images/gtk_go_forward_rtl.png') ?>" />
        </a>
        <?php else: ?>
        <img src="<?=$this->route()->templateRessourceUrl('images/gtk_go_forward_rtl.png') ?>" />
        <?php endif; ?>
        <span class="page-enum">
        <?php
        $pageNum = $this->page-2;
        $maxNum = $this->page+2;
        $minDiff = $pageNum - 1;
        $maxDiff = $maxPage - $maxNum;
        if ($maxDiff < 0 && $minDiff > 0) {
            $pageNum -= abs($maxDiff) > $minDiff ? $minDiff : abs($maxDiff);
        }
        if ($minDiff < 0 && $maxDiff > 0) {
            $maxNum += abs($minDiff) > $maxDiff ? $maxDiff : abs($minDiff);
        }
        $pageNum = $pageNum < 1 ? 1 : $pageNum;
        $maxNum = $maxNum > $maxPage ? $maxPage : $maxNum;
        
        do {
            $style = $pageNum == $this->page ? 'font-size: 1.5em' : '';
            printf('<a style="padding-right:10px; %3$s" href="%1$s?archive&page=%2$s">%2$s</a>', $this->url, $pageNum, $style);

            $pageNum++;
        } while ($pageNum <= $maxNum);
        ?>
        </span>
        <?php if ($this->page+1 <= $maxPage) :  ?>
        <a href="<?=$this->url ?>?archive&page=<?= $this->page+1 ?>">
            <img src="<?=$this->route()->templateRessourceUrl('images/gtk_go_forward_ltr.png') ?>" />
        </a>
        <?php else: ?>
        <img src="templates/default/images/gtk_go_forward_ltr.png" />
        <?php endif; ?>
        <?php if ($this->page+1 < $maxPage) :  ?>
        <a href="<?=$this->url ?>?archive&page=<?= $maxPage ?>">
            <img src="<?=$this->route()->templateRessourceUrl('images/gtk_goto_last_ltr.png') ?>" />
        </a> 
        <?php else: ?>
        <img src="<?=$this->route()->templateRessourceUrl('images/gtk_goto_last_ltr.png') ?>" />
        <?php endif; ?>
        
        <br />
        
    </div>

    <table class="archive">
        <tr><th></th><th>Name</th><th class="padright">Language</th><th>Posted on</th><th>Expires</th></tr>
        <?php
        foreach ($this->pastes as $row) :
            $pass = (0 == strcmp(sha1("EMPTY"), $row['password'])) ? "" : "<img src=\"templates/default/images/lock.png\" title=\"Password protected\" />";
            ?>

            <tr>
                <td><?= $pass ?></td>
                <td class="padright">
                    <a title="<?= date("l F j, Y, g:i a", strtotime($row['posted'])) ?>"
                       href="<?= $this->url ?><?= $row['pid'] ?>">
    <?= $row['poster'] ?>
                    </a>
                </td>
                <td><?= $row['format'] ?></td>
                <td class="padright"><?= date("m-d-y, g:i A", strtotime($row['posted'])) ?></td>
                <td> <?= ((is_null($row['expires'])) ? "Never" : date("m-d-y, g:i A", strtotime($row['expires']))) ?></td>
            </tr>
<?php endforeach; ?>

    </table>
</div>