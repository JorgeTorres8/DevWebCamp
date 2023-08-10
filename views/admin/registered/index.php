<h2 class="dashboard__heading"><?php echo $tittle; ?></h2>

<div class="dashboard__container">
    <?php if(!empty($registered)) { ?>
        
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Name</th>
                    <th scope="col" class="table__th">Email</th>
                    <th scope="col" class="table__th">Plan</th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach($registered as $record) { ?>
                        <tr class="table__tr">
                            <td class="table__td">
                                <?php echo $record->user->name. " " . $record->user->lastname; ?>
                            </td>

                            <td class="table__td">
                                <?php echo $record->user->email; ?>
                            </td>

                            <td class="table__td">
                                <?php echo $record->package->name; ?>
                            </td>
                        </tr>
                <?php } ?>
            </tbody>
        </table>

    <?php } else { ?>
        <p class="text-center">No Registered Users Yet</p>
    <?php } ?>
</div>

<?php
    echo $pagination;
?>