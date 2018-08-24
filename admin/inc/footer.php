
      <footer class="app-footer"> 
      <div class="row">
        <div class="col-xs-12">
          <div class="footer-copyright">
            © <?php echo date('Y'); ?> Desarrollado por <a href="" style="color: black;"> jwebdev.com</a>
          </div>
        </div>
      </div>
    </footer>
    </div>

  </div>
  
  <script type="text/javascript" src="<?php echo URL_BASE; ?>admin/assets/js/vendor.js"></script>
  <script type="text/javascript" src="<?php echo URL_BASE; ?>admin/assets/js/app.js"></script>
  <script type="text/javascript" src="<?php echo URL_BASE; ?>admin/assets/js/ajax.js"></script>
  <script src="<?php echo URL_BASE; ?>admin/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="<?php echo URL_BASE; ?>admin/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="<?php echo URL_BASE; ?>admin/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
  <script src="<?php echo URL_BASE; ?>admin/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
  <script src="<?php echo URL_BASE; ?>admin/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
  <script src="<?php echo URL_BASE; ?>admin/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
  <script src="<?php echo URL_BASE; ?>admin/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
  <script src="<?php echo URL_BASE; ?>admin/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
  <script src="<?php echo URL_BASE; ?>admin/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
  <script src="<?php echo URL_BASE; ?>admin/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo URL_BASE; ?>admin/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
  <script src="<?php echo URL_BASE; ?>admin/vendors/datatables.net-scroller/js/datatables.scroller.min.js"></script>
   <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
   <!-- Datatables -->
    <script>
      $(document).ready(function() {
        var handleDataTableButtons = function() {
          if ($("#datatable-buttons").length) {
            $("#datatable-buttons").DataTable({
              dom: "Bfrtip",
              buttons: [
                {
                  extend: "copy",
                  className: "btn-sm"
                },
                {
                  extend: "csv",
                  className: "btn-sm"
                },
                {
                  extend: "excel",
                  className: "btn-sm"
                },
                {
                  extend: "pdfHtml5",
                  className: "btn-sm"
                },
                {
                  extend: "print",
                  className: "btn-sm"
                },
              ],
              responsive: true
            });
          }
        };

        TableManageButtons = function() {
          "use strict";
          return {
            init: function() {
              handleDataTableButtons();
            }
          };
        }();

        $('#datatable').dataTable();

        $('#datatable-keytable').DataTable({
          keys: true
        });

        $('#datatable-responsive').DataTable();

        $('#datatable-scroller').DataTable({
          ajax: "js/datatables/json/scroller-demo.json",
          deferRender: true,
          scrollY: 380,
          scrollCollapse: true,
          scroller: true
        });

        $('#datatable-fixed-header').DataTable({
          fixedHeader: true
        });

        var $datatable = $('#datatable-checkbox');

        $datatable.dataTable({
          'order': [[ 1, 'asc' ]],
          'columnDefs': [
            { orderable: false, targets: [0] }
          ]
        });
        $datatable.on('draw.dt', function() {
          $('input').iCheck({
            checkboxClass: 'icheckbox_flat-green'
          });
        });

        TableManageButtons.init();
      });

    
  
    </script>
    <!-- /Datatables -->

    <!-- Show Alert -->
    <?php if (isset($_GET['bd'])): ?>
        <script type="text/javascript">
            showAlert(<?php echo '"'.$_GET['bd'].'"'; ?>,<?php echo '"'.$_GET['msn'].'"'; ?>);
        </script>
    <?php endif ?>
    <!-- /Show Alert -->
  
</body>
</html>