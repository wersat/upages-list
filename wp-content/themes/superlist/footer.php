<?php
  /**
   * The template for displaying the footer
   * @package Superlist
   * @since   Superlist 1.0.0
   */
?>

<?php dynamic_sidebar('bottom'); ?>
</div>
</div>
</div>
<footer class="footer">
  <?php if (is_active_sidebar('footer-first') || is_active_sidebar('footer-second') || is_active_sidebar('footer-top-first') || is_active_sidebar('footer-top-second') || is_active_sidebar('footer-top-third') || is_active_sidebar('footer-top-fourth')) : ?>
    <div class="footer-top">
      <?php if (is_active_sidebar('footer-top-first') || is_active_sidebar('footer-top-second') || is_active_sidebar('footer-top-third') || is_active_sidebar('footer-top-fourth')) : ?>
        <div class="footer-area">
          <div class="container">
            <div class="row">
              <div class="col-sm-3">
                <?php dynamic_sidebar('footer-top-first'); ?>
              </div>
              <div class="col-sm-3">
                <?php dynamic_sidebar('footer-top-second'); ?>
              </div>
              <div class="col-sm-3">
                <?php dynamic_sidebar('footer-top-third'); ?>
              </div>
              <div class="col-sm-3">
                <?php dynamic_sidebar('footer-top-fourth'); ?>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <?php if (is_active_sidebar('footer-first') || is_active_sidebar('footer-second')) : ?>
        <div class="container">
          <div class="footer-top-inner">
            <?php if (is_active_sidebar('footer-first')) : ?>
              <div class="footer-first">
                <?php dynamic_sidebar('footer-first'); ?>
              </div>
            <?php endif; ?>

            <?php if (is_active_sidebar('footer-second')) : ?>
              <div class="footer-second">
                <?php dynamic_sidebar('footer-second'); ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      <?php endif; ?>
    </div>
  <?php endif; ?>

  <?php if (is_active_sidebar('footer-bottom-first') || is_active_sidebar('footer-bottom-second')) : ?>
    <div class="footer-bottom">
      <div class="container">
        <div class="footer-bottom-inner">
          <div class="footer-bottom-first">
            <?php dynamic_sidebar('footer-bottom-first'); ?>
          </div>
          <div class="footer-bottom-second">
            <?php dynamic_sidebar('footer-bottom-second'); ?>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
</footer>
</div>
<?php get_template_part('templates/modal'); ?>

<?php wp_footer(); ?>
</body>
</html>
