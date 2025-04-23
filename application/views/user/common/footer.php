</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="<?= base_url('assets/js/functions.js?v=' . VERSION) ?>"></script>
<script src="<?= base_url('assets/js/ajax.js?v=' . VERSION) ?>"></script>
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
<script src="<?= base_url('assets/js/install.js?v=' . VERSION) ?>"></script>
</body>

</html>