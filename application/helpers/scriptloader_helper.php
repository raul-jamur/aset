<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('loadcss'))
{
    function loadcss($script=array())
    {
		$ls = '';
		if(sizeof($script))
		{
			for($i=0;$i<sizeof($script);$i++)
			{
				$css = $script[$i];
				
				$ls .= '<link rel="stylesheet" type="text/css" href="';
				switch($css){
					case 'jqueryui' 	: $ls .= base_url().'assets/css/stsi/jquery-ui-1.9.2.custom.css';
										break;				
					case 'jqgrid' 		: $ls .= base_url().'assets/css/ui.jqgrid.css';
										break;
					case 'jqplot' 		: $ls .= base_url().'assets/css/jquery.jqplot.min.css';
										break;
					case 'scroller' 		: $ls .= base_url().'assets/css/scroller.css';
										break;
					case 'calendar' 	: $ls .= base_url().'assets/css/fullcalendar.print.css';
										  $ls .= '" media="print" />'."\n";
										  $ls .= '<link rel="stylesheet" type="text/css" href="';
										  $ls .= base_url().'assets/css/fullcalendar.css';
										break;
					case 'timepicker' 	: $ls .= base_url().'assets/css/jquery-ui-timepicker-addon.css';
										break;
					case 'menu' 		: $ls .= base_url().'assets/css/menu.css';
										break;
					case 'validation' 	: $ls .= base_url().'assets/css/validationEngine.jquery.css';
										break;				
				}
				$ls .= '" media="screen" />'."\n";
			}
			
		}
		return $ls;
    }   
}

if ( ! function_exists('loadjs'))
{
    function loadjs($script=array())
    {
		$ls = '';
        if(sizeof($script))
		{
			for($i=0;$i<sizeof($script);$i++)
			{
				$js = $script[$i];
				
				$ls .= '<script type="text/javascript" src ="';
				switch($js){
					case 'jquery' :	$ls .= base_url().'assets/js/jquery-1.8.3.min.js';
									break;
					case 'jqueryui' :	$ls .= base_url().'assets/js/jquery-ui-1.9.2.custom.min.js';
									break;	
					case 'jam' :	$ls .= base_url().'assets/js/jam.js';
									break;
					case 'jqplot' :	$ls .= base_url().'assets/js/jquery.jqplot.min.js';
									$ls .= '" ></script>'."\n";
									$ls .= '<script type="text/javascript" src ="';
									$ls .= base_url().'assets/js/jqplot.barRenderer.min.js';
									$ls .= '" ></script>'."\n";
									$ls .= '<script type="text/javascript" src ="';
									$ls .= base_url().'assets/js/jqplot.json2.min.js';
									$ls .= '" ></script>'."\n";
									$ls .= '<script type="text/javascript" src ="';
									$ls .= base_url().'assets/js/jqplot.categoryAxisRenderer.min.js';
									$ls .= '" ></script>'."\n";
									$ls .= '<script type="text/javascript" src ="';
									$ls .= base_url().'assets/js/jqplot.canvasTextRenderer.min.js';
									$ls .= '" ></script>'."\n";
									$ls .= '<script type="text/javascript" src ="';
									$ls .= base_url().'assets/js/jqplot.canvasAxisLabelRenderer.min.js';
									$ls .= '" ></script>'."\n";
									$ls .= '<script type="text/javascript" src ="';
									$ls .= base_url().'assets/js/jqplot.pointLabels.min.js';
									break;
					case 'scroller' :	$ls .= base_url().'assets/js/jquery-scroller-v1.js';
									break;
					case 'qtip' :	$ls .= base_url().'assets/js/jquery.qtip-1.0.0-rc3.min.js';
									break;
					case 'calendar' :	$ls .= base_url().'assets/js/fullcalendar-id.js';
									break;		
					case 'jqgrid' : $ls .= base_url().'assets/js/jquery.jqGrid.min.js';
									$ls .= '" ></script>'."\n";
									$ls .= '<script type="text/javascript" src ="';
									$ls .= base_url().'assets/js/grid.locale-id.js';
									break;
					case 'timepicker' : $ls .= base_url().'assets/js/jquery-ui-timepicker-addon.js';
									$ls .= '" ></script>';
									$ls .= '<script type="text/javascript" src ="';
									$ls .= base_url().'assets/js/timepicker-local-id.js';
									break;
					case 'validation' : $ls .= base_url().'assets/js/jquery.validationEngine.js';
									$ls .= '" ></script>'."\n";
									$ls .= '<script type="text/javascript" src ="';
									$ls .= base_url().'assets/js/jquery.validationEngine-en.js';
									break;
				}
				$ls .= '" ></script>'."\n";
			}
			
		}
		return $ls;
    }   
}