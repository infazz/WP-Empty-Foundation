<footer id="footer">
		<section class="row">
        <div class="column medium-4">
          <div class="address"><span><?php _t('adress'); ?></span></div>
        </div>
        <div class="column medium-4">
          <div class="contact"><span><?php _t('phone'); ?><br><a href="mailto:<?php _t('email'); ?>"><?php _t('email'); ?></a></span></div>
        </div>
        <div class="column medium-4">
          <div class="facebook"><span><a href="https://facebook.com<?php _t('fb'); ?>" target="_blank"><?php _t('fb'); ?></a></span></div>
        </div>
    </section>
</footer>


<?php wp_footer(); ?>

<script src="<?php bloginfo('template_directory'); ?>/bower_components/foundation/js/foundation.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/jquery.mousewheel-3.0.6.pack.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/jquery.fancybox.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/jquery.fancybox-media.js"></script>

<script src="<?php bloginfo('template_directory'); ?>/js/app.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/functions.js"></script>

<!-- Asynchronous google analytics; this is the official snippet.
	 Replace UA-XXXXXX-XX with your site's ID and uncomment to enable.
	 
<script>

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-XXXXXX-XX']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
-->
	
</body>

</html>
