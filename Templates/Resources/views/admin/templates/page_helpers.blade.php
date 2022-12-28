<?php if ( (int)$pages > 0 ): ?>
<table id="tableHelpers" class="pdfs" style="width: 50%;border: 1px solid #cbd3d4!important;border-top-width: 0;border-collapse: collapse;">
    <thead>
    <tr id="heading">
        <th class="pdfs"><?php echo __('Page #') ?></th>
        <th class="pdfs"><?php echo __('Helpers') ?></th>
    </tr>
    </thead>
    <?php for ( $i = 0; $i < $pages; $i++ ): ?>
    <tbody>
    <tr <?php if ( ! $i ): ?>class="gridshadow" <?php endif; ?>>
        <td><?php echo __('Page ') . ($i + 1) . ' ' . __('Helpers'); ?></td>
        <td>
            <select multiple="multiple" name="editors_options[pages_helpers][<?php echo $i; ?>][]">
                <?php foreach ( $helpers as $h ): ?>
                <?php
                $helperId = $h->id;
                ?>
                <option value="<?php echo $helperId; ?>" <?php echo in_array($helperId,
                    $editors_options['pages_helpers'][$i]) ? 'selected="selected"' : '' ?>><?php echo $h->name; ?></option>
                <?php endforeach; ?>
            </select>
        </td>
    </tr>
    </tbody>
    <?php endfor; ?>
</table>
<?php endif; ?>
