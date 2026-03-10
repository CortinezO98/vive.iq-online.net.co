    <!-- ==============>>Footer section start here<<================ -->

    <!-- ==============>>Footer section end here<<================ -->

    <!-- Libs JS -->
    <script>
    if (typeof window.jQuery === 'undefined') {
        document.write('<script src="<?php echo LIBS; ?>jquery/dist/jquery.min.js"><\/script>');
    }
    </script>
    <script src="<?php echo LIBS; ?>bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo LIBS; ?>feather-icons/dist/feather.min.js"></script>
    <script src="<?php echo LIBS; ?>simplebar/dist/simplebar.min.js"></script>

    <!-- Theme JS -->
    <script src="<?php echo JS; ?>theme.min.js"></script>
 
    <!-- jsvectormap -->
    <!-- <script src="<?php echo LIBS; ?>jsvectormap/dist/js/jsvectormap.min.js"></script>
    <script src="<?php echo LIBS; ?>jsvectormap/dist/maps/world.js"></script>
    <script src="<?php echo LIBS; ?>apexcharts/dist/apexcharts.min.js"></script> -->
    <script src="<?php echo JS; ?>vendors/chart.js"></script>
    <script src="<?php echo PLUGINS; ?>bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <?php include INCLUDES.'inc_footer_js.php'; ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const header = document.querySelector('.com-dynamic-header');
        if (!header) return;

        let lastScrollTop = 0;
        const scrollThreshold = 50; // Píxeles a partir de los cuales se considera scroll

        window.addEventListener('scroll', function() {
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        if (Math.abs(scrollTop - lastScrollTop) > scrollThreshold) {
            if (scrollTop > lastScrollTop && scrollTop > header.offsetHeight) {
            // Scroll hacia abajo: ocultar header
            header.classList.add('com-header-hidden');
            } else {
            // Scroll hacia arriba: mostrar header
            header.classList.remove('com-header-hidden');
            }
            lastScrollTop = scrollTop;
        }
        });
    });
    </script>
</body>
</html>