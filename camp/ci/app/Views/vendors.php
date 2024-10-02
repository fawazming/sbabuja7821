
        <h5><a href="<?=base_url('/')?>">Home</a> > Buy pin from vendors</h5>
        <div class="row" style="background-color:#fff; padding: 10px 5px;">
            <?php foreach ($vendors as $key => $vendor): ?>
                <div class="col border">
                    <h3><?=$vendor['name']?></h3>
                    <p><?=$vendor['bank']?><br> <?=$vendor['acc_no']?> <br> <?=$vendor['acc_name']?></p>
                    <small><a href="https://wa.me/234<?=$vendor['phone']?>"><?=$vendor['phone']?></a></small>
                </div>
            <?php endforeach; ?>
        </div>