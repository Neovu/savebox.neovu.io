<?php
$user = & JFactory::getUser();
if ($user->guest) {
    $idadmin = 0;
    $idname = "convidado";
} else {
    $idadmin = $user->id;
    //$idname = $user->username;
}
?>
 
<script type="text/javascript">
    
    (function($) {

        $(document).ready(function($) {
            $('body').append('<input type="hidden" value="<? echo $idadmin; ?>" id="adminID" />');
            
            var url = '<div id="controlfrog"><iframe id="home-frame" src="controlfrog/layouts/b/layout-1.html"></iframe><div>';
            $('#rt-mainbody-surround').html(url);
            $('#controlfrog, #home-frame').css("height", window.innerHeight-60);
            
            $('#home-frame').bind('load', function() {
                $('#rt-mainbody-surround').show();
                $('#home-frame').show();
            });
        });
    })(jQuery);


</script> 