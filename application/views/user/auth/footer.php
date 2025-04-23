</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="<?= base_url('assets/js/functions.js?v=' . VERSION) ?>"></script>
<script src="<?= base_url('assets/js/ajax.js?v=' . VERSION) ?>"></script>
<script>
    $(function() {
        <?php
        if (isset($_SESSION['done-msg'])) {
        ?>
            done("<?= $_SESSION['done-msg'] ?>")
        <?php
            unset($_SESSION['done-msg']);
        }


        if (isset($_SESSION['info-msg'])) {
        ?>
        $(function(){
            info("<?= $_SESSION['info-msg'] ?>")
        })
          
        <?php
            unset($_SESSION['info-msg']);
        }

        if (isset($_SESSION['error-msg'])) {
        ?>
            info("<?= $_SESSION['error-msg'] ?>")
        <?php
            unset($_SESSION['error-msg']);
        }
        ?>
    })
</script>

<?php
if (isset($gameid)) {
?>
    <script>
        var actionUrlForMatches = "<?= base_url('user/loadmatchdata/' . User::secure('encrypt', $gameid)) ?>"
    </script>
    <script src="<?= base_url('assets/js/load.js?v=' . VERSION) ?>"></script>
<?php
}
?>

<?php
if (isset($matchid)) {
?>
    <script>
        var actionUrlForMatch = "<?= base_url('user/getmatchinfo/' . $matchid) ?>"
    </script>
    <script src="<?= base_url('assets/js/getmatchinfo.js?v=' . VERSION) ?>"></script>
<?php
}
?>

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
<script src="<?= base_url('assets/js/install.js?v=' . VERSION) ?>"></script>
<script src="<?= base_url('assets/js/online.js?v=' . VERSION) ?>"></script>
</body>

</html>