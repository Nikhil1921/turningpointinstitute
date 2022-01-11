<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="col-md-12 table-responsive">
    <table class="table table-striped">
        <thead>
            <th>Sr #</th>
            <th>Page</th>
            <th>Date</th>
            <th>Time</th>
        </thead>
        <tbody>
            <?php if($analytics): ?>
                <?php foreach ($analytics as $i => $analytic): ?>
                    <tr>
                        <td><?= ++$i ?></td>
                        <td><?= $analytic['page_name'] ?></td>
                        <td><?= date('d-m-Y', $analytic['date_time']) ?></td>
                        <td><?= date('h:i A', $analytic['date_time']) ?></td>
                    </tr>
                <?php endforeach ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">
                        No analytics available.
                    </td>
                </tr>
            <?php endif ?>
        </tbody>
    </table>
</div>