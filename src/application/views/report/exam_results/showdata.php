
<div class="row">
    <div class="col-md-4 ">
        <div class="card  box-outline-primary" style=' background-color: #fff '>
            <div class="card-body">
                <div class="card-title">
                    <div>
                        <span class="txt-title-asmtool">จำนวนการประเมินทั้งหมด (คน)</span>
                    </div>
                    <div class="text-right ">
                        <span style='  font-size: 30px ' class="text-warning txt-count-exam">
                        <?=number_format($data['result_total'])?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card box-outline-primary" style=' background-color:#fff '>
            <div class="card-body">
                <div class="card-title">
                    <div class="">
                        <span  class="txt-title-asmtool">จำนวนผู้สอบผ่าน (คน)</span>
                    </div>
                    <div class="text-right ">
                        <span style='  font-size: 30px ' class="text-warning txt-count-exam">  <?=number_format($data['pass'])?></span>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card box-outline-primary" style=' background-color: #fff '>
            <div class="card-body">
                <div class="card-title">
                    <div>
                        <span class="txt-title-asmtool">จำนวนผู้สอบไม่ผ่าน (คน)</span>
                    </div>
                    <div class="text-right">
                        <span style='  font-size: 30px 'class="text-warning txt-count-exam">  <?=number_format($data['no_pass'])?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

$asm_tool = $this->MasterDataModel->tool_type_array();
?>
<div class="row">
<div class="col-md-12">
<canvas id="myChart" width="400" height="100"></canvas>
<script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['<?=$asm_tool[2]['name']?>', '<?=$asm_tool[3]['name']?>', '<?=$asm_tool[4]['name']?>',
         '<?=$asm_tool[5]['name']?>', '<?=$asm_tool[6]['name']?>', '<?=$asm_tool[7]['name']?>'],
        datasets: [{

            label: 'สอบผ่าน',
            data: ['<?=$data['portfolio_pass']?>', '<?=$data['interview_pass']?>', '<?=$data['simulation_pass']?>',
            '<?=$data['demonstration_pass']?>', '<?=$data['observation_pass']?>', '<?=$data['thirdparty_pass']?>'],
            backgroundColor: [
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        },{
            label: 'สอบไม่ผ่าน',
            data: ['<?=$data['portfolio_no_pass']?>', '<?=$data['interview_no_pass']?>', '<?=$data['simulation_no_pass']?>',
            '<?=$data['demonstration_no_pass']?>', '<?=$data['observation_no_pass']?>', '<?=$data['thirdparty_no_pass']?>'],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 99, 132, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                   /* suggestedMin: 1,
                    suggestedMax: 100*/
                   // stepSize: 100,

                },

            }]
        }
    }
});
</script>
</div>

</div>
<?php
