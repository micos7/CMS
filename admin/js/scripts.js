tinymce.init({ selector:'textarea' });

$(document).ready(function(){
$('#selectAllBoxes').click(function(e){
if(this.checked){
    $('.checkBoxes').each(function(){
        this.checked = true;
    });
} else {
$('.checkBoxes').each(function(){
        this.checked = false;
    });
}
})
var div_box = '<div id="load-screen"><div id="loading"></div></div>';

$("body").prepend(div_box);
$("#load-screen").delay(700).fadeOut(600,function(){
    $(this).remove();
})
});

function loadUsersOnline(){
    $.get('functions.php?onlineusers=result',function(data){
        $(".usersonline").text(data);
    });
}
//todo on some pages it doenst display users
setInterval(function(){
loadUsersOnline();
},700);

