<?php if ( $type == INVENTOR_WATCHDOG_TYPE_SEARCH_QUERY ): ?>
    <?php if ( Inventor_Watchdogs_Logic::is_my_watchdog( $type, $_GET ) ) : ?>
        <a class="inventor-watchdog-btn" href="<?php echo $_SERVER["REQUEST_URI"] ?>&watchdog-remove=true">
            <i class="fa fa-eye-slash"></i> Unwatch this search query
        </a><!-- /.inventor-watchdog-btn -->
    <?php else: ?>
        <a class="inventor-watchdog-btn" href="<?php echo $_SERVER["REQUEST_URI"] ?>&watchdog-add=true">
            <i class="fa fa-eye"></i> Watch this search query
        </a><!-- /.inventor-watchdog-btn -->
    <?php endif ; ?>
<?php endif ; ?>
