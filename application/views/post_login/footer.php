        </section>
		<script>
		var validate = function(e) {
          var t = e.value;
          e.value = (t.indexOf(".") >= 0) ? (t.substr(0, t.indexOf(".")) + t.substr(t.indexOf("."), 3)) : t;
         }
		$(document).ready(function() {
			$('.select2').select2();
		});
        </script>
        <footer class="sticky-footer" style="background-color: #333; text-align: center;">

           <span style="line-height: 5; font-size: 12px; color: #fff;"><strong>Copyright © BSPWA 2024</strong></span>

        </footer>

    </body>
<!-- 

    <script>
        get_notification();
        function get_notification(){
           
            $.ajax({
						url: "<?=site_url('notification/count')?>",
						method: "POST",
						dataType: "JSON",
						data: {
							action: "",
						},
						success: function (data) {

							$('#notification').html(data);
							
						}
					})
        }


        get_notification_list();
        function get_notification_list(){
            $.ajax({
						url: "<?=site_url('notification/sow10')?>",
						method: "POST",
						dataType: "JSON",
						data: {
							action: "",
						},
						success: function (data) {
							$('#listmotification').html(data);
						}
					})
        }
    </script> -->

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

</html>