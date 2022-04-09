<!DOCTYPE html>
<html lang="zxx">
<?= $this->include('frontend/layouts/header'); ?>

<?= $this->renderSection('css'); ?>
<style>
    .btn-sm {
        padding: 5px !important;
    }
</style>

<body id="top">

    <header>
        <?= $this->include('frontend/layouts/topbar'); ?>
        <?= $this->include('frontend/layouts/navbar'); ?>
    </header>

    <?= $this->renderSection('content'); ?>

    <?= $this->include('frontend/layouts/footer'); ?>
    <?= $this->include('frontend/layouts/script'); ?>

    <?= $this->renderSection('script'); ?>


    <!-- 
    Essential Scripts
    =====================================-->

</body>

</html>