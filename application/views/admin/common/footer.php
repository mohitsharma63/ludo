</div>
</main>
  <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  <!--   Core JS Files   -->
  <script src="<?=base_url("assets/admin/assets/js/core/popper.min.js")?>"></script>
  <script src="<?=base_url("assets/admin/assets/js/core/bootstrap.min.js")?>"></script>
  <script src="<?=base_url("assets/admin/assets/js/plugins/perfect-scrollbar.min.js")?>"></script>
  <script src="<?=base_url("assets/admin/assets/js/plugins/smooth-scrollbar.min.js")?>"></script>
  <script src="<?=base_url("assets/admin/assets/js/plugins/chartjs.min.js")?>"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="<?=base_url("assets/admin/assets/js/soft-ui-dashboard.min.js?v=1.0.7")?>"></script>

  <script src="<?= base_url('assets/js/functions.js?v=' . VERSION) ?>"></script>
<script src="<?= base_url('assets/js/ajax.js?v=' . VERSION) ?>"></script>
<?php
if (isset($i_load_url)) {
?>
    <script>
        var i_load_url = "<?= $i_load_url ?>";
    </script>
    <script src="<?= base_url('assets/js/iload.js?v=' . VERSION) ?>"></script>
<?php
}
?>

<?php
if (isset($i_load_url2)) {
?>
    <script>
        var i_load_url2 = "<?= $i_load_url2 ?>";
    </script>
    <script src="<?= base_url('assets/js/iload2.js?v=' . VERSION) ?>"></script>
<?php
}
?>
<script>
    $(function() {
        <?php
        if (isset($_SESSION['done-msg'])) {
        ?>
            done('<?= $_SESSION['done-msg'] ?>')
        <?php
            unset($_SESSION['done-msg']);
        }


        if (isset($_SESSION['info-msg'])) {
        ?>
            info('<?= $_SESSION['info-msg'] ?>')
        <?php
            unset($_SESSION['info-msg']);
        }

        if (isset($_SESSION['error-msg'])) {
        ?>
            info('<?= $_SESSION['error-msg'] ?>')
        <?php
            unset($_SESSION['error-msg']);
        }
        ?>
    })
</script>
<?php
if(isset($_SESSION['AdminAuth'])){?>


    <script src="<?= base_url('assets/js/offline.js?v=' . VERSION) ?>"></script>
    <script src="<?= base_url('assets/js/fetch.js?v=' . VERSION) ?>"></script>
    <script src="<?= base_url('assets/js/realtime_stat.js?v=' . VERSION) ?>"></script>
<?php }
?>

</body>

</html>