<?php
$this->view('header')
?>

<h1 class="p-3 text-center">PRODUCT CONTENT</h1>

<div class="row p-2 col-md-8 shadow mx-auto border rounded">
    <div class="my-3">
        <?php if (!empty($post)): ?>
            <?php $this->view('post-full', ['post' => $post]); ?>
        <?php endif; ?>
    </div>
</div>

<?php
$this->view('footer')
?>
