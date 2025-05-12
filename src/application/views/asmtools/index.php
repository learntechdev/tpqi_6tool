<section class="content">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-12">
                        <label for=""><strong>เครื่องมือประเมินอื่น 6 ประเภท
                            </strong></label>
                    </div>
                </div>
                <hr />
                <div class="row">
                    <?php
                    if (is_array($menu_asmtool)) {
                        foreach ($menu_asmtool as $v) {

                            if ($v->tool_type == "") {
                    ?>
                    <div class="col-12 col-md-6">
                        <div class="box box-body pull-up" style="margin-bottom:15px !important">
                            <a href="<?= $v->url ?>">
                                <div class="media align-items-center p-0">
                                    <div class="text-center">
                                        <i class="cc DASH mr-5" title=""></i>
                                    </div>
                                    <div>
                                        <h4 class="no-margin" style="color:#32436f;"> <?= $v->menu_name ?></h4>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <?php } ?>

                    <?php }
                    } ?>
                </div>
            </div>

            <div class="col-md-7">
                <div class="row">
                    <div class="col-md-12">
                        <label for=""><strong>ชุดข้อสอบทั้งหมด
                            </strong></label>
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="col-md-12">
                        <div class="card" style="min-height:410px">
                            <ul
                                class="nav nav-tabs nav-tabs-solid nav-justified bg-indigo-400 border-x-0 border-bottom-0 border-top-indigo-300 mb-0">
                                <li class="nav-item">
                                    <a href="#tab1" class="nav-link font-size-sm text-uppercase active"
                                        data-toggle="tab">
                                        <span class="txt-title">กราฟ</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#tab2" class="nav-link font-size-sm text-uppercase" data-toggle="tab">
                                        <span class="txt-title">ข้อมูล</span>
                                    </a>
                                </li>
                            </ul>
                            <!-- Tabs content -->
                            <div class="tab-content card-body">
                                <div class="tab-pane active fade show" id="tab1">
                                    <canvas id="chart" width="400"></canvas>
                                </div>
                                <div class="tab-pane fade" id="tab2">
                                    <table class="table text-nowrap table-bordered">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">เครื่องมือ</th>
                                                <th scope="col">จำนวนชุดข้อสอบ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 0;
                                            foreach ($dataList["dt"] as $v) {
                                                $i++;
                                            ?>
                                            <tr>
                                                <th scope="row"><?= $i ?></th>
                                                <td><?= $v->tooltype_name ?></td>
                                                <td><?= $v->exam_total ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
//print_r("data:" . json_encode($dataList));
?>
<script>
var ctx = document.getElementById('chart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($dataList['labels']); ?>,
        datasets: [{
            //label: 'ชุดข้อสอบ',
            data: <?= json_encode($dataList['data'], JSON_NUMERIC_CHECK); ?>,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        legend: {
            display: false
        },
        scales: {
            yAxes: [{
                ticks: {
                    //  precision: 0,
                    beginAtZero: true,
                },
            }]
        },
        responsive: true,
        title: {
            display: true,
            text: 'ชุดข้อสอบ จำแนกตามเครื่องมือประเมิน \n'
        },
        animation: {
            duration: 1,
            onComplete: function() {
                var chartInstance = this.chart,
                    ctx = chartInstance.ctx;
                ctx.textAlign = 'center';
                ctx.fillStyle = "rgba(0, 0, 0, 1)";
                ctx.textBaseline = 'bottom';
                // Loop through each data in the datasets
                this.data.datasets.forEach(function(dataset, i) {
                    var meta = chartInstance.controller.getDatasetMeta(i);
                    meta.data.forEach(function(bar, index) {
                        var data = dataset.data[index];
                        ctx.fillText(data, bar._model.x, bar._model.y - 5);

                    });
                });
            }
        }
    }
});
</script>