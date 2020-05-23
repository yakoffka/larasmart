<?php

$n ??= 1;
$color ??= '00ccff';
$error ??= 'something happened..';

?>

<div class="container">
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="<?= ($n * 2 + 5) ?>000">
        <div class="toast-header">
            <svg class="bd-placeholder-img mr-2 rounded-circle" width="20" height="20"
                 xmlns="http://www.w3.org/2000/svg"
                 preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
                <rect fill="#<?= $color ?>" width="100%" height="100%"></rect>
            </svg>
            <strong class="mr-auto">Notification #<?= $n ?></strong>
            <!--<small class="text-muted">validation error</small>-->
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            <?= $error ?>
        </div>
    </div>
</div>
