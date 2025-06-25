<?php
$this->view('header')
?>

<h1 class="p-3 text-center">SEARCH PAGE</h1>
    <div class="row col-md-9 my-3 mx-auto justify-content-center">
        <?php if (!empty($rows)): ?>
            <?php foreach($rows as $row): ?>
                <?php
                $this->view('user-small', ['row' => $row]);
                ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

<?php
$this->view('footer')
?>
