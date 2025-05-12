<?php if (number_format($dataList["numRowsAll"]) > 0) { ?>

<div class="col-md-12" id="show_data">

    <?php

        if (is_array($dataList)) {

            $i = 0;

            foreach ($dataList["result"] as $key => $v) {

                $i++;

        ?>

    <div class="card-header-custom">

        <div data-toggle="collapse" data-target="#template<?= $i ?>" onclick="tg_tp_row(<?= $i ?>)">

            <span id="tg_tp_row<?= $i ?>">+</span>

            <span style="color:blue">

                <?= $v['levelName'] ?>

            </span>

            <span style="font-size: 18px;font-weight:bold;font-family:THSarabunNew">( <?= $v['num_template'] ?>
                ชุดข้อสอบ

                )</span>

        </div>

    </div>



    <?php

                $this->load->view("exam_library/show_template", array(

                    "i" => $i,

                    "occ_level_id" => $v["occ_level_id"]

                ));
            }



            if (!empty($dataList)) {

                echo " <br />";

                $this->load->view("pagination/show_pagination", array(

                    "dataList" => $dataList

                ));
            }
        }
    } else { ?>

    <div style="font-weight:bold;color:red;text-align:center">

        <br> == ไม่พบข้อมูล ==

    </div>

    <?php }

    ?>

</div>