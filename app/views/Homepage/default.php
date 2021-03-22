<?php
declare(strict_types=1);

use model\Report;

$template ??= new StdClass;
$template->reports ??= [];
$template->lastReport ??= new Report(0, 0, Report::SOIL_HUMIDITY_MAX, 0, new DateTime());
$template->date ??= "";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Chilli</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" crossorigin="anonymous">
</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-md">
			<canvas id="tempChart" width="400" height="100"></canvas>
		</div>
	</div>
    <div class="row">
        <div class="col-md">
            <canvas id="soilChart" width="400" height="100"></canvas>
        </div>
    </div>
    <div class="row">
        <div class="col-md">
            <canvas id="airChart" width="400" height="100"></canvas>
        </div>
    </div>
    <div class="row my-4">
        <div class="col-md-3">
            <input type="text" class="form-control" autocomplete="off" value="<?php echo $template->date; ?>" placeholder="Vyberte datum" id="date" name="date">
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-primary" onclick="selectDate();">Zobrazit</button>
        </div>
        <div class="col-md mx-3">
            <table class="table">
                <tr>
                    <td>Poslední data:</td>
                    <td <?php if($template->lastReport->getTemperature()<15)echo'class="bg-danger"';elseif($template->lastReport->getTemperature()<20)echo'class="bg-warning"';?>>T: <?php echo $template->lastReport->getTemperature(); ?> °C</td>
                    <td <?php if($template->lastReport->getSoilHumidityPercent()<60)echo'class="bg-danger"';elseif($template->lastReport->getSoilHumidityPercent()<70)echo'class="bg-warning"';?>>VP: <?php echo $template->lastReport->getSoilHumidityPercent(); ?> %</td>
                    <td>VV: <?php echo $template->lastReport->getAirHumidity(); ?> %</td>
                </tr>
            </table>
        </div>
    </div>
</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.min.js" integrity="sha512-SuxO9djzjML6b9w9/I07IWnLnQhgyYVSpHZx0JV97kGBfTIsUYlWflyuW4ypnvhBrslz1yJ3R+S14fdCWmSmSA==" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
	<script>
        $("#date").datepicker({ dateFormat: 'dd.mm.yy' });

        function selectDate() {
            let url = document.location.origin;
            if ($("#date").val() !== "") {
                document.location.href = url + "/homepage/default/?date=" + $("#date").val();
            } else {
                document.location.href = url + "/homepage/default/";
            }
        }

        var ctx = document.getElementById('tempChart');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
					<?php
					/** @var Report $report */
					foreach ($template->reports as $report) {
						echo "\"" . $report->getDateTime()->format("d.m H:i") . "\", ";
					}
					?>
                ],
                datasets: [{
                    label: 'Teplota °C',
                    data: [
                        <?php
                            /** @var Report $report */
                            foreach ($template->reports as $report) {
                                echo $report->getTemperature() . ", ";
                            }
                        ?>
                    ],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        var ctx2 = document.getElementById('soilChart');
        var myChart2 = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: [
					<?php
					/** @var Report $report */
					foreach ($template->reports as $report) {
						echo "\"" . $report->getDateTime()->format("d.m H:i") . "\", ";
					}
					?>
                ],
                datasets: [{
                    label: 'Vlhkost půdy %',
                    data: [
						<?php
						/** @var Report $report */
						foreach ($template->reports as $report) {
							echo $report->getSoilHumidityPercent() . ", ";
						}
						?>
                    ],
                    backgroundColor: 'rgba(90,231,59,0.2)',
                    borderColor: 'rgba(66,203,34,1)',
                    borderWidth: 1
                }]
            },
        });

        var ctx3 = document.getElementById('airChart');
        var myChart3 = new Chart(ctx3, {
            type: 'line',
            data: {
                labels: [
					<?php
					/** @var Report $report */
					foreach ($template->reports as $report) {
						echo "\"" . $report->getDateTime()->format("d.m H:i") . "\", ";
					}
					?>
                ],
                datasets: [{
                    label: 'Vlhkost vzduchu %',
                    data: [
						<?php
						/** @var Report $report */
						foreach ($template->reports as $report) {
							echo $report->getAirHumidity() . ", ";
						}
						?>
                    ],
                    backgroundColor: 'rgba(20,24,239,0.2)',
                    borderColor: 'rgba(34,102,203,1)',
                    borderWidth: 1
                }]
            },
        });
	</script>
</body>
</html>
