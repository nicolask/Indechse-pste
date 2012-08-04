<div class="paste">
    <h1>Archive (<?= $this->count ?> pastes available)</h1>
    <div>
        <?php
        $pageNum = 1;
        do {
            $style = $pageNum == $this->page ? 'font-size: 1.5em' : '';
            printf('<a style="padding-right:10px; %3$s" href="%1$s?archive&page=%2$s">%2$s</a>', $this->url, $pageNum, $style);

            $pageNum++;
        } while ((($pageNum - 1) * $this->itemsPerPage) <= $this->count);
        ?>
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