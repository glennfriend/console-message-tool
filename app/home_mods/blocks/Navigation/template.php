<?php
    $homeUri = url('');
?>
<div class="navbar navbar-inverse navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="navbar-collapse collapse">

            <ul class="nav navbar-nav">
                <!--
                    <li class="active">Home</li>
                -->
                <li><a href="<?php echo $homeUri; ?>">Home</a></li>
            </ul>

        </div>
    </div>
</div>
