<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="col-md-12 table-responsive">
    <table class="table table-striped">
        <thead>
            <th>Sr #</th>
            <th>Status</th>
            <th>Remark</th>
            <th>Date</th>
            <th>Time</th>
            <th>Employee</th>
        </thead>
        <tbody>
            <?php if($follows): ?>
                <?php foreach ($follows as $i => $follow): ?>
                    <tr>
                        <td><?= ++$i ?></td>
                        <td><?= $follow['status'] ?></td>
                        <td><?= $follow['remark'] ?></td>
                        <td><?= date('d-m-Y', strtotime($follow['created_date'])) ?></td>
                        <td><?= date('h:i A', strtotime($follow['created_time'])) ?></td>
                        <td><?= $follow['name'] ?></td>
                    </tr>
                <?php endforeach ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">
                        No follow ups available.
                    </td>
                </tr>
            <?php endif ?>
        </tbody>
    </table>
</div>