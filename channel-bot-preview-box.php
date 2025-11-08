<?php
{
    ?>
<div>
    <?php
    $sent_meta=eastweb_wpch_shortcode();
    if($sent_meta!='')
    {
        echo'<div>'.$sent_meta.'</div>';
    }
    else
        echo '<div>هنوز ارسالی توسط کانال خودکار انجام نشده است.</div>';
    ?>
</div>
<?php
}
?>