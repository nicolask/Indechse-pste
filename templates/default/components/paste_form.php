<form name="editor" method="post" action="index.php" autocomplete="off">
    <input type="hidden" name="parent_pid" value="<?php echo $this->post['pid'] ?>"/>
    <div class="paste" id="pasteform">
        <div id="fmt">Language: <select name="format">
                <?php
// Show popular GeSHi formats
                foreach ($this->geshiformats as $code => $name) {
                    if (in_array($code, $this->popular_syntax)) {
                        $sel = ($code == $this->post['format']) ? "selected=\"selected\"" : "";
                        echo "<option $sel value=\"$code\">$name</option>";
                    }
                }

                echo "<option value=\"text\">----------------------------</option>";

// Show all GeSHi formats.
                foreach ($this->geshiformats as $code => $name) {
                    $sel = ($code == $this->post['format']) ? "selected=\"selected\"" : "";
                    if (in_array($code, $this->popular_syntax))
                        $sel = "";
                    echo "<option $sel value=\"$code\">$name</option>";
                }
                ?>
            </select>
        </div>

        <div id="notes">To highlight particular lines, prefix each line with <?php echo $this->highlight_prefix ?></div>

        <!-- Code edit box -->
        <textarea id="code" class="codeedit" name="code2" cols="90" rows="20" onkeydown="return catchTab(this,event)"><?php echo htmlspecialchars($this->post['code']) ?></textarea>
    </div>

    <div id="pasteInfo">
        <div class="end"></div>
        <!-- The name box -->
        <div id="namebox"> <label for="poster">Name/Title (Optional)</label><br/>
            <input type="text" maxlength="16" size="16" id="poster" name="poster" value="<?php echo $this->post['poster'] ?>" />
            <input type="submit" name="paste" value="Submit"/> <br />
        </div>

        <!-- The expiry buttons -->
        <div id="expirybox">
            <div id="expiryradios"><label>How long should we keep your paste?</label><br/> 
                <input type="radio" id="expiry_day" name="expiry" value="d" <?php if ($this->post['expiry_flag'] == 'd') echo 'checked="checked"'; ?> /> 
                <label id="expiry_day_label" for="expiry_day">One day</label>
                <input type="radio" id="expiry_month" name="expiry" value="m" <?php if ($this->post['expiry_flag'] == 'm') echo 'checked="checked"'; ?> /> 
                <label id="expiry_month_label" for="expiry_month">One month</label>
                <input type="radio" id="expiry_forever" name="expiry" value="f" <?php if ($this->post['expiry_flag'] == 'f') echo 'checked="checked"'; ?> /> 
                <label id="expiry_forever_label" for="expiry_forever">Forever</label>
            </div>
            <div id="expiryinfo"></div>
        </div>

        <!-- The password box -->
        <div id="password">
            <label class="passProtected" for="password">Password (Optional)</label><br />
            <input type="password" class="bringDown" size="21" value="<?= $this->post['password']; ?>" name="password" />
        </div>

        

        <div class="end"></div>
    </div>
</form>