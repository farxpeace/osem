<?php
$breadcrumb = $this->far_menu->page_title();
?>

			<div class="page-bar">
				<ul class="page-breadcrumb">
                
                
					<li>
						<i class="fa fa-home"></i>
						<a href="<?php echo base_url(); ?>">MAIN</a>
						<i class="fa fa-angle-right"></i>
					</li>
                    
                    <?php
                    $count_breadcrumb = count($this->far_menu->breadcrumb());
                    $last_breadcrumb = $count_breadcrumb-1;
                    foreach($this->far_menu->breadcrumb() as $key => $value){ ?>
                    <?php
                    if($value['link'] == 'ci_controller'){ $menulink = base_url().$value['class'].'/'.$value['method']; }
                    else{ $menulink = $value['link']; }
                    ?>
                        <?php if($last_breadcrumb != $key){ ?>
                        <li>
    						<a href="<?php echo $menulink; ?>"><?php echo $value['name']; ?></a>
                            
                            <i class="fa fa-angle-right"></i>
                            
    						
    					</li>
                        <?php }else{ ?>
                        <li>
    						<a style="text-decoration: none;" href="javascript: void();"><?php echo $value['name']; ?></a>
                            
    					</li>
                        <?php } ?>
                    <?php }
                    ?>
				</ul>
				
			</div>