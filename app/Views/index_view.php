
<?= $this->extend("layouts/base_view") ?>

<?= $this->section("content") ?>

<ul>
<?php
foreach ($users as $user) {
    echo "<li>$user[0] - $user[1]</li>";
}
// print_r($users);
?>
</ul>
<!-- <h1>THIS IS BODY</h1>
<h1>Arslaan</h1> -->


<?= $this->endSection("content") ?>

