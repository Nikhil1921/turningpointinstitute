<?php defined('BASEPATH') OR exit('No direct script access allowed');
$colors = ['yellow', 'green', 'pink', 'lite-green'] ?>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-3" onclick="window.location.href = '<?= base_url(admin('student')) ?>'">
            <div class="card bg-c-<?= $colors[array_rand($colors)] ?> update-card">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white"><?= $student ? $student : 0 ?></h4>
                            <h6 class="text-white m-b-0">Total Students</h6>
                        </div>
                        <div class="col-4 text-right"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                            <i class="fa fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3" onclick="window.location.href = '<?= base_url(admin('ebook')) ?>'">
            <div class="card bg-c-<?= $colors[array_rand($colors)] ?> update-card">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white">₹ <?= $ebook ? $ebook : 0 ?></h4>
                            <h6 class="text-white m-b-0">Ebooks</h6>
                        </div>
                        <div class="col-4 text-right"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                            ₹
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3" onclick="window.location.href = '<?= base_url(admin('module')) ?>'">
            <div class="card bg-c-<?= $colors[array_rand($colors)] ?> update-card">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white"><?= $module ? $module : 0 ?></h4>
                            <h6 class="text-white m-b-0">Module</h6>
                        </div>
                        <div class="col-4 text-right"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                            <i class="fa fa-table"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3" onclick="window.location.href = '<?= base_url(admin('moduleVideo')) ?>'">
            <div class="card bg-c-<?= $colors[array_rand($colors)] ?> update-card">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white"><?= $video ? $video : 0 ?></h4>
                            <h6 class="text-white m-b-0">Videos</h6>
                        </div>
                        <div class="col-4 text-right"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                            <i class="fa fa-question-circle-o"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>