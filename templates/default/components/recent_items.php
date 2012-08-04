<h1>RECENT PASTES</h1>
<ul>
    <?php
    foreach ($this->recent as $idx => $entry) :
        $cls = '';
        if (isset($pid) && $entry['pid'] == $pid) {
            $cls = "highlight";
        }
    ?>
    <li class="<?= $cls ?>">
        <a href="<?= $entry['url'] ?>"><?= $entry['poster'] ?></a>
        <br/>
        <?= $entry['agefmt'] ?>
        <br /><br />
    </li>
    <?php endforeach; ?>
</ul>