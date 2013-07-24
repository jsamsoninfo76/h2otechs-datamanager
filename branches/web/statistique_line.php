<?php
session_start();
print_r($_SESSION);
?>
		<script type="text/javascript">
$(function () {
        $('#container').highcharts({
            chart: {
                type: 'line',
                marginRight: 130,
                marginBottom: 25
            },
            title: {
                text: <?php echo "'Historique de mesure'"; ?>,
                x: -20 //center
            },
            subtitle: {
            	<?php
            		$subtitles = "text: 'Prelevement de l\'annee ";
            		$datePrecedente = "";
            			foreach($_SESSION['categories'] as $subtitle) {
            				$souschaine = substr($subtitle, 0, 4);
            				if ($datePrecedente != $souschaine){
            					$subtitles .= "$souschaine - ";
            					$datePrecedente = $souschaine;
            				}
            			}
            		$subtitles = substr($subtitles, 0, count($subtitles)-4);
            		
            		$subtitles .= " du " .substr($_SESSION['categories'][0], 5, 7). " au " .substr($_SESSION['categories'][count($_SESSION['categories'])-1], 5, 7);
            		$subtitles .= "',";
            		echo $subtitles;
            	?>
                x: -20
            },
            xAxis: {
            	//Axe des abscisse 
                <?php
            		$categories = "categories: [";
            			foreach($_SESSION['categories'] as $categorie) $categories .= "'" .substr($categorie, 8, 2). "', ";
            		$categories = substr($categories, 0, count($subtitles)-3) . "]";
            		echo $categories;
            	?>
            },
            yAxis: {
            	//Axe des ordonnees
                title: {
                    text: <?php echo "'" .$_SESSION['yAxis_title']. "'"; ?>
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: <?php echo "'" .$_SESSION['tooltip']. "'"; ?>
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -10,
                y: 100,
                borderWidth: 0
            },
            series: [
            	<?php
            		$datas = "";
            		foreach($_SESSION['subtitles'] as $nom){
            			$datas .= "{";
	            		$datas .= "name: '" .$nom. "',";
	            		$datas .= "data: [";
	            		foreach($_SESSION['series'][$nom] as $data){
	            			$datas .= $data.", ";
	            		}
	            		$datas = substr($datas, 0, count($datas)-2);
	            		$datas .= "]";
	            		$datas .= "},";	
            		}
            		//$datas = substr($datas, 0, count($datas)-1);
            		echo $datas;
            	?>
            ]
        });
    });
    

		</script>
  		<script src="include/utile/Highcharts/js/highcharts.js"></script>
  		<script src="include/utile/Highcharts/js/modules/exporting.js"></script>

<div id="container" style="min-width: 600px; height: 500px; margin: 0 auto"></div>

