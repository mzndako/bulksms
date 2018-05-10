<header id="header" >
    <div class="top-bar" style="background-color:  <?=c()->get_template_settings("top_header1");?>">
        <div class="container" style="width: 100%;">
            <div class="row">
                <div class="col-sm-6 col-xs-6">
                    <div class="top-number"><p><i class="fa fa-phone-square"></i>  <?=c()->get_template_settings("phone");?></p></div>
                </div>
                <div class="col-sm-6 col-xs-6" align="right">
                    <div class="social" align="right">
                        <ul class="social-share">
                            <?php
                                $facebook =  c()->get_template_settings("facebook_link");
                                $twitter =  c()->get_template_settings("twitter_link");
                                $linkedin =  c()->get_template_settings("linkedin_link");
                                $skype =  c()->get_template_settings("skype_link");
                            ?>
                            <li><a href="<?=$facebook;?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="<?=$twitter;?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="<?=$linkedin;?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="<?=$skype;?>" target="_blank"><i class="fa fa-skype"></i></a></li>
                        </ul>
<!--                        <div class="search hidden-sm hidden-xs">-->
<!--                            <form role="form">-->
<!--                                <input type="text" class="search-form" autocomplete="off" placeholder="Search">-->
<!--                                <i class="fa fa-search"></i>-->
<!--                            </form>-->
<!--                        </div>-->
                    </div>
                </div>
            </div>
        </div><!--/.container-->
    </div><!--/.top-bar-->

    <nav class="navbar navbar-inverse" role="banner" style="background-color:  <?=c()->get_template_settings("top_header2");?>">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href=""><img src="<?=c()->get_template_image_url("logo");?>" alt="<?=c()->get_template_settings("site_name");?>" height="40px"></a>
            </div>

            <div class="collapse navbar-collapse navbar-right">
                <ul class="nav navbar-nav">
                    <?php
                    $menu = new front_menu();
                    $is_login = is_login();
                    $result = "";

                    foreach($menu->children() as $parent1){
                        $show = getIndex($parent1,'show', "all");
                        $section = getIndex($parent1,'section', "");
                        $link = getIndex($parent1, "link", "");
                        $href = "href='#' ";

                        if(strpos($link,"()") !== false)
                            $href = "href='#' onclick='$link'";
                        elseif($link != "#")
                            $href = "href='".url($link)."'";

                        if(($show == "login" && !$is_login) || ($show == "logout" && $is_login))
                            continue;
                        $add = "";
                        $child = $menu->children($parent1['item_id']);

                        if(!empty($child)){
                            $add = "dropdown";
                        }
                        $result .= "<li class='".(!empty($child)?"dropdown":"")."'><a  data-toggle='$add' $href >$parent1[label]</a>";

                        if(!empty($child)){
                            $result .= "<ul class='dropdown-menu'>";
                            foreach($child as $parent2){
                                $show = getIndex($parent2,'show', "all");
                                if(($show == "login" && !$is_login) || ($show == "logout" && $is_login))
                                    continue;
                                $link = getIndex($parent2, "link", "");
                                $href = "href='#' ";
                                if($link != "#")
                                    $href = "href='".url($link)."'";
                                $result .= "<li><a $href >$parent2[label]</a>";

                            }
                            $result .= "</ul>";
                        }
                        $result .= "</li>";
                    }
                    print $result;
                    ?>


                </ul>
            </div>
        </div><!--/.container-->
    </nav><!--/nav-->

</header><!--/header-->