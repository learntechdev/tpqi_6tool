<div class="col-md-12">

    <strong>การประเมินผล</strong>

</div>

<div class="col-md-12">

    <table id="tb" border="1" width="100%" style="border-collapse: collapse;">

        <thead>

            <tr style="background:#CFCFCF">

                <th width="45%" style="text-align:center;font-weight:bold">คำถาม

                </th>

                <th width="44%" style="text-align:center;font-weight:bold">แนวทางคำตอบ

                </th>

                <th width="11%" style="text-align:center;font-weight:bold">คะแนน

                </th>

            </tr>

        </thead>

        <input type="hidden" name="uoc_code_count" id="uoc_code_count" value="<?= count($template_detail) ?>">

        <?php

        if (is_array($template_detail)) {

            $tmp_uoc_code = "";

            $tmp_eoc_code = "";

            foreach ($template_detail as $v_detail) {
                $j = 1;
                $uoc_code = $this->SharedModel->get_uocname($v_detail->uoc_code);
                $j++;
        ?>

        <?php if ($tmp_uoc_code != $v_detail->uoc_code) { ?>

        <tr>

            <td colspan="3" style="background-color:#F1F1F1">

                <strong>

                    <?php echo $uoc_code["uoc_id"] . " " . $uoc_code["uoc_name"]; ?>

                </strong>

            </td>

        </tr>

        <?php

                    $tmp_uoc_code = $v_detail->uoc_code;
                    $j = 1;
                } ?>

        <tbody>

            <tr>

                <td>

                    <?php echo   $j . "." . " " . $v_detail->question; ?>

                </td>

                <td>

                    <?php echo $v_detail->guide_answer; ?>

                </td>

                <td style="text-align:center">

                    <div class="col-md-12">

                        <input type="hidden"
                            id="list[<?= $v_detail->uoc_code ?>][<?= $v_detail->order_line ?>][uoc_code]"
                            name="list[<?= $v_detail->uoc_code ?>][<?= $v_detail->order_line ?>][uoc_code]"
                            value="<?= $v_detail->uoc_code ?>" />

                        <input type="hidden"
                            id="list[<?= $v_detail->uoc_code ?>][<?= $v_detail->order_line ?>][order_line]"
                            name="list[<?= $v_detail->uoc_code ?>][<?= $v_detail->order_line ?>][order_line]"
                            value="<?= $v_detail->order_line ?>" />

                        <input type="number" class="form-control score" placeholder="กรอกคะแนน"
                            id="list[<?= $v_detail->uoc_code ?>][<?= $v_detail->order_line ?>][score]"
                            name="list[<?= $v_detail->uoc_code ?>][<?= $v_detail->order_line ?>][score]" />

                    </div>

                </td>

            </tr>

            <!-- <tr>

                <td colspan="3">

                    <?php $this->load->view(
                        "richtext/richtext",

                        array(

                            "id" => "list[$v_detail->uoc_code][$j][note]",

                        )
                    ); ?>

                </td>

            </tr>-->



        </tbody>

        <?php

            }
        }

        ?>

    </table>

</div>

<br />