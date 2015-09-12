<?php
/**
 * Charts 4 PHP
 *
 * @author Shani <support@chartphp.com> - http://www.chartphp.com
 * @version 1.2.1
 * @license: see license.txt included in package
 */

 error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED); ini_set("display_errors","off");  class chartphp { 	var $data; var $title; var $xlabel; var $ylabel; var $Vf6d4126bfe77544af565648cf3b6e3; var $chart_type; var $width; var $height;	 	var $options;	 	var $intervals; var $Vb2507468f95156358fa490fd543ad2; var $series_label; var $direction;  	function chartphp() 	{  $this->width = "90%"; $this->height = "90%"; $this->chart_type = "line"; $this->xlabel = ""; $this->ylabel = ""; $this->Vf6d4126bfe77544af565648cf3b6e3= ""; $this->title = ""; $this->color = ""; $this->Vb2507468f95156358fa490fd543ad2= true; $this->series_label = array(); $this->direction = ""; $this->options = array(); }  	function render($Vb80bb7740288fda1f201890375a60c) 	{  ob_start();   $this->options["title"]["text"] = $this->title; $this->options["title"]["textColor"] = "black"; $this->options["title"]["fontFamily"] = "RobotoRegular,Arial,Helvetica,sans-serif"; $this->options["title"]["fontSize"] = "20px";     $this->options["seriesColors"] = array("#008EE4","#6BAA01","#e44a00","#33bdda","#583e78","#91D100","#E1B700","#FF76BC","#00A3A3","#FE7C22","#f8bd19");    $this->options["animate"] = false;   $this->options["grid"]["backgroundColor"] = "white"; $this->options["grid"]["borderWidth"] = 1; $this->options["grid"]["shadow"] = false; $this->options["grid"]["borderColor"] = "#B3B3B3"; $this->options["grid"]["drawBorder"] = false; $this->options["grid"]["drawGridlines"] = true; $this->options["grid"]["gridLineColor"] = "#E8E8E8"; $this->options["legend"]["show"] = false; $this->options["legend"]["textColor"] = "black"; $this->options["legend"]["fontFamily"] = "RobotoRegular"; $this->options["legend"]["placement"] = "inside"; $this->options["axesDefaults"]["labelRenderer"] = "$.jqplot.CanvasAxisLabelRenderer"; $this->options["axesDefaults"]["labelOptions"]["fontFamily"] = "RobotoRegular,Arial,Helvetica,sans-serif"; $this->options["axesDefaults"]["tickOptions"]["fontFamily"] = "RobotoRegular,Arial,Helvetica,sans-serif";   $this->options["axes"]["xaxis"]["label"] = $this->xlabel; $this->options["axes"]["xaxis"]["tickRenderer"] = "$.jqplot.CanvasAxisTickRenderer"; $this->options["axes"]["xaxis"]["tickOptions"]["angle"] = 0; $this->options["axes"]["xaxis"]["autoscale"] = true;      $this->options["axes"]["yaxis"]["label"] = $this->ylabel; $this->options["axes"]["yaxis"]["tickRenderer"] = "$.jqplot.CanvasAxisTickRenderer"; $this->options["axes"]["yaxis"]["pad"] = 1.1; $this->options["axes"]["yaxis"]["autoscale"] = true;        $this->options["seriesDefaults"]["rendererOptions"]["smooth"] = true; $this->options["seriesDefaults"]["rendererOptions"]["animation"]["show"] = true; $this->options["seriesDefaults"]["rendererOptions"]["animation"]["speed"] = 2500;    if ($this->chart_type=="area")  {   $this->options["seriesDefaults"]["fillAlpha"] = 0.3;   $this->options["seriesDefaults"]["fill"]=true;    $this->options["seriesDefaults"]["fillAndStroke"]=true;   $this->options["axes"]["xaxis"]["renderer"] = "$.jqplot.CategoryAxisRenderer"; $this->options["highlighter"]["show"] = true; $this->options["highlighter"]["sizeAdjust"] = 7.5; $this->options["axes"]["xaxis"]["tickOptions"]["angle"] = -45; }    else if ($this->chart_type=="bubble")  {  $this->options["seriesDefaults"][renderer] = "$.jqplot.BubbleRenderer"; $this->options["seriesDefaults"][shadow] = true; $this->options["seriesDefaults"][shadowAlpha] = 0.1;     $this->options["seriesDefaults"][rendererOptions][showLabels] = true; $this->options["seriesDefaults"][rendererOptions][bubbleGradients] = true; }    else if ($this->chart_type=="line")  {  $this->options["axes"]["xaxis"]["renderer"] = "$.jqplot.CategoryAxisRenderer"; $this->options["highlighter"]["show"] = true; $this->options["highlighter"]["sizeAdjust"] = 7.5; $this->options["axes"]["xaxis"]["tickOptions"]["angle"] = 0; $this->options["legend"]["show"] = true;    $this->options["series"]= array("ABC","BCD"); }    else if ($this->chart_type=="bar")  {  $this->options["axes"]["xaxis"]["tickOptions"]["angle"] = -45; $this->options["seriesDefaults"]["renderer"] = "$.jqplot.BarRenderer"; $this->options["seriesDefaults"]["pointLabels"]["show"] = true; $this->options["axes"]["xaxis"]["renderer"] = "$.jqplot.CategoryAxisRenderer";    $this->options["highlighter"]["show"] = false; $this->options["seriesColors"] = array("#1AAF5D","#F2C500","#F45B00","#8E0000","#0E948C","#6666FF","#996699", "#FF6633", "#336633", "#FF66FF", "#3300CC", "#660033", "#000033", ); }    else if ($this->chart_type == "bar-stacked")  {    $Vf644bb32e0243d906e4a187b6b00d2 = array(); if(!empty($this->series_label) && $this->chart_type == "bar-stacked")  {  foreach($this->series_label as $V2db95e8e1a9267b7a1188556b2013b)  $Vf644bb32e0243d906e4a187b6b00d2[] = array('label'=>$V2db95e8e1a9267b7a1188556b2013b); }   $this->options["legend"]["show"] = true; $this->options["legend"]["placement"] = 'outside'; $this->options["legend"]["location"] = 'e'; $this->options["stackSeries"] = true; $this->options["series"]= $Vf644bb32e0243d906e4a187b6b00d2; $this->options["seriesDefaults"]["renderer"] = "$.jqplot.BarRenderer"; $this->options["seriesDefaults"]["pointLabels"]["show"] = true; $this->options["seriesDefaults"]["rendererOptions"]["highlightMouseDown"] = true;     $this->options["highlighter"]["show"] = true;       if ($this->direction == "horizontal")  {  $this->options["axes"]["yaxis"]["renderer"] = "$.jqplot.CategoryAxisRenderer"; $this->options["seriesDefaults"]["rendererOptions"]["barDirection"] = 'horizontal'; $this->options["axes"]["xaxis"]["min"] = 0; } else  {  $this->options["seriesDefaults"]["rendererOptions"]["barDirection"] = 'vertical'; $this->options["axes"]["xaxis"]["renderer"] = "$.jqplot.CategoryAxisRenderer"; $this->options["axes"]["yaxis"]["min"] = 0; } }    else if ($this->chart_type=="pie")  {  $this->options["seriesDefaults"]["renderer"] = "$.jqplot.PieRenderer"; $this->options["seriesDefaults"]["rendererOptions"]["showDataLabels"] = true; $this->options["seriesDefaults"]["rendererOptions"]["dataLabels"] = "percent";         $this->options["legend"]["show"] = true; $this->options["legend"]["location"] = 'e'; }	     else if ($this->chart_type=="donut")  {  $this->options["seriesDefaults"]["renderer"] = "$.jqplot.DonutRenderer"; $this->options["seriesDefaults"]["rendererOptions"]["showDataLabels"] = true; $this->options["seriesDefaults"]["rendererOptions"]["dataLabels"] = 'percent'; $this->options["seriesDefaults"]["rendererOptions"]["sliceMargin"] = 3; $this->options["seriesDefaults"]["rendererOptions"]["startAngle"] = -90;    $this->options["legend"]["show"] = true; $this->options["legend"]["location"] = 'e'; }    else if ($this->chart_type=="meter")  {  $this->options["seriesDefaults"]["renderer"] = "$.jqplot.MeterGaugeRenderer";     $this->options["seriesDefaults"]["rendererOptions"]["intervals"] = $this->intervals; $this->options["seriesDefaults"]["rendererOptions"]["intervalColors"] = array('#1fb828', '#fffc2a', '#ff9900', '#dc3912'); $this->options["seriesDefaults"]["rendererOptions"]["background"] = '#FFFFFF'; $this->options["seriesDefaults"]["rendererOptions"]["ringColor"] = '#2C4D75'; $this->options["seriesDefaults"]["rendererOptions"]["tickColor"] = '#2C4D75'; }    else if ($this->chart_type=="funnel")  {  $this->options["seriesDefaults"]["renderer"] = "$.jqplot.FunnelRenderer"; $this->options["seriesDefaults"]["rendererOptions"]["datalabels"] = "percent"; $this->options["seriesDefaults"]["rendererOptions"]["showDataLabels"] = true; $this->options["legend"]["show"] = true; $this->options["legend"]["location"] = 'e'; }    if (!empty($this->color))  {  $V62848e3ce5804aa985513a7922ff87 = explode(",",$this->color); $V62848e3ce5804aa985513a7922ff87 = array_map('trim', $V62848e3ce5804aa985513a7922ff87); $this->options["seriesColors"] = $V62848e3ce5804aa985513a7922ff87; }     if ($this->x_data_type == "date")  {  $this->options["axes"]["xaxis"]["renderer"] = "$.jqplot.DateAxisRenderer"; $this->options["axes"]["xaxis"]["tickOptions"]["formatString"] = '%b %Y';    if (count($this->data[0]) >= 10)  $this->options["axes"]["xaxis"]["numberTicks"] = 10; } else  {    if (count($this->data[0]) >= 10)  $this->options["axes"]["xaxis"]["numberTicks"] = 20; }   if (is_array($this->data))  $V785064f04ce95287380ffb9a8891c7 = json_encode($this->data);   else  $V785064f04ce95287380ffb9a8891c7 = $this->data;   ?>    <div style="position:relative;">   <div id="<?php echo $Vb80bb7740288fda1f201890375a60c?>" style="height:<?php echo $this->height ?>; width:<?php echo $this->width ?>;"></div>  </div>  <script>  $(document).ready(function(){  var plot_<?php echo $Vb80bb7740288fda1f201890375a60c?> = $.jqplot('<?php echo $Vb80bb7740288fda1f201890375a60c?>', <?php echo $V785064f04ce95287380ffb9a8891c7 ?>, <?php echo F8f64b3a805e991344726939f53bf57($this->options) ?> );   jQuery('#<?php echo $Vb80bb7740288fda1f201890375a60c?>_export').show();   jQuery(window).bind("resize", function () {    setTimeout(function(){  plot_<?php echo $Vb80bb7740288fda1f201890375a60c?>.destroy(); plot_<?php echo $Vb80bb7740288fda1f201890375a60c?> = $.jqplot('<?php echo $Vb80bb7740288fda1f201890375a60c?>', <?php echo $V785064f04ce95287380ffb9a8891c7 ?>, <?php echo F8f64b3a805e991344726939f53bf57($this->options) ?> ); },50); });   });	    </script>  <?php  $V341be97d9aff90c9978347f66f945b = ob_get_clean(); return $V341be97d9aff90c9978347f66f945b; } }   function F8f64b3a805e991344726939f53bf57($Va43c1b0aa53a0c908810c06ab1ff39=array(), $V4b5bea44af9baf871f58e4ecb54526=array(), $Vc9e9a848920877e76685b2e4e76de3=0) { 	foreach($Va43c1b0aa53a0c908810c06ab1ff39 as $V3c6e0b8a9c15224a8228b9a98ca153=>$V2063c1608d6e0baf80249c42e2be58) 	{  if (is_array($V2063c1608d6e0baf80249c42e2be58))  {  $V2cb9df9898e55fd0ad829dc202ddbd = F8f64b3a805e991344726939f53bf57($V2063c1608d6e0baf80249c42e2be58, $V4b5bea44af9baf871f58e4ecb54526, 1); $Va43c1b0aa53a0c908810c06ab1ff39[$V3c6e0b8a9c15224a8228b9a98ca153]=$V2cb9df9898e55fd0ad829dc202ddbd[0]; $V4b5bea44af9baf871f58e4ecb54526=$V2cb9df9898e55fd0ad829dc202ddbd[1]; } else  {  if (substr($V2063c1608d6e0baf80249c42e2be58,0,2)=='$.')  {  $V19b0bee6b072408fc38b5d76725b76="#".rand()."#"; $V4b5bea44af9baf871f58e4ecb54526[$V19b0bee6b072408fc38b5d76725b76]=$V2063c1608d6e0baf80249c42e2be58; $Va43c1b0aa53a0c908810c06ab1ff39[$V3c6e0b8a9c15224a8228b9a98ca153]=$V19b0bee6b072408fc38b5d76725b76; }    else if (substr($V2063c1608d6e0baf80249c42e2be58,0,2)=='[{')  {  $V19b0bee6b072408fc38b5d76725b76="#".rand()."#"; $V4b5bea44af9baf871f58e4ecb54526[$V19b0bee6b072408fc38b5d76725b76]=$V2063c1608d6e0baf80249c42e2be58; $Va43c1b0aa53a0c908810c06ab1ff39[$V3c6e0b8a9c15224a8228b9a98ca153]=$V19b0bee6b072408fc38b5d76725b76; } else if (substr($V2063c1608d6e0baf80249c42e2be58,0,3)=='!$.')  {  $V19b0bee6b072408fc38b5d76725b76="#".rand()."#"; $V4b5bea44af9baf871f58e4ecb54526[$V19b0bee6b072408fc38b5d76725b76]=$V2063c1608d6e0baf80249c42e2be58; $Va43c1b0aa53a0c908810c06ab1ff39[$V3c6e0b8a9c15224a8228b9a98ca153]=$V19b0bee6b072408fc38b5d76725b76; } } } if ($Vc9e9a848920877e76685b2e4e76de3==1) 	{  return array($Va43c1b0aa53a0c908810c06ab1ff39, $V4b5bea44af9baf871f58e4ecb54526); } else 	{  $V7648c463fc599b54a77f6d6dcbd693 = json_encode($Va43c1b0aa53a0c908810c06ab1ff39); foreach($V4b5bea44af9baf871f58e4ecb54526 as $V3c6e0b8a9c15224a8228b9a98ca153=>$V2063c1608d6e0baf80249c42e2be58)  {  $V7648c463fc599b54a77f6d6dcbd693 = str_replace('"'.$V3c6e0b8a9c15224a8228b9a98ca153.'"', $V2063c1608d6e0baf80249c42e2be58, $V7648c463fc599b54a77f6d6dcbd693); } return $V7648c463fc599b54a77f6d6dcbd693; } } 