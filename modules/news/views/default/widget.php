<?php
/**
 * Created by PhpStorm.
 * User: johny
 * Date: 27.08.2017
 * Time: 0:22
 * @var $this yii\web\View
 */

$this->title = 'Виджет';

$this->registerJsFile('/js/vendor.js',['position' => yii\web\View::POS_END]);
$this->registerJsFile('/js/widget.js?v='.rand(),['position' => yii\web\View::POS_END]);

$this->registerCssFile('/js/vendor.css');
$this->registerCssFile('/js/widget.css');

?>
<div id="widget" class="thumbnail widget">
	<div class="navigation-box">
		<div class="tabs-container"></div>
		<div id="news_list" class="list-news"></div>
	</div>
	<div class="graph-box">
		<div class="graph-news-box">
			<div class="news-info-title"></div>
			<div class="graph-parent">
				<div class="candle-stick-box-left">
					<div class="news-item-tabs">
						<div class="news-data-period-tabs">
							<div id="period_tabs_left"></div>
						</div>
						<div class="news-data-fintool-box"></div>
					</div>
					<div id="newsdata_candle_stick_left" class="candle-stick-left"></div>
				</div>
				<div class="candle-stick-box-right">
					<div class="news-item-tabs">
						<div class="news-data-period-tabs">
							<div id="period_tabs_right"></div>
						</div>
						<div class="news-data-fintool-box"></div>
					</div>
					<div  id="newsdata_candle_stick_right" class="candle-stick-right"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<button id="gmi" class="btn btn-default">Жми</button>
