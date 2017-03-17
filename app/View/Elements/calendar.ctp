<!-- File: /app/Vendor/mail.ctp -->

<div class="box_indent"></div>

<div id="Calendar">
    <fieldset>
        <legend class="form_info"><?php echo __('Calendar'); ?></legend>

        <table>
            <tr>
                <th>日</th>
                <th>月</th>
                <th>火</th>
                <th>水</th>
                <th>木</th>
                <th>金</th>
                <th>土</th>
            </tr>

            <tr>
                <?php $cnt = 0; ?>
                <?php foreach ($calendar as $key => $value): ?>
                    <td>
                        <?php $cnt++; ?>
                        <?php echo $value['day']; ?>
                    </td>

                    <?php if ($cnt == 7): ?>
                        </tr>
                        <tr>
                        <?php $cnt = 0; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tr>
        </table>

    </fieldset>
</div>
