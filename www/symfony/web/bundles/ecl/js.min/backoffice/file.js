$(document).ready(function(){function e(){var e=new Date,n=e.getMonth()+1,o=e.getFullYear();10>n&&(n="0"+n),$("[data-year="+o+"]",t).show("slow",function(){$("[data-month="+n+"]",t).show("slow")})}var t=$("#file_list_wrapper");$(function(){$("#upload_file_button").after('<button class="upload_button">Subir</button>'),$(".upload_button").click(function(e){e.preventDefault(),$(this).prev($("input[type=file]")).click()})}),$("#upload_file_button").change(function(n){var o=new XMLHttpRequest,s=n.target.files[0];$("#inner_progress_bar").css("width",0).fadeIn(),$("#progress_bar").fadeIn(),o.onreadystatechange=function(){4==o.readyState&&(t.html(o.response).hide().fadeIn("slow",function(){e()}),$("#progress_bar").fadeOut())},o.open("POST",FILE_UPLOAD_URL,!0),o.setRequestHeader("X-Requested-With","XMLHttpRequest"),o.setRequestHeader("X_FILENAME",s.name),o.addEventListener("progress",function(e){e.lengthComputable&&$("#inner_progress_bar").css("width",100*e.loaded/e.total+"%")}),o.send(s)}),$("#remove").click(function(){var e={file:[]};$(":checked").each(function(){e.file.push($(this).val())}),$.post(REMOVE_FILE_URL,{"file[]":e},function(e){console.log(e),$("#file_list_wrapper :checked").closest("li").fadeOut("slow",function(){$(this).remove()}),$("#remove").fadeOut()})}),t.on("change","input",function(){$(this).prop("checked")?$("#remove").fadeIn():$(":checked",t).length||$("#remove").fadeOut()}),t.on("click",".folder",function(){$(this).hasClass("open_folder")?($(this).removeClass("open_folder"),$(this).next("ul").hide("slow")):($(this).addClass("open_folder"),$(this).next("ul").show("slow"))})});