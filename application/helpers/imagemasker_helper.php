<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('imagemasker'))
{
    function imagemasker()
    {
        /*$_im = '<script type="text/javascript" src="'.base_url().'assets/js/jquery-1.8.3.min.js" ></script>';*/
		$_im = '<script type="text/javascript">';
        $_im .= 'if(!window.jQuery) {';
        $_im .= '    var script = document.createElement("script");';
        $_im .= '    script.src = "'.base_url().'assets/js/jquery-1.8.3.min.js";';
        $_im .= '    script.type = "text/javascript";';
        $_im .= '    document.getElementsByTagName("head")[0].appendChild(script);';
		
		$_im .= '    var script2 = document.createElement("script");';
        $_im .= '    script2.src = "'.base_url().'assets/js/imagemasker.js";';
        $_im .= '    script2.type = "text/javascript";';
        $_im .= '    document.getElementsByTagName("body")[0].appendChild(script2);';
		
        $_im .= '}else{';
        $_im .= '$(document).ready(function(){';
        $_im .= '    $("#content img").each(function(){';
        $_im .= '        var h = $(this).height();';
        $_im .= '        var w = $(this).width();';
        $_im .= '        var a = $(this).attr("src");';
        $_im .= '        var p = $(this).position();';
        $_im .= '        var i = $("img").index(this);';
        //$_im .= '//$(this).attr("src","'.base_url("assets/images/blank.png").'");';
        //$_im .= '//$(this).css({"height":h, "width":w, "background":"url('"+a+"') no-repeat"});';
        $_im .= '        var newEl = document.createElement("div");';
        $_im .= '        newEl.id = "mask"+i;';
        $_im .= '        document.getElementById("content").appendChild(newEl);';
        //$_im .= '        $("#mask"+i).css({"height":h, "width":w, "background":"url(\'"+a+"\') no-repeat", "position":"absolute","left":p.left,"top":p.top});';
        $_im .= '        $("#mask"+i).css({"height":h, "width":w, "background":"url(\''.base_url("assets/images/blank.png").'\') no-repeat", "position":"absolute","left":p.left,"top":p.top});';
        $_im .= '    });';
        $_im .= '});';
		$_im .= '};';
        $_im .= '</script>';
		
		return $_im;
    }   
}