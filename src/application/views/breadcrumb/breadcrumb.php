<div class="content-header">
    <h3>
        <?php echo $active_title["active_title"]; // echo "&nbsp;";
        ?>
    </h3>

    <ol class="breadcrumb">
        <?php
        if (is_array($breadcrumb)) {
            $idx_node = 0;
            $color = "";
            $items = count($breadcrumb);
            foreach ($breadcrumb as $v) {
                if (++$idx_node === $items) {
                    $node_active = "active";
                    $color = "red";
                } else {
                    $node_active = "";
                    $color = "";
                }
        ?>

        <li class="breadcrumb-item active">
            <a href="<?= $v->url ?>" style="color:<?= $color ?>"><?= $v->icon ?><?= $v->menu_name ?></a>
        </li>
        <?php }
        } 
		?>
    </ol>
</div>