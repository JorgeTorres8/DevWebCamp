<h2 class="dashboard__heading"><?php echo $tittle; ?></h2>

<div class="dashboard__container-button"> 
    <a class="dashboard__button" href="/admin/events/create">
        <i class="fa-solid fa-circle-plus"></i>
        Add Events
    </a>
</div>

<div class="dashboard__container">
    <?php if(!empty($events)) { ?>
        
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Event</th>
                    <th scope="col" class="table__th">Category</th>
                    <th scope="col" class="table__th">Day and Hour</th>
                    <th scope="col" class="table__th">Speaker</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach($events as $events) { ?>
                        <tr class="table__tr">
                            <td class="table__td">
                                <?php echo $events->name;?>
                            </td>
                            <td class="table__td">
                                <?php echo $events->category->name;?>
                            </td>
                            <td class="table__td">
                                <?php echo $events->day->name . ", " . $events->hour->hour;?>
                            </td>
                            <td class="table__td">
                                <?php echo $events->speaker->name . " " . $events->speaker->lastname;?>
                            </td>
                            <td class="table__td--actions">
                                <a class="table__action table__action--edit" href="/admin/events/edit?id=<?php echo $events->id;?>">
                                    <i class="fa-solid fa-pencil"></i>
                                    Edit
                                </a>

                                <form method="POST" action="/admin/events/delete" class="form__table"> 
                                    <input type="hidden" name="id" value="<?php echo $events->id;?>">
                                    <button class="table__action table__action--delete" type="submt">
                                        <i class="fa-solid fa-circle-xmark"></i>
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                <?php } ?>
            </tbody>
        </table>

    <?php } else { ?>
        <p class="text-center">No Events Yet</p>
    <?php } ?>
</div>

<?php
    echo $pagination;
?>