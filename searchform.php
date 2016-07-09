<form action="<?php bloginfo('siteurl'); ?>" id="searchform" method="get">
    <div>
        <label for="s" class="screen-reader-text"><?php _e('Search for:', 'blueglass'); ?></label>
        <input type="search" id="s" name="s" value="" />
        
        <input type="submit" value="<?php _e('Search', 'blueglass'); ?>" id="searchsubmit" />
    </div>
</form>