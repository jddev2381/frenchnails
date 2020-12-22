


		<footer class="main">

		</footer>


        <script src="<?php echo SITE_URL; ?>/js/main.js"></script>

        <?php

        	if($hands) {
        		echo '<script> showh1(); </script>';
        	}
        	if(!empty($handsOption1)) {
        		if($handsOption1 == 'mani') {
        			echo '<script> showh21(); </script>';
        		} else {
        			echo '<script> showh22(); </script>';
        		}
			    
			}
			


			if($feet) {
        		echo '<script> showf1(); </script>';
        	}
			if(!empty($feetOption1)) {
				if($feetOption1 == 'pedi') {
					echo '<script> showf21(); </script>';
				} else {
					echo '<script> showf22(); </script>';
				}
			    
			}


        ?>

    </body>

</html>