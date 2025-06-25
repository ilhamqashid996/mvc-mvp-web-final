<div class="row post p-1">
    <div class="col-3 bg-light text-center">
        <a href="<?=ROOT?>/profile/<?=$post->user->id?>">
            <img class="profile-image rounded-circle m-1" src="<?=get_image($post->user->image ?? '')?>" style="width: 80px; height: 80px; object-fit: cover;">
            <h5><?=esc($post->user->username ?? 'Unknown')?></h5>
        </a>
    </div>
    <div class="col-9 text-start">
        <div class="muted p-1"><?=get_date($post->date)?></div>
        <?php if(!empty($post->image)): ?>
            <a href="<?=ROOT?>/post/<?=$post->id?>">
                <img class="my-1" src="<?=get_image($post->image)?>" style="width: 200px; height: 200px; object-fit: cover;">
            </a>
        <?php endif; ?>
        <p><b><?=esc($post->post)?></b></p>
        <?php if(!empty($post->price)): ?>
            <p>Harga: <b>Rp. <?=esc($post->price)?>,00</b></p>
        <?php else: ?>
            <p>Harga: <b>Rp. 0,00</b></p>
        <?php endif; ?>
        <div class="d-none">
            <?php if (user('id') == $post->user_id): ?>        
                <a href="<?=ROOT?>/post/edit/<?=$post->id?>">
                    <button class="btn-sm m-1 btn btn-warning">Edit</button>
                </a>
                <a href="<?=ROOT?>/post/delete/<?=$post->id?>">
                    <button class="btn-sm m-1 btn btn-danger">Delete</button>
                </a>
            <?php endif; ?>
        </div>
        <div>
            <a href="<?=ROOT?>/post/<?=$post->id?>">
                <button class="btn-sm m-1 btn btn-primary">Show Post</button>
            </a>
        </div>
    </div>
</div><hr>
